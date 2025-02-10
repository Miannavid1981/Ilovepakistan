<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Carrier;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Country;
use Auth;
use App\Utility\CartUtility;
use Session;
use Cookie;

class CustomCartController extends Controller
{
    public function getCart()
    {
        return response()->json(['cart' => $this->getCartData()]);
    }
    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $skinCode = $request->skin_code;  // Skin code to uniquely identify variations
        $userId = Auth::id() ?? null;
        $tempUserId = session('guest_cart_id', str()->uuid());
        session(['guest_cart_id' => $tempUserId]);
    
        // Check if the same product with the same skin code exists
        $cartItem = Cart::where('product_id', $productId)
            ->where('skin_code', $skinCode)
            ->where(function ($query) use ($userId, $tempUserId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('temp_user_id', $tempUserId);
                }
            })->first();
    
        if ($cartItem) {
            // If found, increase the quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $product = Product::find($productId);
    
            // Calculate the subtotal considering discounts
            $subtotal = discount_in_percentage($product) > 0 
                ? (1 * home_discounted_base_price($product, false)) 
                : (1 * home_base_price($product, false));
    
            // Create new cart entry
            Cart::create([
                'product_id' => $product->id,
                'skin_code' => $skinCode,  // Store unique skin code
                'user_id' => $userId,
                'temp_user_id' => $tempUserId,
                'price' => home_base_price($product),
                'quantity' => 1,
                'status' => 'active',
                'owner_id' => $userId ?? null,
                'address_id' => null,
                'variation' => null,
                'tax' => null,
                'shipping_cost' => null,
                'shipping_type' => null,
                'pickup_point' => null,
                'carrier_id' => null,
                'product_referral_code' => null,
                'coupon_code' => null,
                'coupon_applied' => false,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'cart' => $this->getCartData(),
        ]);
    }
    

    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        $userId = Auth::id();
        $tempUserId = session('guest_cart_id');

        Cart::where('product_id', $productId)
            ->where(function ($query) use ($userId, $tempUserId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('temp_user_id', $tempUserId);
                }
            })->delete();

        return response()->json([
            'success' => true,
            'cart' => $this->getCartData(),
        ]);
    }
    public function updateCart(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        // dd($quantity);
        $userId = Auth::id();
        $tempUserId = session('guest_cart_id');
    
        $cartItem = Cart::where('id', $id)
            ->where(function ($query) use ($userId, $tempUserId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('temp_user_id', $tempUserId);
                }
            })->first();
    
        if ($cartItem) {
            if ($quantity == 0) {
                $cartItem->delete();
            } else {
                // Update the quantity if it's greater than 0
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        } else {
            // Handle the case when the cart item doesn't exist (optional)
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'cart' => $this->getCartData(),
        ]);
    }
    
    private function getCartData()
    {
        $userId = Auth::id();
        $tempUserId = session('guest_cart_id');
    
        $cartItems = Cart::where(function ($query) use ($userId, $tempUserId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('temp_user_id', $tempUserId);
            }
        })->get();
    
        $total = 0;
        $subtotal = 0;
        $items_discount = 0;
    
        foreach ($cartItems as $item) {
            $qty = $item->quantity;
            $product = Product::find($item->product_id);
            $item_total = discount_in_percentage($product) > 0 ? ($qty * home_discounted_base_price($product, false)) : ($qty * home_base_price($product, false));
            $item->subtotal = format_price($item_total);
            $total += $item_total;
            $items_subtotal = $qty * home_base_price($product, false);
            $subtotal += $items_subtotal;
            $discount_amount = discount_in_percentage($product) > 0 ? home_base_price($product, false) - home_discounted_base_price($product, false) : 0;
            $items_discount += ($qty * $discount_amount);
    
            // Assigning cart item keys with the correct values
            $item->product_id = $product->id;
            $item->name = $product->name;
            $item->price = home_base_price($product);
            $item->price_int = home_base_price($product, false);
            $item->image = $product->thumbnail ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg');
            $item->quantity = $qty;
            $item->discounted_price = home_discounted_base_price($product);
            $item->discounted_price_int = home_discounted_base_price($product, false);
            $item->subtotal = format_price($items_subtotal);
            $item->discount = discount_in_percentage($product) > 0;
            $item->discounted_percentage = discount_in_percentage($product);
            $item->user_id = $userId;
            $item->temp_user_id = $tempUserId;
    
        }
    
        return [
            'items' => $cartItems,
            'total' => format_price($total),
            'subtotal' => format_price($subtotal),
            'items_discount' => format_price($items_discount)
        ];
    }
    
}
