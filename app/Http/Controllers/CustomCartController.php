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
    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            // Fetch product details from the database (e.g., name, price)
            $product = Product::find($productId);
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $this->getCartData()]);
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return response()->json(['success' => true, 'cart' => $this->getCartData()]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
    }

    public function updateCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
            return response()->json(['success' => true, 'cart' => $this->getCartData()]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
    }

    private function getCartData()
    {
        $cart = Session::get('cart', []);
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return [
            'items' => array_values($cart),
            'subtotal' => number_format($subtotal, 2),
        ];
    }
}
