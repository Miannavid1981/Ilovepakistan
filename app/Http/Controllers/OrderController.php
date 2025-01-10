<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AffiliateController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\OrderDetail;
use App\Models\CouponUsage;
use App\Models\Coupon;
use App\Models\User;
use App\Models\CombinedOrder;
use App\Models\SmsTemplate;
use Auth;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Utility\NotificationUtility;
use CoreComponentRepository;
use App\Utility\SmsUtility;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_all_orders|view_inhouse_orders|view_seller_orders|view_pickup_point_orders'])->only('all_orders');
        $this->middleware(['permission:view_order_details'])->only('show');
        $this->middleware(['permission:delete_order'])->only('destroy', 'bulk_order_delete');
    }
    // All Orders
    public function all_orders(Request $request)
    {

        CoreComponentRepository::instantiateShopRepository();
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;
        $payment_status = '';
        //$orders = Order::orderBy('id', 'desc');
        $orders = CombinedOrder::with('orders')->orderBy('created_at', 'desc');
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        if (
            Route::currentRouteName() == 'inhouse_orders.index' &&
            Auth::user()->can('view_inhouse_orders')
        ) {
            $orders = $orders->where('orders.seller_id', '=', $admin_user_id);
        } else if (
            Route::currentRouteName() == 'seller_orders.index' &&
            Auth::user()->can('view_seller_orders')
        ) {
            $orders = $orders->where('orders.seller_id', '!=', $admin_user_id);
        } else if (
            Route::currentRouteName() == 'pick_up_point.index' &&
            Auth::user()->can('view_pickup_point_orders')
        ) {
            if (get_setting('vendor_system_activation') != 1) {
                $orders = $orders->where('orders.seller_id', '=', $admin_user_id);
            }
            $orders->where('shipping_type', 'pickup_point')->orderBy('code', 'desc');
            if (
                Auth::user()->user_type == 'staff' &&
                Auth::user()->staff->pick_up_point != null
            ) {
                $orders->where('
                ', 'pickup_point')
                    ->where('pickup_point_id', Auth::user()->staff->pick_up_point->id);
            }
        } else if (
            Route::currentRouteName() == 'all_orders.index' &&
            Auth::user()->can('view_all_orders')
        ) {
            if (get_setting('vendor_system_activation') != 1) {
                $orders = $orders->where('orders.seller_id', '=', $admin_user_id);
            }
        } else {
            abort(403);
        }
        if ($request->search) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])) . '  00:00:00')
                ->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])) . '  23:59:59');
        }
        $orders = $orders->paginate(15);
        return view('backend.sales.index', compact('orders', 'sort_search', 'payment_status', 'delivery_status', 'date'));
    }
    public function show($order_id, $id = null)
    {
       
        $order = Order::findOrFail(decrypt($order_id));
        $order_shipping_address = json_decode($order->shipping_address);
        $delivery_boys = User::where('city', $order_shipping_address->city)
            ->where('user_type', 'delivery_boy')
            ->get();
        $order->viewed = 1;
        $order->save();
        $combined_order = CombinedOrder::findOrFail(decrypt($id));
        $orders = $combined_order->orders;
        
        return view('backend.sales.show', compact('order', 'delivery_boys','orders'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //OrderController
    public function store(Request $request, $payment_option = null, $payment_data = null)
    {
        try {
            $carts = Cart::where('user_id', Auth::user()->id)->where('checked', 1)->get();
            if ($carts->isEmpty()) {
                flash(translate('Your cart is empty'))->warning();
                return redirect()->route('home');
            }

            $address = Address::where('id', $carts[0]['address_id'])->first();
            $shippingAddress = [];
            if ($address != null) {
                $shippingAddress['name']        = $address->name;
                $shippingAddress['email']       = Auth::user()->email;
                $shippingAddress['address']     = $address->address;
                $shippingAddress['country']     = $address->country->name;
                $shippingAddress['state']       = $address->state->name;
                $shippingAddress['city']        = $address->city->name;
                $shippingAddress['postal_code'] = $address->postal_code;
                $shippingAddress['phone']       = $address->phone;
                if ($address->latitude || $address->longitude) {
                    $shippingAddress['lat_lang'] = $address->latitude . ',' . $address->longitude;
                }
            }

            $combined_order = new CombinedOrder;
            $combined_order->user_id = Auth::user()->id;
            $combined_order->shipping_address = json_encode($shippingAddress);
            $combined_order->grand_total = 0; // Ensure grand_total is initialized
            $combined_order->save();

            $seller_products = array();
            foreach ($carts as $cartItem) {
                $product = Product::find($cartItem['product_id']);
                $seller_products[$product->user_id][] = $cartItem;
            }
            $ordercode = date('Ymd-His') . rand(10, 99);
            
            $shipping_types = $request->get('shipping_type_' . $cartItem->product_id);
            if($shipping_types == 'home_delivery'){
                $shipping_type = 'My Home';
            }
            elseif($shipping_types == 'friends_family'){
                $shipping_type = 'Family & Friends';
            }
            elseif($shipping_types == 'office'){
                $shipping_type = 'My Office';
            }else{
                $shipping_type = 'Others';
            }
            foreach ($seller_products as $seller_product) {
                $order = new Order;
                $order->combined_order_id = $combined_order->id;
                $order->user_id = Auth::user()->id;
                $order->shipping_address = $combined_order->shipping_address;
                $order->additional_info = $request->additional_info;
                $order->payment_type = $payment_option;
                $order->delivery_viewed = '0';
                $order->payment_status_viewed = '0';
                $order->code = $ordercode;
                $order->date = strtotime('now');
                $order->save();

                $subtotal = 0;
                $tax = 0;
                $shipping = 0;
                $coupon_discount = 0;

                foreach ($seller_product as $cartItem) {
                    $product = Product::find($cartItem['product_id']);
                    //$shipping_type = $request->get('shipping_type_' . $cartItem->product_id);

                    $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                    $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                    $coupon_discount += $cartItem['discount'];

                    // Check stock
                    $product_variation = $cartItem['variation'];
                    $product_stock = $product->stocks->where('variant', $product_variation)->first();
                    if ($product->digital != 1 && $cartItem['quantity'] > $product_stock->qty) {
                        flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
                        $order->delete();
                        return redirect()->route('cart')->send();
                    } elseif ($product->digital != 1) {
                        $product_stock->qty -= $cartItem['quantity'];
                        $product_stock->save();
                    }

                    $order_detail = new OrderDetail;
                    $order_detail->order_id = $order->id;
                    $order_detail->seller_id = $product->user_id;
                    $order_detail->product_id = $product->id;
                    $order_detail->variation = $product_variation;
                    $order_detail->price = cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                    $order_detail->tax = cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                    $order_detail->shipping_type = $shipping_type;
                    $order_detail->shipping_cost = $cartItem['shipping_cost'];
                    $shipping += $order_detail->shipping_cost;

                    $order_detail->quantity = $cartItem['quantity'];
                    $order_detail->save();

                    // Update product sale count
                    $product->num_of_sale += $cartItem['quantity'];
                    $product->save();

                    // If seller exists, update sales count
                    if ($product->added_by == 'seller' && $product->user->seller != null) {
                        $seller = $product->user->seller;
                        $seller->num_of_sale += $cartItem['quantity'];
                        $seller->save();
                    }

                    // Handle affiliate referral
                    if (addon_is_activated('affiliate_system') && $order_detail->product_referral_code) {
                        $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();
                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
                    }
                }

                $order->grand_total = $subtotal + $tax + $shipping - $coupon_discount;
                $combined_order->grand_total += $order->grand_total;
                $order->save();

                if ($seller_product[0]->coupon_code != null) {
                    $coupon_usage = new CouponUsage;
                    $coupon_usage->user_id = Auth::user()->id;
                    $coupon_usage->coupon_id = Coupon::where('code', $seller_product[0]->coupon_code)->first()->id;
                    $coupon_usage->save();
                }
            }
            $combined_order->save();
            $request->session()->put('combined_order_id', $combined_order->id);
            $orders = $combined_order->orders;
            NotificationUtility::sendOrderPlacedNotification($orders);
            // foreach ($combined_order->orders as $order) {
            //     NotificationUtility::sendOrderPlacedNotification($order);
            // }

            \Log::info($combined_order->id);
        } catch (\Exception $e) {
            \Log::info($e);
        }
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $carts = Cart::where('user_id', Auth::user()->id)->get();

    //         if ($carts->isEmpty()) {
    //             flash(translate('Your cart is empty'))->warning();
    //             return redirect()->route('home');
    //         }

    //         $address = Address::where('id', $carts[0]['address_id'])->first();

    //         $shippingAddress = [];
    //         if ($address != null) {
    //             $shippingAddress['name'] = Auth::user()->name;
    //             $shippingAddress['email'] = Auth::user()->email;
    //             $shippingAddress['address'] = $address->address;
    //             $shippingAddress['country'] = $address->country->name;
    //             $shippingAddress['state'] = $address->state->name;
    //             $shippingAddress['city'] = $address->city->name;
    //             $shippingAddress['postal_code'] = $address->postal_code;
    //             $shippingAddress['phone'] = $address->phone;
    //             if ($address->latitude || $address->longitude) {
    //                 $shippingAddress['lat_lang'] = $address->latitude . ',' . $address->longitude;
    //             }
    //         }

    //         // Create a combined order
    //         $combined_order = new CombinedOrder;
    //         $combined_order->user_id = Auth::user()->id;
    //         $combined_order->shipping_address = json_encode($shippingAddress);
    //         $combined_order->save();

    //         // Create a single order for all items
    //         $order = new Order;
    //         $order->combined_order_id = $combined_order->id;
    //         $order->user_id = Auth::user()->id;
    //         $order->shipping_address = $combined_order->shipping_address;
    //         $order->additional_info = $request->additional_info;
    //         $order->payment_type = $request->payment_option;
    //         $order->delivery_viewed = '0';
    //         $order->payment_status_viewed = '0';
    //         $order->code = date('Ymd-His') . rand(10, 99);
    //         $order->date = strtotime('now');
    //         $order->save();

    //         $subtotal = 0;
    //         $tax = 0;
    //         $shipping = 0;
    //         $coupon_discount = 0;

    //         foreach ($carts as $cartItem) {
    //             $product = Product::find($cartItem['product_id']);
    //             $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
    //             $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
    //             $coupon_discount += $cartItem['discount'];

    //             $product_variation = $cartItem['variation'];
    //             $product_stock = $product->stocks->where('variant', $product_variation)->first();

    //             if ($product->digital != 1 && $cartItem['quantity'] > $product_stock->qty) {
    //                 flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
    //                 $order->delete();
    //                 return redirect()->route('cart')->send();
    //             } elseif ($product->digital != 1) {
    //                 $product_stock->qty -= $cartItem['quantity'];
    //                 $product_stock->save();
    //             }

    //             $order_detail = new OrderDetail;
    //             $order_detail->order_id = $order->id;
    //             $order_detail->seller_id = $product->user_id;
    //             $order_detail->product_id = $product->id;
    //             $order_detail->variation = $product_variation;
    //             $order_detail->price = cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
    //             $order_detail->tax = cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
    //             $order_detail->shipping_type = $cartItem['shipping_type'];
    //             $order_detail->product_referral_code = $cartItem['product_referral_code'];
    //             $order_detail->shipping_cost = $cartItem['shipping_cost'];
    //             $order_detail->quantity = $cartItem['quantity'];

    //             $shipping += $order_detail->shipping_cost;

    //             if (addon_is_activated('club_point')) {
    //                 $order_detail->earn_point = $product->earn_point;
    //             }

    //             $order_detail->save();

    //             $product->num_of_sale += $cartItem['quantity'];
    //             $product->save();

    //             $order->seller_id = $product->user_id;
    //             $order->shipping_type = $cartItem['shipping_type'];

    //             if ($cartItem['shipping_type'] == 'pickup_point') {
    //                 $order->pickup_point_id = $cartItem['pickup_point'];
    //             }
    //             if ($cartItem['shipping_type'] == 'carrier') {
    //                 $order->carrier_id = $cartItem['carrier_id'];
    //             }

    //             if ($product->added_by == 'seller' && $product->user->seller != null) {
    //                 $seller = $product->user->seller;
    //                 $seller->num_of_sale += $cartItem['quantity'];
    //                 $seller->save();
    //             }

    //             if (addon_is_activated('affiliate_system') && $order_detail->product_referral_code) {
    //                 $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();
    //                 $affiliateController = new AffiliateController;
    //                 $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
    //             }
    //         }

    //         // Final order calculations
    //         $order->grand_total = $subtotal + $tax + $shipping;
    //         if ($carts[0]->coupon_code != null) {
    //             $order->coupon_discount = $coupon_discount;
    //             $order->grand_total -= $coupon_discount;

    //             $coupon_usage = new CouponUsage;
    //             $coupon_usage->user_id = Auth::user()->id;
    //             $coupon_usage->coupon_id = Coupon::where('code', $carts[0]->coupon_code)->first()->id;
    //             $coupon_usage->save();
    //         }

    //         $combined_order->grand_total = $order->grand_total;
    //         $order->save();
    //         $combined_order->save();

    //         foreach ($combined_order->orders as $order) {
    //             NotificationUtility::sendOrderPlacedNotification($order);
    //         }

    //         $request->session()->put('combined_order_id', $combined_order->id);
    //     } catch (\Exception $e) {
    //         \Log::info($e);
    //     }
    // }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                try {
                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                } catch (\Exception $e) {
                }
                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }
    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }
        return 1;
    }
    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->save();
        return view('seller.order_details_seller', compact('order'));
    }
    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->delivery_status = $request->status;
        $order->save();
        if ($request->status == 'cancelled' && $order->payment_type == 'wallet') {
            $user = User::where('id', $order->user_id)->first();
            $user->balance += $order->grand_total;
            $user->save();
        }
        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();
                if ($request->status == 'cancelled') {
                    $variant = $orderDetail->variation;
                    if ($orderDetail->variation == null) {
                        $variant = '';
                    }
                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                        ->where('variant', $variant)
                        ->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                }
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();
                if ($request->status == 'cancelled') {
                    $variant = $orderDetail->variation;
                    if ($orderDetail->variation == null) {
                        $variant = '';
                    }
                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                        ->where('variant', $variant)
                        ->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                }
                if (addon_is_activated('affiliate_system')) {
                    if (($request->status == 'delivered' || $request->status == 'cancelled') &&
                        $orderDetail->product_referral_code
                    ) {
                        $no_of_delivered = 0;
                        $no_of_canceled = 0;
                        if ($request->status == 'delivered') {
                            $no_of_delivered = $orderDetail->quantity;
                        }
                        if ($request->status == 'cancelled') {
                            $no_of_canceled = $orderDetail->quantity;
                        }
                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();
                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, 0, $no_of_delivered, $no_of_canceled);
                    }
                }
            }
        }
        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'delivery_status_change')->first()->status == 1) {
            try {
                SmsUtility::delivery_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {
            }
        }
        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->delivery_status);
            $request->text = " Your order {$order->code} has been {$status}";
            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;
            NotificationUtility::sendFirebaseNotification($request);
        }
        if (addon_is_activated('delivery_boy')) {
            if (Auth::user()->user_type == 'delivery_boy') {
                $deliveryBoyController = new DeliveryBoyController;
                $deliveryBoyController->store_delivery_history($order);
            }
        }
        return 1;
    }
    public function update_tracking_code(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->tracking_code = $request->tracking_code;
        $order->save();
        return 1;
    }
    // public function update_payment_status(Request $request)
    // {
    //     $order = Order::findOrFail($request->order_id);
    //     $order->payment_status_viewed = '0';
    //     $order->save();
    //     if (Auth::user()->user_type == 'seller') {
    //         foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
    //             $orderDetail->payment_status = $request->status;
    //             $orderDetail->save();
    //         }
    //     } else {
    //         foreach ($order->orderDetails as $key => $orderDetail) {
    //             $orderDetail->payment_status = $request->status;
    //             $orderDetail->save();
    //         }
    //     }
    //     $status = 'paid';
    //     foreach ($order->orderDetails as $key => $orderDetail) {
    //         if ($orderDetail->payment_status != 'paid') {
    //             $status = 'unpaid';
    //         }
    //     }
    //     $order->payment_status = $status;
    //     $order->save();
    //     if (
    //         $order->payment_status == 'paid' &&
    //         $order->commission_calculated == 0
    //     ) {
    //         calculateCommissionAffilationClubPoint($order);
    //     }
    //     //sends Notifications to user
    //     NotificationUtility::sendNotification($order, $request->status);
    //     if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
    //         $request->device_token = $order->user->device_token;
    //         $request->title = "Order updated !";
    //         $status = str_replace("_", "", $order->payment_status);
    //         $request->text = " Your order {$order->code} has been {$status}";
    //         $request->type = "order";
    //         $request->id = $order->id;
    //         $request->user_id = $order->user->id;
    //         NotificationUtility::sendFirebaseNotification($request);
    //     }
    //     if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
    //         try {
    //             SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
    //         } catch (\Exception $e) {
    //         }
    //     }
    //     return 1;
    // }
    public function update_payment_status(Request $request)
    {
        // Fetch all orders with the matching code (this could return multiple records)
        $orders = Order::where('code', $request->order_id)->get();

        foreach ($orders as $order) {
            // Set payment_status_viewed to 0 for the current order
            $order->payment_status_viewed = '0';
            $order->save();

            // If the user is a seller, update their respective order details
            if (Auth::user()->user_type == 'seller') {
                foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $orderDetail) {
                    $orderDetail->payment_status = $request->status;
                    $orderDetail->save();
                }
            } else {
                // For non-sellers, update all order details
                foreach ($order->orderDetails as $orderDetail) {
                    $orderDetail->payment_status = $request->status;
                    $orderDetail->save();
                }
            }

            // Check if all order details are marked as 'paid'
            $status = 'paid';
            foreach ($order->orderDetails as $orderDetail) {
                if ($orderDetail->payment_status != 'paid') {
                    $status = 'unpaid';
                    break; // If any detail is unpaid, no need to continue the loop
                }
            }

            // Update the order's payment status
            $order->payment_status = $status;
            $order->save();

            // If the order is fully paid and commission hasn't been calculated, do so
            if ($order->payment_status == 'paid' && $order->commission_calculated == 0) {
                calculateCommissionAffilationClubPoint($order);
            }

            // Send Notifications to the user
            NotificationUtility::sendNotification($order, $request->status);

            // Send Firebase notification if enabled
            if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
                $request->device_token = $order->user->device_token;
                $request->title = "Order updated!";
                $status = str_replace("_", "", $order->payment_status);
                $request->text = "Your order {$order->code} has been {$status}";
                $request->type = "order";
                $request->id = $order->id;
                $request->user_id = $order->user->id;
                NotificationUtility::sendFirebaseNotification($request);
            }

            // Send SMS if OTP system is activated and the payment status change template is enabled
            if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
                try {
                    SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
                } catch (\Exception $e) {
                    // Handle exception (optional logging can be done here)
                }
            }
        }

        return 1;
    }

    public function assign_delivery_boy(Request $request)
    {
        if (addon_is_activated('delivery_boy')) {
            $order = Order::findOrFail($request->order_id);
            $order->assign_delivery_boy = $request->delivery_boy;
            $order->delivery_history_date = date("Y-m-d H:i:s");
            $order->save();
            $delivery_history = \App\Models\DeliveryHistory::where('order_id', $order->id)
                ->where('delivery_status', $order->delivery_status)
                ->first();
            if (empty($delivery_history)) {
                $delivery_history = new \App\Models\DeliveryHistory;
                $delivery_history->order_id = $order->id;
                $delivery_history->delivery_status = $order->delivery_status;
                $delivery_history->payment_type = $order->payment_type;
            }
            $delivery_history->delivery_boy_id = $request->delivery_boy;
            $delivery_history->save();
            if (env('MAIL_USERNAME') != null && get_setting('delivery_boy_mail_notification') == '1') {
                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('You are assigned to delivery an order. Order code') . ' - ' . $order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;
                try {
                    Mail::to($order->delivery_boy->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }
            if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'assign_delivery_boy')->first()->status == 1) {
                try {
                    SmsUtility::assign_delivery_boy($order->delivery_boy->phone, $order->code);
                } catch (\Exception $e) {
                }
            }
        }
        return 1;
    }
}
