<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use DB;
use Auth;
use App\Models\Order;
use App\Models\Upload;
use App\Models\Product;
use App\Utility\CartUtility;
use Cookie;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Models\CombinedOrder;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = CombinedOrder::with('orders')->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        //$orders = Order::with('orderDetails')->where('user_id', Auth::user()->id)->orderBy('code', 'desc')->paginate(10);
        //    return view('frontend.user.purchase_history', compact('orders'));
        return view('frontend.user.purchase_history', compact('orders'));
        // $combinedOrders = CombinedOrder::with(['orders.orderDetails'])
        //     ->where('user_id', Auth::user()->id)
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);


        // return view('frontend.user.purchase_history', compact('combinedOrders'));
    }
    public function digital_index()
    {
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.user_id', Auth::user()->id)
            ->where('products.digital', '1')
            ->where('order_details.payment_status', 'paid')
            ->select('order_details.id')
            ->paginate(15);
        return view('frontend.user.digital_purchase_history', compact('orders'));
    }
    public function purchase_history_details($order_id, $id = null)
    {
        $order = Order::findOrFail(decrypt($order_id));
        $order->delivery_viewed = 1;
        $order->payment_status_viewed = 1;
        $order->save();
        $combined_order = CombinedOrder::findOrFail($order->combined_order_id);
        $orders = $combined_order->orders;
        return view('frontend.user.order_details_customer', compact('order', 'orders'));
    }

    public function download(Request $request)
    {
        $product = Product::findOrFail(decrypt($request->id));
        $downloadable = false;
        foreach (Auth::user()->orders as $key => $order) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                if ($orderDetail->product_id == $product->id && $orderDetail->payment_status == 'paid') {
                    $downloadable = true;
                    break;
                }
            }
        }
        if ($downloadable) {
            $upload = Upload::findOrFail($product->file_name);
            if (env('FILESYSTEM_DRIVER') == "s3") {
                return \Storage::disk('s3')->download($upload->file_name, $upload->file_original_name . "." . $upload->extension);
            } else {
                if (file_exists(base_path('public/' . $upload->file_name))) {
                    return response()->download(base_path('public/' . $upload->file_name));
                }
            }
        } else {
            flash(translate('You cannot download this product.'))->success();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order_cancel($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if ($order && ($order->delivery_status == 'pending' && $order->payment_status == 'unpaid')) {
            $order->delivery_status = 'cancelled';
            $order->save();
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delivery_status = 'cancelled';
                $orderDetail->save();
                product_restock($orderDetail);
            }
            flash(translate('Order has been canceled successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }
    public function re_order($id)
    {
        $user_id = Auth::user()->id;
        // if Cart has auction product check
        $carts = Cart::where('user_id', $user_id)->get();
        foreach ($carts as $cartItem) {
            $cart_product = Product::where('id', $cartItem['product_id'])->first();
            if ($cart_product->auction_product == 1) {
                flash(translate('Remove auction product from cart to add products.'))->error();
                return back();
            }
        }
        $order = Order::findOrFail(decrypt($id));
        $success_msgs = [];
        $failed_msgs = [];
        $data['user_id'] = $user_id;
        foreach ($order->orderDetails as $key => $orderDetail) {
            $product = $orderDetail->product;
            if (
                !$product || $product->published == 0 ||
                $product->approved == 0 || ($product->wholesale_product && !addon_is_activated("wholesale"))
            ) {
                array_push($failed_msgs, translate('An item from this order is not available now.'));
                continue;
            }
            if ($product->auction_product == 0) {
                // If product min qty is greater then the ordered qty, then update the order qty 
                $order_qty = $orderDetail->quantity;
                if ($product->digital == 0 && $order_qty < $product->min_qty) {
                    $order_qty = $product->min_qty;
                }
                $cart = Cart::firstOrNew([
                    'variation' => $orderDetail->variation,
                    'user_id' => auth()->user()->id,
                    'product_id' => $product->id
                ]);
                $product_stock = $product->stocks->where('variant', $orderDetail->variation)->first();
                if ($product_stock) {
                    $quantity = 1;
                    if ($product->digital != 1) {
                        $quantity = $product_stock->qty;
                        if ($quantity > 0) {
                            if ($cart->exists) {
                                $order_qty = $cart->quantity + $order_qty;
                            }
                            //If order qty is greater then the product stock, set order qty = current product stock qty
                            $quantity = $quantity >= $order_qty ? $order_qty : $quantity;
                        } else {
                            array_push($failed_msgs, $product->getTranslation('name') . ' ' . translate(' is stock out.'));
                            continue;
                        }
                    }
                    $price = CartUtility::get_price($product, $product_stock, $quantity);
                    $tax = CartUtility::tax_calculation($product, $price);
                    CartUtility::save_cart_data($cart, $product, $price, $tax, $quantity);
                    array_push($success_msgs, $product->getTranslation('name') . ' ' . translate('added to cart.'));
                } else {
                    array_push($failed_msgs, $product->getTranslation('name') . ' ' . translate('is stock out.'));
                }
            } else {
                array_push($failed_msgs, translate('You can not re order an auction product.'));
                break;
            }
        }
        foreach ($failed_msgs as $msg) {
            flash($msg)->warning();
        }
        foreach ($success_msgs as $msg) {
            flash($msg)->success();
        }
        return redirect()->route('cart');
    }

    // public function payment_info(Request $request)
    // {
    //     $orderId = $request->input('order_id');
    //     $order = Order::where('code', $orderId)
    //         ->where('user_id', auth()->user()->id)
    //         ->get();

    //     if ($order && $order->payment_status == 'unpaid') {
    //         $photoPath = null; // Initialize photo path

    //         // Check if there's a file named 'photo' in the request
    //         if ($request->hasFile('photo')) {
    //             $file = $request->file('photo');
    //             $imageName = time() . '.' . $file->getClientOriginalExtension();

    //             // Move the file to the 'public/images' directory
    //             $file->move(public_path('images'), $imageName);

    //             // Store relative path for public access
    //             $photoPath = 'images/' . $imageName; // This will give you 'images/image_name.extension'
    //         }
    //         // Prepare the manual payment data
    //         $manualPaymentData = [
    //             'trx_id' => $request->input('transaction_id'),
    //             'photo' => $photoPath,
    //         ];
    //         // Update the order's manual payment data
    //         $updated = DB::table('orders')
    //             ->where('id', $orderId)
    //             ->update([
    //                 'payment_status' => 'pending',
    //                 'manual_payment' => 1,
    //                 'manual_payment_data' => json_encode($manualPaymentData),
    //                 'updated_at' => now(),
    //             ]);
    //         // Check if the update was successful
    //         if ($updated) {
    //             flash(translate('Payment info updated successfully'))->success();
    //         } else {
    //             flash(translate('Failed to update payment info'))->error();
    //         }
    //         // Prepare email data
    //         $array['view'] = 'emails.invoice';
    //         $array['subject'] = translate('A new order has been placed') . ' - ' . $order->code;
    //         $array['from'] = env('MAIL_FROM_ADDRESS');
    //         $array['order'] = $order;
    //         // Send email to seller
    //         if ($order->orderDetails->first()->product->user->email != null) {
    //             Mail::to($order->orderDetails->first()->product->user->email)->queue(new InvoiceEmailManager($array));
    //         }
    //     } else {
    //         flash(translate('Order not found or you do not have permission to access this order'))->error();
    //     }
    //     return redirect()->back()->with('success', 'Payment information updated successfully.');
    // }
    
    // ha comment
    // public function payment_info(Request $request)
    // {
    //     $orderId = $request->input('order_id');

    //     // Fetch all orders with the same code (since you have multiple items for one code)
    //     $orders = Order::where('code', $orderId)
    //         ->where('user_id', auth()->user()->id)
    //         ->get();
    //     // Check if the orders are unpaid
    //     if ($orders->isNotEmpty() && $orders->first()->payment_status == 'unpaid') {

    //         $photoPath = null;

    //         // Check if there's a file named 'photo' in the request
    //         if ($request->hasFile('photo')) {
    //             $file = $request->file('photo');
                
    //             $imageName = time() . '.' . $file->getClientOriginalExtension();

    //             // Move the file to the 'public/images' directory
    //             $file->move(public_path('images'), $imageName);

    //             // Store relative path for public access
    //             $photoPath = 'images/' . $imageName;
    //         }

    //         // Prepare manual payment data
    //         $manualPaymentData = [
    //             'trx_id' => $request->input('transaction_id'),
    //             'photo' => $photoPath,
    //         ];

    //         // Loop through each order and update its status
    //         foreach ($orders as $order) {
    //             $order->update([
    //                 'payment_status' => 'pending',
    //                 'manual_payment' => 1,
    //                 'manual_payment_data' => json_encode($manualPaymentData),
    //                 'updated_at' => now(),
    //             ]);
    //         }

    //         // Prepare the email data once for all the orders
    //         $array = [
    //             'view' => 'emails.invoice',
    //             'subject' => translate('A new order has been placed') . ' - ' . $orderId, // Since all orders have the same code
    //             'from' => env('MAIL_FROM_ADDRESS'),
    //             'orders' => $orders, // Pass all orders (collection)
    //         ];

    //         // Send email to the seller after updating all orders
    //         $sellerEmail = $orders->first()->orderDetails->first()->product->user->email;
    //         if ($sellerEmail != null) {
    //             Mail::to($sellerEmail)->queue(new InvoiceEmailManager($array));
    //         }

    //         flash(translate('Payment info updated successfully'))->success();
    //     } else {
    //         flash(translate('Order not found or you do not have permission to access this order'))->error();
    //     }

    //     return redirect()->back()->with('success', 'Payment information updated successfully.');
    // }
    
    // public function payment_info(Request $request)
    // {
    //     $orderId = $request->input('order_id');
    
    //     // Fetch all orders with the same code (since you have multiple items for one code)
    //     $orders = Order::where('code', $orderId)
    //         ->where('user_id', auth()->user()->id)
    //         ->get();
    
    //     // Check if the orders are unpaid
    //     if ($orders->isNotEmpty() && $orders->first()->payment_status == 'unpaid') {
    //         $photoPaths = []; // Array to store paths of uploaded photos
    
    //         // Check if there are files named 'photos' in the request
    //         if ($request->hasFile('photos')) {
    //             foreach ($request->file('photos') as $file) {
    //                 $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path('images'), $imageName);
    //                 $photoPaths[] = 'images/' . $imageName; // Store each path
    //             }
    //         }
    
    //         // Prepare manual payment data
    //         $manualPaymentData = [
    //             'trx_id' => $request->input('transaction_id'),
    //             'photos' => $photoPaths, // Store array of photo paths
    //         ];
    
    //         // Loop through each order and update its status
    //         foreach ($orders as $order) {
    //             $order->update([
    //                 'payment_status' => 'pending',
    //                 'manual_payment' => 1,
    //                 'manual_payment_data' => json_encode($manualPaymentData), // Encode to JSON
    //                 'updated_at' => now(),
    //             ]);
    //         }
    
    //         // Prepare the email data once for all the orders
    //         $array = [
    //             'view' => 'emails.invoice',
    //             'subject' => translate('A new order has been placed') . ' - ' . $orderId,
    //             'from' => env('MAIL_FROM_ADDRESS'),
    //             'orders' => $orders,
    //         ];
    
    //         // Send email to the seller after updating all orders
    //         $sellerEmail = $orders->first()->orderDetails->first()->product->user->email;
    //         if ($sellerEmail != null) {
    //             Mail::to($sellerEmail)->queue(new InvoiceEmailManager($array));
    //         }
    
    //         flash(translate('Payment info updated successfully'))->success();
    //     } else {
    //         flash(translate('Order not found or you do not have permission to access this order'))->error();
    //     }
    
    //     return redirect()->back()->with('success', 'Payment information updated successfully.');
    // }
    
    public function payment_info(Request $request)
    {
        $orderId = $request->input('order_id');
        $orders = Order::where('code', $orderId)
            ->where('user_id', auth()->user()->id)
            ->get();
    
        if ($orders->isNotEmpty() && $orders->first()->payment_status == 'unpaid') {
            $allManualPaymentData = [];
            
            // Check if `transactions` exists in the request and loop through each transaction
            $transactions = $request->input('transactions', []);
    
            foreach ($transactions as $index => $transactionData) {
                $transactionId = $transactionData['transaction_id'] ?? null;
                $photoPaths = [];
    
                // Check if photos are uploaded for the current transaction ID
                if ($request->hasFile("transactions.$index.photos")) {
                    foreach ($request->file("transactions.$index.photos") as $file) {
                        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('images'), $imageName);
                        $photoPaths[] = 'images/' . $imageName;
                    }
                }
    
                $allManualPaymentData[] = [
                    'trx_id' => $transactionId,
                    'photos' => $photoPaths
                ];
            }
    
            foreach ($orders as $order) {
                $order->update([
                    'payment_status' => 'pending',
                    'manual_payment' => 1,
                    'manual_payment_data' => json_encode($allManualPaymentData),
                    'updated_at' => now(),
                ]);
            }
    
            // Email notification setup
            $array = [
                'view' => 'emails.invoice',
                'subject' => translate('A new order has been placed') . ' - ' . $orderId,
                'from' => env('MAIL_FROM_ADDRESS'),
                'orders' => $orders,
            ];
    
            $sellerEmail = $orders->first()->orderDetails->first()->product->user->email;
            if ($sellerEmail != null) {
                Mail::to($sellerEmail)->queue(new InvoiceEmailManager($array));
            }
    
            flash(translate('Payment info updated successfully'))->success();
        } else {
            flash(translate('Order not found or you do not have permission to access this order'))->error();
        }
    
        return redirect()->back()->with('success', 'Payment information updated successfully.');
    }
}
