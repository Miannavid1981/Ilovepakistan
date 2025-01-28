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
        $userId = Auth::id() ?? null;
        $tempUserId = session('guest_cart_id', str()->uuid());
        session(['guest_cart_id' => $tempUserId]);
        
        $cartItem = Cart::where('product_id', $productId)
            ->where(function ($query) use ($userId, $tempUserId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('temp_user_id', $tempUserId);
                }
            })->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $product = Product::find($productId);
            $subtotal = discount_in_percentage($product) > 0 ? (1 * home_discounted_base_price($product, false)) : (1 * home_base_price($product, false));
            
            Cart::create([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => home_base_price($product),
                'price_int' => home_base_price($product, false),
                'image' => $product->thumbnail ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg'),
                'quantity' => 1,
                'discounted_price' => home_discounted_base_price($product),
                'discounted_price_int' => home_discounted_base_price($product, false),
                'subtotal' => format_price($subtotal),
                'discount' => discount_in_percentage($product) > 0,
                'discounted_percentage' => discount_in_percentage($product),
                'user_id' => $userId,
                'temp_user_id' => $tempUserId,
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
        $productId = $request->product_id;
        $quantity = max(0, intval($request->quantity));
        $userId = Auth::id();
        $tempUserId = session('guest_cart_id');

        $cartItem = Cart::where('product_id', $productId)
            ->where(function ($query) use ($userId, $tempUserId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('temp_user_id', $tempUserId);
                }
            })->first();

        if ($cartItem) {
            if ($quantity === 0) {
                $cartItem->delete();
            } else {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
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
        }
        return [
            'items' => $cartItems,
            'total' => format_price($total),
            'subtotal' => format_price($subtotal),
            'items_discount' => format_price($items_discount)
        ];
    }
}
