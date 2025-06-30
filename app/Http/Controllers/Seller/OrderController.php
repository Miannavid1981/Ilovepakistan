<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order;
use App\Models\ProductStock;
use App\Models\SmsTemplate;
use App\Models\User;
use App\Utility\NotificationUtility;
use App\Utility\SmsUtility;
use Illuminate\Http\Request;
use App\Models\OrdersExport;
use App\Utility\EmailUtility;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $query = Order::with('orderdetails.product.main_category')->orderBy('id', 'desc');

        if ($authUser->seller_type == 'brand_partner') {
            $query->whereHas('orderdetails', function ($q) use ($authUser) {
                $q->where('source_seller_id', $authUser->id);
            });
        }

        if ($authUser->seller_type == 'seller_partner') {
            $query->whereHas('orderdetails', function ($q) use ($authUser) {
                $q->where('seller_id', $authUser->id)
                ->orWhere('source_seller_id', $authUser->id);
            });
        }

        if ($authUser->seller_type == 'store_partner') {
            $query->whereHas('orderdetails', function ($q) use ($authUser) {
                $q->where('seller_id', $authUser->id);
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
    
        if ($request->filled('delivery_status')) {
            $query->where('delivery_status', $request->delivery_status);
        }
    
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }
        
        // Filtering by Product's Main Category (Using Relationship)
        if ($request->filled('category_id')) {
            if(!empty($request->category_id) ) {
                $query->whereHas('orderdetails.product.main_category', function ($q) use ($request) {
                    $q->where('id', $request->category_id); // Filter by category ID
                });
            }
        }
    
        $orders = $query->paginate(15);
    
        // Mark all orders as viewed in one query instead of looping
        Order::whereIn('id', $orders->pluck('id'))->update(['viewed' => 1]);
    
        return view('seller.orders.index', [
            'orders' => $orders,
            'payment_status' => $request->payment_status,
            'delivery_status' => $request->delivery_status,
            'sort_search' => $request->search,
            'category' => $request->category_id
        ]);
    }
    

    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order_shipping_address = json_decode($order->shipping_address);
        $delivery_boys = User::where('city', $order_shipping_address->city)
            ->where('user_type', 'delivery_boy')
            ->get();

        $order->viewed = 1;
        $order->save();
        return view('seller.orders.show', compact('order', 'delivery_boys'));
    }

    // Update Delivery Status
    public function update_delivery_status(Request $request)
    {   
        $authUser = Auth::user();
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->delivery_status = $request->status;
        $order->save();

        if($request->status == 'delivered'){
            $order->delivered_date = now();
            $order->save();
    
            // Call transaction service to handle wallet updates
            \App\Services\TransactionService::handleOrderDelivery($order);
        }

        if ($request->status == 'cancelled' && $order->payment_type == 'wallet') {
            $user = User::where('id', $order->user_id)->first();
            $user->balance += $order->grand_total;
            $user->save();
        }

        // If the order is cancelled and the seller commission is calculated, deduct seller earning
        if($request->status == 'cancelled' && $order->payment_status == 'paid' && $order->commission_calculated == 1){
            $sellerEarning = $order->commissionHistory->seller_earning;
            $shop = $order->shop;
            $shop->admin_to_pay -= $sellerEarning;
            $shop->save();
        }

        foreach ($order->orderDetails->where('seller_id', $authUser->id) as $key => $orderDetail) {
            $orderDetail->delivery_status = $request->status;
            $orderDetail->save();

            if ($request->status == 'cancelled') {
                product_restock($orderDetail);
            }
        }
        $combinedOrder =  $order->combinedOrder();
        if ($combinedOrder) {
            $allDelivered = $combinedOrder->orders()->where('delivery_status', '!=', 'delivered')->count() === 0;

            $combinedOrder->status = $allDelivered ? 'delivered' : 'pending';
            $combinedOrder->save();
        }
        
        // Delivery Status change email notification to Admin, seller, Customer
        EmailUtility::order_email($order, $request->status); 


        // Delivery Status change SMS notification
        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'delivery_status_change')->first()->status == 1) {
            try {
                SmsUtility::delivery_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {}
        }

        //Sends Web Notifications to user
        NotificationUtility::sendNotification($order, $request->status);

        //Sends Firebase Notifications to user

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
            if ($authUser->user_type == 'delivery_boy') {
                $deliveryBoyController = new DeliveryBoyController;
                $deliveryBoyController->store_delivery_history($order);
            }
        }

        return 1;
    }

    // Update Payment Status
    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
            $orderDetail->payment_status = $request->status;
            $orderDetail->save();
        }
        
        $status = 'paid';
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ($orderDetail->payment_status != 'paid') {
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();


        if ($order->payment_status == 'paid' && $order->commission_calculated == 0) {
            calculateCommissionAffilationClubPoint($order);
        }

        // Payment Status change email notification to Admin, seller, Customer
        if($request->status == 'paid'){
            EmailUtility::order_email($order, $request->status);  
        }

        //Sends Firebase Notifications to Admin, seller, Customer
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->payment_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;

            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
            try {
                SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {

            }
        }
        return 1;
    }

    public function orderBulkExport(Request $request)
    {
        if($request->id){
          return Excel::download(new OrdersExport($request->id), 'orders.xlsx');
        }
        return back();
    }

}
