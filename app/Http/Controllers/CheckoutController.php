<?php

namespace App\Http\Controllers;

use App\Utility\PayfastUtility;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\CombinedOrder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Utility\PayhereUtility;
use App\Utility\NotificationUtility;
use Session;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    public function __construct()
    {
        //
    }

    //humza
    public function checkout(Request $request)
    {
        if ($request->payment_option == null) {
            flash(translate('There is no payment option selected.'))->warning();
            return redirect()->route('checkout.shipping_info');
        }
        $user_id = Auth::user()->id;

        $carts = Cart::where('user_id', $user_id)->get();
        // Perform checks and validations as before...
        $address_id = session()->get('address_id');
        
        // Store payment option and other necessary data in session for later use
        $request->session()->put('payment_type', 'cart_payment');
        
        $request->session()->put('payment_option', $request->payment_option); // Store the selected payment option
        if ($request->hasFile('photo')) {
            \Log::info($request->photo);
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            // Store the file in the public disk under 'assets/img/payment'
            $path = $file->storeAs('assets/img/payment', $filename, 'public');
            $photoPath = 'storage/' . $path; // Adjust path for public access
        } else {
            $photoPath = null;
        }
        $request->session()->put('payment_data', [
            'combined_order_id' => $request->session()->get('combined_order_id'),
            'trx_id' => $request->trx_id,
            'photo' => $photoPath,
        ]);
        if ($address_id) {
            foreach ($carts as $cartItem) {
                $cartItem->address_id = $address_id;
                $cartItem->save();
            }
        }
        $carrier_list = [];
        if (get_setting('shipping_type') == 'carrier_wise_shipping') {
            $zone = optional(Cart::where('user_id', $user_id)->first())->address->country->zone_id ?? null;
            if ($zone) {
                $carrier_query = Carrier::query();
                $carrier_query->whereIn('id', function ($query) use ($zone) {
                    $query->select('carrier_id')->from('carrier_range_prices')
                        ->where('zone_id', $zone);
                })->orWhere('free_shipping', 1);
                $carrier_list = $carrier_query->get();
            }
        }
        // Assuming you have a shipping_info field in the session or elsewhere to pass to the view
        $shipping_info = Address::find($request->session()->get('shipping_info'));
        return view('frontend.delivery_info', compact('carts', 'carrier_list', 'shipping_info'));
    }

    //check the selected payment gateway and redirect to that controller accordingly
    // public function checkout(Request $request)
    // {
    //     if ($request->payment_option == null) {
    //         flash(translate('There is no payment option selected.'))->warning();
    //         return redirect()->route('checkout.shipping_info');
    //     }
    //     $user_id = Auth::user()->id;

    //     $carts = Cart::where('user_id', $user_id)->get();
    //     // Perform checks and validations as before...
    //     $address_id = session()->get('address_id');
    //     // Store payment option and other necessary data in session for later use
    //     $request->session()->put('payment_type', 'cart_payment');
    //     $request->session()->put('payment_option', $request->payment_option); // Store the selected payment option

    //     if ($request->hasFile('photo')) {
    //         \Log::info($request->photo);
    //         $file = $request->file('photo');
    //         $filename = time() . '.' . $file->getClientOriginalExtension();
    //         // Store the file in the public disk under 'assets/img/payment'
    //         $path = $file->storeAs('assets/img/payment', $filename, 'public');
    //         $photoPath = 'storage/' . $path; // Adjust path for public access
    //     } else {
    //         $photoPath = null;
    //     }
    //     $request->session()->put('payment_data', [
    //         'combined_order_id' => $request->session()->get('combined_order_id'),
    //         'trx_id' => $request->trx_id,
    //         'photo' => $photoPath,
    //     ]);
    //     if ($address_id) {
    //         foreach ($carts as $cartItem) {
    //             $cartItem->address_id = $address_id;
    //             $cartItem->save();
    //         }
    //     }
    //     $carrier_list = [];
    //     if (get_setting('shipping_type') == 'carrier_wise_shipping') {
    //         $zone = optional(Cart::where('user_id', $user_id)->first())->address->country->zone_id ?? null;
    //         if ($zone) {
    //             $carrier_query = Carrier::query();
    //             $carrier_query->whereIn('id', function ($query) use ($zone) {
    //                 $query->select('carrier_id')->from('carrier_range_prices')
    //                     ->where('zone_id', $zone);
    //             })->orWhere('free_shipping', 1);
    //             $carrier_list = $carrier_query->get();
    //         }
    //     }
    //     // Assuming you have a shipping_info field in the session or elsewhere to pass to the view
    //     $shipping_info = Address::find($request->session()->get('shipping_info'));
    //     return view('frontend.delivery_info', compact('carts', 'carrier_list', 'shipping_info'));
    // }
    // public function checkout(Request $request)
    // {
    //     if ($request->payment_option == null) {
    //         flash(translate('There is no payment option is selected.'))->warning();
    //         return redirect()->route('checkout.shipping_info');
    //     }
    //     $carts = Cart::where('user_id', Auth::user()->id)->get();
    //     // Minumum order amount check
    //     if(get_setting('minimum_order_amount_check') == 1){
    //         $subtotal = 0;
    //         foreach ($carts as $key => $cartItem){ 
    //             $product = Product::find($cartItem['product_id']);
    //             $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
    //         }
    //         if ($subtotal < get_setting('minimum_order_amount')) {
    //             flash(translate('You order amount is less than the minimum order amount'))->warning();
    //             return redirect()->route('home');
    //         }
    //     }
    //     // Minumum order amount check end

    //     (new OrderController)->store($request);

    //     if(count($carts) > 0){
    //         Cart::where('user_id', Auth::user()->id)->delete();
    //     }
    //     $request->session()->put('payment_type', 'cart_payment');

    //     $data['combined_order_id'] = $request->session()->get('combined_order_id');
    //     $request->session()->put('payment_data', $data);
    //     if ($request->session()->get('combined_order_id') != null) {
    //         // If block for Online payment, wallet and cash on delivery. Else block for Offline payment
    //         $decorator = __NAMESPACE__ . '\\Payment\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $request->payment_option))) . "Controller";
    //         if (class_exists($decorator)) {
    //             return (new $decorator)->pay($request);
    //         }
    //         else {
    //             $combined_order = CombinedOrder::findOrFail($request->session()->get('combined_order_id'));
    //             $manual_payment_data = array(
    //                 'name'   => $request->payment_option,
    //                 'amount' => $combined_order->grand_total,
    //                 'trx_id' => $request->trx_id,
    //                 'photo'  => $request->photo
    //             );
    //             foreach ($combined_order->orders as $order) {
    //                 $order->manual_payment = 1;
    //                 $order->manual_payment_data = json_encode($manual_payment_data);
    //                 $order->save();
    //             }
    //             flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
    //             return redirect()->route('order_confirmed');
    //         }
    //     }
    // }
    // public function finalizeOrderCheckout(Request $request)
    // {
    //     // Retrieve session data set during the checkout process
    //     $paymentOption = $request->session()->get('payment_option');
    //     $paymentData = $request->session()->get('payment_data');
    //     $userId = Auth::id(); // Simplified retrieval of user ID

    //     // Retrieve carts to ensure there are items to process
    //     $carts = Cart::where('user_id', $userId)->get();
    //     if ($carts->isEmpty()) {
    //         flash(translate('Your cart is empty'))->warning();
    //         return redirect()->route('home');
    //     }

    //     // Validate minimum order amount
    //     $subtotal = $carts->sum(function ($cartItem) {
    //         $product = Product::find($cartItem['product_id']);
    //         return cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
    //     });

    //     if ($this->isOrderAmountBelowMinimum($subtotal)) {
    //         flash(translate('Your order amount is less than the minimum order amount'))->warning();
    //         return redirect()->route('home');
    //     }

    //     // Finalize and store the order
    //     $orderController = new OrderController();
    //     $orderController->store($request);

    //     // Handle the combined order
    //     $combinedOrderId = $this->getOrCreateCombinedOrderId($request, $userId);

    //     // Clear the user's cart after finalizing the order
    //     Cart::where('user_id', $userId)->delete();

    //     // Handle payment details if necessary
    //     $this->finalizePaymentDetails($paymentOption, $paymentData, $combinedOrderId);

    //     // Redirect to the order confirmed page with a success message
    //     flash(translate('Your order has been placed successfully!'))->success();
    //     return redirect()->route('order_confirmed');
    // }

    // private function isOrderAmountBelowMinimum($subtotal)
    // {
    //     if (get_setting('minimum_order_amount_check') == 1) {
    //         $minimumOrderAmount = get_setting('minimum_order_amount');
    //         return $subtotal < $minimumOrderAmount;
    //     }
    //     return false;
    // }

    // private function getOrCreateCombinedOrderId(Request $request, $userId)
    // {
    //     $combinedOrderId = $request->session()->get('combined_order_id');
    //     if (!$combinedOrderId) {
    //         $combinedOrder = CombinedOrder::create([
    //             'user_id' => $userId,
    //             // Add any other necessary fields for the combined order here
    //         ]);
    //         $combinedOrderId = $combinedOrder->id;
    //         $request->session()->put('combined_order_id', $combinedOrderId);
    //     }
    //     return $combinedOrderId;
    // }

    // private function finalizePaymentDetails($paymentOption, $paymentData, $combinedOrderId)
    // {
    //     if (in_array($paymentOption, ['offline_payment', 'bank_transfer', 'jazzcash'])) {
    //         $combinedOrder = CombinedOrder::findOrFail($combinedOrderId);
    //         DB::table('orders')
    //             ->where('combined_order_id', $combinedOrder->id)
    //             ->update([
    //                 'payment_type' => $paymentOption,
    //                 'manual_payment' => 1,
    //                 'manual_payment_data' => json_encode([
    //                     'trx_id' => $paymentData['trx_id'] ?? null,
    //                     'photo' => $paymentData['photo'] ?? null,
    //                 ]),
    //             ]);
    //     }
    // }
    
    public function updateCheckedStatus(Request $request)
    {
        // Find the cart item and update the checked status
        $cartItem = Cart::find($request->cart_id);
        $cartItem->checked = $request->checked;
        $cartItem->save();
    
        return response()->json(['message' => 'Checked status updated successfully.']);
    }
    
    public function finalizeOrderCheckout(Request $request)
    {
        // Retrieve session data
        $payment_option = $request->session()->get('payment_option');
        $payment_data = $request->session()->get('payment_data');
        $user_id = Auth::id();

        // Retrieve the user's cart items
        $carts = Cart::where('user_id', $user_id)->where('checked', 1)->get();

        // Check if the cart is empty
        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        // Validate minimum order amount
        $subtotal = $carts->sum(function ($cartItem) {
            $product = Product::find($cartItem['product_id']);
            return cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
        });

        if (get_setting('minimum_order_amount_check') == 1 && $subtotal < get_setting('minimum_order_amount')) {
            flash(translate('Your order amount is less than the minimum order amount'))->warning();
            return redirect()->route('home');
        }

        // Finalize the order
        (new OrderController)->store($request, $payment_option, $payment_data);

        // Clear the user's cart
        Cart::where('user_id', $user_id)->where('checked', 1)->delete();

        // Redirect to the order confirmation page
        flash(translate('Your order has been placed successfully!'))->success();
        return redirect()->route('order_confirmed');
    }


    public function order_confirmed()
    {
        $orders = CombinedOrder::findOrFail(Session::get('combined_order_id'));
        Cart::where('user_id', $orders->user_id)->where('checked', 1)
            ->delete();
        session()->forget(['payment_type', 'payment_option', 'payment_data', 'combined_order_id']);
        return view('frontend.order_confirmed', compact('orders'));
    }

    public function downloadOrderReceipt($orderId)
    {
        $combined_order = CombinedOrder::findOrFail($orderId);
        $orders = $combined_order->orders;

        // Optionally debug the view first to ensure it's working fine
        //return view('frontend.order_receipt_pdf', compact('combined_order', 'orders'));

        // Generate the PDF
        $pdf = PDF::loadView('frontend.order_receipt_pdf', compact('combined_order', 'orders'))
            ->setPaper('A4', 'portrait')
            ->setWarnings(true); // Enable warnings to troubleshoot

        // Return the PDF to download
        return $pdf->download('order-receipt.pdf');
    }


    //redirects to this method after a successfull checkout
    // public function finalizeOrderCheckout(Request $request)
    // {
    //     // Retrieve session data
    //     $payment_option = $request->session()->get('payment_option');
    //     $payment_data = $request->session()->get('payment_data');
    //     $user_id = Auth::id();

    //     // Retrieve the user's cart items
    //     $carts = Cart::where('user_id', $user_id)->get();

    //     // Check if the cart is empty
    //     if ($carts->isEmpty()) {
    //         flash(translate('Your cart is empty'))->warning();
    //         return redirect()->route('home');
    //     }

    //     // Validate minimum order amount
    //     $subtotal = $carts->sum(function ($cartItem) {
    //         $product = Product::find($cartItem['product_id']);
    //         return cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
    //     });

    //     if (get_setting('minimum_order_amount_check') == 1 && $subtotal < get_setting('minimum_order_amount')) {
    //         flash(translate('Your order amount is less than the minimum order amount'))->warning();
    //         return redirect()->route('home');
    //     }

    //     // Finalize the order
    //     (new OrderController)->store($request);

    //     // Clear the user's cart
    //     Cart::where('user_id', $user_id)->delete();

    //     // Redirect to the order confirmation page
    //     flash(translate('Your order has been placed successfully!'))->success();
    //     return redirect()->route('order_confirmed');
    // }

    public function checkout_done($combined_order_id, $payment)
    {
        $combined_order = CombinedOrder::findOrFail($combined_order_id);
        foreach ($combined_order->orders as $key => $order) {
            $order = Order::findOrFail($order->id);
            $order->payment_status = 'unpaid';
            $order->payment_details = $payment;
            $order->save();
            calculateCommissionAffilationClubPoint($order);
        }
        Session::put('combined_order_id', $combined_order_id);
        return redirect()->route('order_confirmed');
    }
    public function get_shipping_info(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        //        if (Session::has('cart') && count(Session::get('cart')) > 0) {
        if ($carts && count($carts) > 0) {
            $categories = Category::all();
            return view('frontend.shipping_info', compact('categories', 'carts'));
        }
        flash(translate('Your cart is empty'))->success();
        return back();
    }
    // public function store_shipping_info(Request $request)
    // {
    //     if ($request->address_id == null) {
    //         flash(translate("Please add shipping address"))->warning();
    //         return back();
    //     }
    //     $carts = Cart::where('user_id', Auth::user()->id)->get();
    //     if($carts->isEmpty()) {
    //         flash(translate('Your cart is empty'))->warning();
    //         return redirect()->route('home');
    //     }
    //     foreach ($carts as $key => $cartItem) {
    //         $cartItem->address_id = $request->address_id;
    //         $cartItem->save();
    //     }
    //     $carrier_list = array();
    //     if(get_setting('shipping_type') == 'carrier_wise_shipping'){
    //         $zone = \App\Models\Country::where('id',$carts[0]['address']['country_id'])->first()->zone_id;
    //         $carrier_query = Carrier::query();
    //         $carrier_query->whereIn('id',function ($query) use ($zone) {
    //             $query->select('carrier_id')->from('carrier_range_prices')
    //             ->where('zone_id', $zone);
    //         })->orWhere('free_shipping', 1);
    //         $carrier_list = $carrier_query->get();
    //     }

    //     return view('frontend.delivery_info', compact('carts','carrier_list'));
    // }
    public function store_shipping_info(Request $request)
    {
        if ($request->address_id == null) {
            flash(translate("Please add shipping address"))->warning();
            return back();
        }
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }
        foreach ($carts as $key => $cartItem) {
            $cartItem->address_id = $request->address_id;
            $cartItem->save();
        }
        
        // Filter checked items for calculation
        $checkedCarts = $carts->filter(function ($cartItem) {
            return $cartItem['checked'] == 1;
        });
        
        // Calculate shipping, taxes, subtotal, and total
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;
        session()->put('address_id', $request->address_id);
        // foreach ($carts as $key => $cartItem) {
        foreach ($checkedCarts as $cartItem) {
            $product = Product::find($cartItem['product_id']);
            $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
            $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
            // Assume default shipping type is 'home_delivery' for simplicity
            $cartItem['shipping_type'] = 'home_delivery';
            $cartItem['shipping_cost'] = getShippingCost($carts, $key);
            $shipping += $cartItem['shipping_cost'];
            $cartItem->save();
        }
        $total = $subtotal + $tax + $shipping;
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        return view('frontend.payment_select', compact('carts', 'total', 'shipping_info'));
    }
    public function store_delivery_info(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)
            ->get();
        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;
        if ($carts && count($carts) > 0) {
            foreach ($carts as $key => $cartItem) {
                $product = Product::find($cartItem['product_id']);
                $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                if (get_setting('shipping_type') != 'carrier_wise_shipping' || $request['shipping_type_' . $product->user_id] == 'pickup_point') {
                    if ($request['shipping_type_' . $product->user_id] == 'pickup_point') {
                        $cartItem['shipping_type'] = 'pickup_point';
                        $cartItem['pickup_point'] = $request['pickup_point_id_' . $product->user_id];
                    } else {
                        $cartItem['shipping_type'] = 'home_delivery';
                    }
                    $cartItem['shipping_cost'] = 0;
                    if ($cartItem['shipping_type'] == 'home_delivery') {
                        $cartItem['shipping_cost'] = getShippingCost($carts, $key);
                    }
                } else {
                    $cartItem['shipping_type'] = 'carrier';
                    $cartItem['carrier_id'] = $request['carrier_id_' . $product->user_id];
                    $cartItem['shipping_cost'] = getShippingCost($carts, $key, $cartItem['carrier_id']);
                }
                $shipping += $cartItem['shipping_cost'];
                $cartItem->save();
            }
            $total = $subtotal + $tax + $shipping;
            return view('frontend.payment_select', compact('carts', 'shipping_info', 'total'));
        } else {
            flash(translate('Your Cart was empty'))->warning();
            return redirect()->route('home');
        }
    }
    public function apply_coupon_code(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();
        $response_message = array();
        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {
                    $coupon_details = json_decode($coupon->details);
                    $carts = Cart::where('user_id', Auth::user()->id)
                        ->where('owner_id', $coupon->user_id)
                        ->get();
                    $coupon_discount = 0;

                    if ($coupon->type == 'cart_base') {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        foreach ($carts as $key => $cartItem) {
                            $product = Product::find($cartItem['product_id']);
                            $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                            $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                            $shipping += $cartItem['shipping_cost'];
                        }
                        $sum = $subtotal + $tax + $shipping;
                        if ($sum >= $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount = ($sum * $coupon->discount) / 100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            } elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                        }
                    } elseif ($coupon->type == 'product_base') {
                        foreach ($carts as $key => $cartItem) {
                            $product = Product::find($cartItem['product_id']);
                            foreach ($coupon_details as $key => $coupon_detail) {
                                if ($coupon_detail->product_id == $cartItem['product_id']) {
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += (cart_product_price($cartItem, $product, false, false) * $coupon->discount / 100) * $cartItem['quantity'];
                                    } elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount * $cartItem['quantity'];
                                    }
                                }
                            }
                        }
                    }
                    if ($coupon_discount > 0) {
                        Cart::where('user_id', Auth::user()->id)
                            ->where('owner_id', $coupon->user_id)
                            ->update(
                                [
                                    'discount' => $coupon_discount / count($carts),
                                    'coupon_code' => $request->code,
                                    'coupon_applied' => 1
                                ]
                            );
                        $response_message['response'] = 'success';
                        $response_message['message'] = translate('Coupon has been applied');
                    } else {
                        $response_message['response'] = 'warning';
                        $response_message['message'] = translate('This coupon is not applicable to your cart products!');
                    }
                } else {
                    $response_message['response'] = 'warning';
                    $response_message['message'] = translate('You already used this coupon!');
                }
            } else {
                $response_message['response'] = 'warning';
                $response_message['message'] = translate('Coupon expired!');
            }
        } else {
            $response_message['response'] = 'danger';
            $response_message['message'] = translate('Invalid coupon!');
        }
        $carts = Cart::where('user_id', Auth::user()->id)
            ->get();
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $returnHTML = view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info'))->render();
        return response()->json(array('response_message' => $response_message, 'html' => $returnHTML));
    }
    public function remove_coupon_code(Request $request)
    {
        Cart::where('user_id', Auth::user()->id)
            ->update(
                [
                    'discount' => 0.00,
                    'coupon_code' => '',
                    'coupon_applied' => 0
                ]
            );
        $coupon = Coupon::where('code', $request->code)->first();
        $carts = Cart::where('user_id', Auth::user()->id)
            ->get();
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        return view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info'));
    }
    public function apply_club_point(Request $request)
    {
        if (addon_is_activated('club_point')) {
            $point = $request->point;
            if (Auth::user()->point_balance >= $point) {
                $request->session()->put('club_point', $point);
                flash(translate('Point has been redeemed'))->success();
            } else {
                flash(translate('Invalid point!'))->warning();
            }
        }
        return back();
    }
    public function remove_club_point(Request $request)
    {
        $request->session()->forget('club_point');
        return back();
    }
    // public function order_confirmed()
    // {
    //     dd(Session::get(Session::get('combined_order_id')));
    //     die;

    //     $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));


    //     Cart::where('user_id', $combined_order->user_id)
    //         ->delete();
    //     //Session::forget('club_point');
    //     //Session::forget('combined_order_id');

    //     // foreach($combined_order->orders as $order){
    //     //     NotificationUtility::sendOrderPlacedNotification($order);
    //     // }
    //     session()->forget(['payment_type', 'payment_option', 'payment_data', 'combined_order_id']);
    //     return view('frontend.order_confirmed', compact('combined_order'));
    // }
}
