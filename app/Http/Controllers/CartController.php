<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\XmrPriceController;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index(XmrPriceController $xmrPriceController)
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product', 'product.user'])
            ->get();
            
        // Check for and remove cart items with deleted products
        $deletedProductItems = $cartItems->filter(function($item) {
            return $item->hasDeletedProduct();
        });
        
        if ($deletedProductItems->isNotEmpty()) {
            // Remove cart items with deleted products
            foreach ($deletedProductItems as $item) {
                $item->delete();
            }
            
            // Refresh cart items after removal
            $cartItems = Cart::where('user_id', Auth::id())
                ->with(['product', 'product.user'])
                ->get();
                
            // Add notification
            session()->flash('info', 'Some items were automatically removed from your cart because their products have been deleted.');
        }

        $xmrPrice = $xmrPriceController->getXmrPrice();
        $cartTotal = Cart::getCartTotal(Auth::user());
        $xmrTotal = is_numeric($xmrPrice) && $xmrPrice > 0 
            ? $cartTotal / $xmrPrice 
            : null;

        // Get measurement units mapping for formatting
        $measurementUnits = Product::getMeasurementUnits();

        return view('cart.index', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'xmrTotal' => $xmrTotal,
            'xmrPrice' => $xmrPrice,
            'measurementUnits' => $measurementUnits
        ]);
    }

    /**
     * Add a product to cart.
     */
    public function store(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1|max:80000',
                'delivery_option' => 'required|integer|min:0',
                'bulk_option' => 'nullable|integer|min:0'
            ]);

            // Validate product addition
            $validation = Cart::validateProductAddition(Auth::user(), $product);
            if (!$validation['valid']) {
                $errorMessage = match($validation['reason']) {
                    'different_vendor' => 'You can only add products from the same vendor to your cart.',
                    'inactive' => 'This product is currently not available.',
                    'vacation' => 'This vendor is currently on vacation.',
                    'out_of_stock' => 'This product is out of stock.',
                    default => 'Unable to add product to cart.'
                };
                return back()->with('error', $errorMessage);
            }

            // Get selected delivery option
            $deliveryOptions = $product->delivery_options;
            if (!isset($deliveryOptions[$validated['delivery_option']])) {
                return back()->with('error', 'Invalid delivery option selected.');
            }
            $selectedDelivery = $deliveryOptions[$validated['delivery_option']];

            // Handle bulk options and pricing
            $price = $product->price;
            $selectedBulk = null;
            $quantity = $validated['quantity'];

            if (isset($validated['bulk_option']) && $validated['bulk_option'] !== '' && $product->bulk_options) {
                if (!isset($product->bulk_options[$validated['bulk_option']])) {
                    return back()->with('error', 'Invalid bulk option selected.');
                }
                $selectedBulk = $product->bulk_options[$validated['bulk_option']];

                // Validate that quantity is a multiple of the bulk amount
                if ($quantity % $selectedBulk['amount'] !== 0) {
                    return back()->with('error', 'Quantity must be a multiple of ' . $selectedBulk['amount'] . ' when using bulk option.');
                }
                
                // For bulk options, we store the bulk price directly
                // When quantity is 12 and bulk option is "6 for $100",
                // we'll store $100 as the price, and quantity as 2 (sets)
                $price = $selectedBulk['price'];
                $quantity = $quantity / $selectedBulk['amount'];
            }

            // Validate stock availability after processing bulk options
            $stockValidation = Cart::validateStockAvailability(
                $product,
                $quantity,
                $selectedBulk
            );

            if (!$stockValidation['valid']) {
                $measurementUnits = Product::getMeasurementUnits();
                $formattedUnit = $measurementUnits[$product->measurement_unit] ?? $product->measurement_unit;
                return back()->with('error', sprintf(
                    'Insufficient stock. Available: %d %s, Requested: %d %s',
                    $stockValidation['available'],
                    $formattedUnit,
                    $stockValidation['requested'],
                    $formattedUnit
                ));
            }

            // Create or update cart item
            Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $product->id
                ],
                [
                    'quantity' => $quantity,
                    'price' => $price,
                    'selected_delivery_option' => $selectedDelivery,
                    'selected_bulk_option' => $selectedBulk
                ]
            );

            return redirect()
                ->route('cart.index')
                ->with('success', 'Product added to cart successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add product to cart.');
        }
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        try {
            // Verify ownership
            if ($cart->user_id !== Auth::id()) {
                abort(403);
            }

            $validated = $request->validate([
                'quantity' => 'required|integer|min:1|max:80000'
            ]);

            // Validate stock availability
            $stockValidation = Cart::validateStockAvailability(
                $cart->product,
                $validated['quantity'],
                $cart->selected_bulk_option
            );

            if (!$stockValidation['valid']) {
                $measurementUnits = Product::getMeasurementUnits();
                $formattedUnit = $measurementUnits[$cart->product->measurement_unit] ?? $cart->product->measurement_unit;
                return back()->with('error', sprintf(
                    'Insufficient stock. Available: %d %s, Requested: %d %s',
                    $stockValidation['available'],
                    $formattedUnit,
                    $stockValidation['requested'],
                    $formattedUnit
                ));
            }

            $cart->update([
                'quantity' => $validated['quantity']
            ]);

            return redirect()
                ->route('cart.index')
                ->with('success', 'Cart updated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update cart.');
        }
    }

    /**
     * Remove a specific item from cart.
     */
    public function destroy(Cart $cart)
    {
        try {
            // Verify ownership
            if ($cart->user_id !== Auth::id()) {
                abort(403);
            }

            $cart->delete();

            return redirect()
                ->route('cart.index')
                ->with('success', 'Item removed from cart successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove item from cart.');
        }
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        try {
            Cart::where('user_id', Auth::id())->delete();

            return redirect()
                ->route('cart.index')
                ->with('success', 'Cart cleared successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to clear cart.');
        }
    }

    /**
     * Show checkout page (placeholder for future implementation).
     */
    /**
     * Save encrypted message for cart item
     */
    public function saveMessage(Request $request, Cart $cart)
    {
        try {
            // Verify ownership
            if ($cart->user_id !== Auth::id()) {
                abort(403);
            }

            // Validate message
            $validated = $request->validate([
                'message' => 'required|string|min:4|max:1600'
            ]);

            // Check if vendor has PGP key
            if (!$cart->product->user->pgpKey) {
                return back()->with('error', 'Vendor does not have a PGP key set up.');
            }

            // Encrypt message
            $encryptedMessage = $cart->encryptMessageForVendor($validated['message']);
            if ($encryptedMessage === false) {
                return back()->with('error', 'Failed to encrypt message. Please try again.');
            }

            // Save encrypted message
            $cart->update([
                'encrypted_message' => $encryptedMessage
            ]);

            return back()->with('success', 'Message encrypted and saved successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save message.');
        }
    }

    public function checkout(XmrPriceController $xmrPriceController)
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product', 'product.user'])
            ->get();
            
        // Check for and remove cart items with deleted products
        $deletedProductItems = $cartItems->filter(function($item) {
            return $item->hasDeletedProduct();
        });
        
        if ($deletedProductItems->isNotEmpty()) {
            // Remove cart items with deleted products
            foreach ($deletedProductItems as $item) {
                $item->delete();
            }
            
            // Refresh cart items after removal
            $cartItems = Cart::where('user_id', Auth::id())
                ->with(['product', 'product.user'])
                ->get();
                
            // Add notification
            session()->flash('info', 'Some items were automatically removed from your cart because their products have been deleted.');
        }
        
        $subtotal = Cart::getCartTotal(Auth::user());
        $commissionPercentage = config('marketplace.commission_percentage');
        $commission = ($subtotal * $commissionPercentage) / 100;
        $total = $subtotal + $commission;

        // Get XMR price for conversion
        $xmrPrice = $xmrPriceController->getXmrPrice();
        $xmrTotal = is_numeric($xmrPrice) && $xmrPrice > 0 
            ? $total / $xmrPrice 
            : null;

        // Get measurement units for formatting
        $measurementUnits = Product::getMeasurementUnits();

        // Handle encrypted message logic
        $hasEncryptedMessage = $cartItems->contains(function($item) {
            return $item->encrypted_message;
        });
        $messageItem = $cartItems->first(function($item) {
            return $item->encrypted_message;
        });

        return view('cart.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'commissionPercentage' => $commissionPercentage,
            'commission' => $commission,
            'total' => $total,
            'xmrPrice' => $xmrPrice,
            'xmrTotal' => $xmrTotal,
            'measurementUnits' => $measurementUnits,
            'hasEncryptedMessage' => $hasEncryptedMessage,
            'messageItem' => $messageItem
        ]);
    }
}
