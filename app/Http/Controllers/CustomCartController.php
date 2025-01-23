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
        $cart = Session::get('cart', []);
        $qty = 1;
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $product = Product::find($productId); // Fetch product from database
            $subtotal = discount_in_percentage($product) > 0 ? (1*  home_discounted_base_price($product, false) )  :  (1 *  home_base_price($product, false) );
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => home_base_price($product),
                'price_int' =>  home_base_price($product, false),
                'image' => $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg'), // Ensure you have an image column in the Product model
                'quantity' => 1,
                'discounted_price' => home_discounted_base_price($product),
                'discounted_price_int' => home_discounted_base_price($product, false), 
                'subtotal' => format_price($subtotal) ,
                'discount' => discount_in_percentage($product) > 0,
                'discounted_percentage' => discount_in_percentage($product)
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $this->getCartData(),
        ]);
    }


    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        $cart = Session::get('cart', []);
    
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }
    
        return response()->json([
            'success' => true,
            'cart' => $this->getCartData(),
        ]);
    }
    
    public function updateCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = max(0, intval($request->quantity));  // Prevent negative or zero values

        $cart = Session::get('cart', []);
        
        if (isset($cart[$productId])) {
            // If the quantity is 0, remove the item from the cart
            if ($quantity === 0) {
                unset($cart[$productId]);
            } else {
                // Update the quantity if it's greater than 0
                $cart[$productId]['quantity'] = $quantity;
            }

            Session::put('cart', $cart);  // Update the session with the new cart data
        }

        return response()->json([
            'success' => true,
            'cart' => $this->getCartData(),
        ]);
    }
    
    private function getCartData()
    {
        $cart = Session::get('cart', []);
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price_int'] * $item['quantity'];
        }, $cart));
        foreach ( $cart as $productId => $item){
            $qty = $item['quantity'];
            $product = Product::find($productId);
            $item_subtotal = discount_in_percentage($product) > 0 ? ($qty *  home_discounted_base_price($product, false) )  :  ($qty *  home_base_price($product, false) );
            $cart[$productId]['subtotal'] = format_price($item_subtotal);
        }
        return [
            'items' => array_values($cart),
            'subtotal' => format_price($subtotal),
        ];
    }

}
