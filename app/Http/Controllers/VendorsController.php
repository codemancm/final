<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Product;
use App\Models\ProductReviews;
use App\Models\Dispute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class VendorsController extends Controller
{
    /**
     * Display a listing of vendors.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $vendors = User::whereHas('roles', function($query) {
                $query->where('name', 'vendor');
            })
            ->with('profile') // Include profile relationship
            ->get(['id', 'username']); // Only get necessary fields

            return view('vendors.index', compact('vendors'));
        } catch (Exception $e) {
            Log::error('Error fetching vendors list: ' . $e->getMessage());
            return view('vendors.index', ['vendors' => collect()])->with('error', 'Unable to load vendors at this time.');
        }
    }

    /**
     * Display the specified vendor.
     *
     * @param  string  $username
     * @return \Illuminate\View\View
     */
    public function show($username)
    {
        try {
            // Get vendor with their profile and products
            $vendor = User::whereHas('roles', function($query) {
                $query->where('name', 'vendor');
            })
            ->with(['vendorProfile', 'profile', 'pgpKey']) // Include profiles and pgp key
            ->where('username', $username)
            ->firstOrFail(['id', 'username']);

            // Check if vendor is in vacation mode
            if ($vendor->vendorProfile && $vendor->vendorProfile->vacation_mode) {
                return view('vendors.show', [
                    'vendor' => $vendor,
                    'vacation_mode' => true,
                    'products' => collect() // Empty collection when in vacation mode
                ]);
            }

            // Get vendor's active products
            $products = Product::where('user_id', $vendor->id)
                ->active()
                ->latest()
                ->paginate(8);
                
            // Calculate review statistics for all vendor products
            $reviewStats = $this->calculateVendorReviewStatistics($vendor->id);
            
            // Calculate dispute statistics for this vendor
            $disputeStats = $this->calculateVendorDisputeStatistics($vendor->id);
            
            // Get all product IDs for this vendor
            $productIds = Product::where('user_id', $vendor->id)->pluck('id')->toArray();
            
            // Get all reviews for all vendor products with pagination
            $allReviews = collect();
            if (!empty($productIds)) {
                $allReviews = ProductReviews::whereIn('product_id', $productIds)
                    ->with(['user:id,username', 'product:id,name,slug'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(8, ['*'], 'reviews_page');
            }

            return view('vendors.show', [
                'vendor' => $vendor,
                'vacation_mode' => false,
                'products' => $products,
                'positiveCount' => $reviewStats['positive'],
                'mixedCount' => $reviewStats['mixed'],
                'negativeCount' => $reviewStats['negative'],
                'totalReviews' => $reviewStats['total'],
                'positivePercentage' => $reviewStats['positivePercentage'],
                'allReviews' => $allReviews,
                'disputesWon' => $disputeStats['won'],
                'disputesOpen' => $disputeStats['open'],
                'disputesLost' => $disputeStats['lost'],
                'totalDisputes' => $disputeStats['total']
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching vendor details: ' . $e->getMessage(), ['username' => $username]);
            return redirect()->route('vendors.index')->with('error', 'Vendor not found or unavailable.');
        }
    }
    
    /**
     * Calculate review statistics for all products of a vendor.
     *
     * @param  int  $vendorId
     * @return array
     */
    private function calculateVendorReviewStatistics($vendorId)
    {
        // Get products IDs for this vendor
        $productIds = Product::where('user_id', $vendorId)->pluck('id')->toArray();
        
        // If no products, return zeros
        if (empty($productIds)) {
            return [
                'positive' => 0,
                'mixed' => 0,
                'negative' => 0,
                'total' => 0,
                'positivePercentage' => null
            ];
        }
        
        // Count reviews by sentiment
        $reviewCounts = ProductReviews::whereIn('product_id', $productIds)
            ->select('sentiment', DB::raw('count(*) as count'))
            ->groupBy('sentiment')
            ->pluck('count', 'sentiment')
            ->toArray();
            
        // Get counts for each sentiment
        $positiveCount = $reviewCounts[ProductReviews::SENTIMENT_POSITIVE] ?? 0;
        $mixedCount = $reviewCounts[ProductReviews::SENTIMENT_MIXED] ?? 0;
        $negativeCount = $reviewCounts[ProductReviews::SENTIMENT_NEGATIVE] ?? 0;
        $totalReviews = $positiveCount + $mixedCount + $negativeCount;
        
        // Calculate percentage of positive reviews
        $positivePercentage = $totalReviews > 0
            ? ($positiveCount / $totalReviews) * 100
            : null;
            
        return [
            'positive' => $positiveCount,
            'mixed' => $mixedCount,
            'negative' => $negativeCount,
            'total' => $totalReviews,
            'positivePercentage' => $positivePercentage
        ];
    }
    
    /**
     * Calculate dispute statistics for a vendor.
     *
     * @param  int  $vendorId
     * @return array
     */
    private function calculateVendorDisputeStatistics($vendorId)
    {
        // Get all disputes for this vendor
        $disputes = Dispute::getVendorDisputes($vendorId);
        
        // If no disputes, return zeros
        if ($disputes->isEmpty()) {
            return [
                'won' => 0,
                'open' => 0,
                'lost' => 0,
                'total' => 0
            ];
        }
        
        // Count disputes by status
        $wonCount = $disputes->where('status', Dispute::STATUS_VENDOR_PREVAILS)->count();
        $openCount = $disputes->where('status', Dispute::STATUS_ACTIVE)->count();
        $lostCount = $disputes->where('status', Dispute::STATUS_BUYER_PREVAILS)->count();
        $totalDisputes = $disputes->count();
        
        return [
            'won' => $wonCount,
            'open' => $openCount,
            'lost' => $lostCount,
            'total' => $totalDisputes
        ];
    }
}
