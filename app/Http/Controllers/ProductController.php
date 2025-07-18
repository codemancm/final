<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\XmrPriceController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    /**
     * Allowed mime types for product pictures
     */
    private $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ];
    /**
     * Display a listing of all active products with search and filter options.
     */
    public function index(Request $request)
    {
        try {
            // Validate all inputs
            $validated = $request->validate([
                'search' => ['nullable', 'string', 'min:1', 'max:80'],
                'vendor' => ['nullable', 'string', 'min:1', 'max:16'],
                'type' => ['nullable', Rule::in([Product::TYPE_DIGITAL, Product::TYPE_CARGO, Product::TYPE_DEADDROP])],
                'category' => ['nullable', 'integer', 'exists:categories,id'],
                'sort_price' => ['nullable', Rule::in(['asc', 'desc'])],
            ]);

            // Get only filled parameters
            $filters = collect($request->only(['search', 'vendor', 'type', 'category', 'sort_price']))
                ->filter(function ($value) {
                    return $value !== null && $value !== '';
                })
                ->toArray();

            $query = Product::with(['user' => function ($query) {
                $query->select('id', 'username');
            }])
            ->select('products.*')
            ->active()
            ->whereHas('user', function($query) {
                $query->whereDoesntHave('vendorProfile', function($q) {
                    $q->where(function($subQuery) {
                        $subQuery->where('vacation_mode', true)
                                ->orWhere(function($privShop) {
                                    $privShop->where('private_shop_mode', true)
                                            ->whereNotExists(function($ref) {
                                                $ref->select(\DB::raw(1))
                                                    ->from('private_shops')
                                                    ->whereColumn('private_shops.vendor_id', 'users.id')
                                                    ->where('private_shops.user_id', auth()->id() ?: 0);
                                            });
                                });
                    });
                })
                ->orWhereHas('vendorProfile', function($q) {
                    $q->where('vacation_mode', false)
                      ->where(function($subQuery) {
                          $subQuery->where('private_shop_mode', false)
                                  ->orWhereExists(function($ref) {
                                      $ref->select(\DB::raw(1))
                                          ->from('private_shops')
                                          ->whereColumn('private_shops.vendor_id', 'users.id')
                                          ->where('private_shops.user_id', auth()->id() ?: 0);
                                  });
                      });
                });
            });

            // Apply search filters with proper sanitization
            if (isset($filters['search'])) {
                $searchTerm = strip_tags($filters['search']);
                $query->where('name', 'like', '%' . addcslashes($searchTerm, '%_') . '%');
            }

            if (isset($filters['vendor'])) {
                $vendorTerm = strip_tags($filters['vendor']);
                $query->whereHas('user', function ($q) use ($vendorTerm) {
                    $q->where('username', 'like', '%' . addcslashes($vendorTerm, '%_') . '%');
                });
            }

            if (isset($filters['type'])) {
                $query->ofType($filters['type']);
            }

            if (isset($filters['category'])) {
                $query->where('category_id', (int) $filters['category']);
            }

            // Apply price sorting
            if (isset($filters['sort_price'])) {
                $query->orderBy('price', $filters['sort_price']);
            } else {
                // Randomize the order of products if no specific sorting is requested
                $query->inRandomOrder();
            }

            // Get paginated results and append only non-empty filters
            $products = $query->paginate(12)->withQueryString();

            $categories = Category::select('id', 'name')->get();

            // Modified redirect logic to exclude 'page' parameter
            $requestParams = $request->except('page');
            if (count($requestParams) > count($filters)) {
                return redirect()->route('products.index', $filters);
            }

            return view('products.index', [
                'products' => $products,
                'categories' => $categories,
                'currentType' => $filters['type'] ?? null,
                'filters' => $filters
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->errors()->all();
            $errorMessage = implode(' ', $errorMessages);
            
            return redirect()
                ->route('products.index')
                ->with('error', $errorMessage)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('products.index')
                ->with('error', 'An error occurred while processing your request.');
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product, XmrPriceController $xmrPriceController)
    {
        try {
            $xmrPrice = $xmrPriceController->getXmrPrice();
            $xmrPrice = (is_numeric($xmrPrice) && $xmrPrice > 0) 
                ? $product->price / $xmrPrice
                : $xmrPrice; // Preserve 'UNAVAILABLE' string

            // Check if product is active
            if (!$product->active) {
                abort(404);
            }

            // Load necessary relationships
            $product->load([
                'user:id,username',
                'user.vendorProfile:id,user_id,vacation_mode,private_shop_mode,vendor_policy',
                'category:id,name'
            ]);

            // Check if vendor is in vacation mode
            if ($product->user->vendorProfile && $product->user->vendorProfile->vacation_mode) {
                return view('products.show', [
                    'product' => $product,
                    'title' => $product->name,
                    'vendor_on_vacation' => true,
                    'vendor_shop_private' => false
                ]);
            }

            // Check if vendor is in private shop mode
            if ($product->user->vendorProfile && $product->user->vendorProfile->private_shop_mode) {
                // Check if current user has saved this vendor's reference code
                $hasReferenceCode = false;
                if (Auth::check()) {
                    $hasReferenceCode = \DB::table('private_shops')
                        ->where('user_id', Auth::id())
                        ->where('vendor_id', $product->user->id)
                        ->exists();
                }

                // If user hasn't saved the reference code, show private shop message
                if (!$hasReferenceCode) {
                    return view('products.show', [
                        'product' => $product,
                        'title' => $product->name,
                        'vendor_on_vacation' => false,
                        'vendor_shop_private' => true
                    ]);
                }
            }

            // Get the formatted measurement unit
            $measurementUnits = Product::getMeasurementUnits();
            $formattedMeasurementUnit = $measurementUnits[$product->measurement_unit] ?? $product->measurement_unit;

            // Get formatted options with XMR price
            $formattedBulkOptions = $product->getFormattedBulkOptions($xmrPrice);
            $formattedDeliveryOptions = $product->getFormattedDeliveryOptions($xmrPrice);

            // Load product reviews with user information
            $reviews = \App\Models\ProductReviews::getProductReviews($product->id);
            
            // Get review statistics
            $positivePercentage = $product->getPositiveReviewPercentage();
            $positiveCount = $product->getPositiveReviewsCount();
            $mixedCount = $product->getMixedReviewsCount();
            $negativeCount = $product->getNegativeReviewsCount();
            $totalReviews = $positiveCount + $mixedCount + $negativeCount;

            return view('products.show', [
                'product' => $product,
                'title' => $product->name,
                'vendor_on_vacation' => false,
                'vendor_shop_private' => false,
                'xmrPrice' => $xmrPrice,
                'formattedMeasurementUnit' => $formattedMeasurementUnit,
                'formattedBulkOptions' => $formattedBulkOptions,
                'formattedDeliveryOptions' => $formattedDeliveryOptions,
                'reviews' => $reviews,
                'positivePercentage' => $positivePercentage,
                'positiveCount' => $positiveCount,
                'mixedCount' => $mixedCount,
                'negativeCount' => $negativeCount,
                'totalReviews' => $totalReviews
            ]);

        } catch (\Exception $e) {
            return redirect()
                ->route('products.index')
                ->with('error', 'An error occurred while loading the product.');
        }
    }

    /**
     * Display the product picture.
     */
    public function showPicture($filename)
    {
        try {
            // Check if the user is authenticated
            if (!Auth::check()) {
                abort(403, 'Unauthorized action.');
            }

            // If it's the default picture, serve it from the public directory
            if ($filename === 'default-product-picture.png') {
                return response()->file(public_path('images/default-product-picture.png'));
            }

            // Get the path to the image
            $path = 'product_pictures/' . $filename;

            // Check if the file exists
            if (!Storage::disk('private')->exists($path)) {
                throw new Exception('Product picture not found');
            }

            // Get the file content
            $file = Storage::disk('private')->get($path);

            // Verify file type using finfo
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($file);

            if (!in_array($mimeType, $this->allowedMimeTypes)) {
                throw new Exception('Invalid file type');
            }

            // Create the response
            $response = Response::make($file, 200);
            $response->header("Content-Type", $mimeType);

            return $response;
        } catch (Exception $e) {
            Log::error('Failed to retrieve product picture: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'filename' => $filename
            ]);
            
            // If the picture is not found or invalid, return the default picture
            return response()->file(public_path('images/default-product-picture.png'));
        }
    }
}
