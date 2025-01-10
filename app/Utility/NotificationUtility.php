<?php

namespace App\Utility;

use App\Mail\InvoiceEmailManager;
use App\Models\User;
use App\Models\SmsTemplate;
use App\Http\Controllers\OTPVerificationController;
use Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;
use App\Models\FirebaseNotification;

class NotificationUtility
{
    //Combine Email Logic
    public static function sendOrderPlacedNotification($orders, $request = null)
    {
        // Common data for customer/admin email
        $array['view'] = 'emails.invoice';
        $array['subject'] = translate('A new order has been placed') . ' - ' . $orders[0]->code;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['orders'] = $orders;
    
       
        // Collect all order details for the combined customer/admin email
        $customer_admin_email_data = [
            'view' => 'emails.invoice', // Ensure view is passed here
            'subject' => translate('A new order has been placed') . ' - ' . $orders[0]->code,
            'from' => env('MAIL_FROM_ADDRESS'),
            'orders' => $orders,
            //'orderDetails' => $order->orderDetails, // All order details for combined email
        ];
        // Send combined email to customer and admin
        try {
            if ($orders[0]->user->email != null) {
                // Send email to customer
                Mail::to($orders[0]->user->email)->send(new InvoiceEmailManager($customer_admin_email_data));
            }
    
            // Send email to admin
            $admin_email = \App\Models\User::where('user_type', 'admin')->first()->email;
            if ($admin_email != null) {
                Mail::to($admin_email)->queue(new InvoiceEmailManager($customer_admin_email_data));
            }
        } catch (\Exception $e) {
            dd('Customer / Admin Mail sending error: ' . $e->getMessage());
        }
    
        // Send separate emails to sellers
        $sellers = $orders[0]->orderDetails->groupBy('product.user_id'); // Group order details by seller (product owner)
        foreach ($sellers as $seller_id => $orderDetails) {
            $seller = \App\Models\User::find($seller_id);
            if ($seller && $seller->email) {
                $seller_email_data = [
                    'view' => 'emails.invoice', // Ensure view is passed here
                    'subject' => translate('Order placed for your products') . ' - ' . $orders[0]->code,
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'orders' => $orders,
                    //'orderDetails' => $orderDetails, // Only this seller's products
                ];
                try {
                    Mail::to($seller->email)->queue(new InvoiceEmailManager($seller_email_data));
                } catch (\Exception $e) {
                    dd('Seller Mail sending error: ' . $e->getMessage());
                }
            }
        }
    
        // Send notifications to user and sellers
        self::sendNotification($orders, 'placed');
    
        // Send Firebase notifications if applicable
        if ($request != null && get_setting('google_firebase') == 1 && $orders[0]->user->device_token != null) {
            $request->device_token = $orders[0]->user->device_token;
            $request->title = "Order placed!";
            $request->text = "An order {$orders[0]->code} has been placed";
            $request->type = "order";
            $request->id = $orders[0]->id;
            $request->user_id = $orders[0]->user->id;
            self::sendFirebaseNotification($request);
        }
    }
    


    // public static function sendOrderPlacedNotification($order, $request = null)
    // {       
    //     //sends email to customer with the invoice pdf attached
    //     $array['view'] = 'emails.invoice';
    //     $array['subject'] = translate('A new order has been placed') . ' - ' . $order->code;
    //     $array['from'] = env('MAIL_FROM_ADDRESS');
    //     $array['order'] = $order;
    //     try {
    //         if ($order->user->email != null) {
    //             Mail::to($order->user->email)->queue(new InvoiceEmailManager($array));
    //         }
    //         // Mail::to($order->orderDetails->first()->product->user->email)->queue(new InvoiceEmailManager($array));
    //     } catch (\Exception $e) {
    //     }
    //     if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'order_placement')->first()->status == 1) {
    //         try {
    //             $otpController = new OTPVerificationController;
    //             $otpController->send_order_code($order);
    //         } catch (\Exception $e) {
    //         }
    //     }
    //     //sends Notifications to user
    //     self::sendNotification($order, 'placed');
    //     if ($request !=null && get_setting('google_firebase') == 1 && $order->user->device_token != null) {
    //         $request->device_token = $order->user->device_token;
    //         $request->title = "Order placed !";
    //         $request->text = "An order {$order->code} has been placed";
    //         $request->type = "order";
    //         $request->id = $order->id;
    //         $request->user_id = $order->user->id;
    //         self::sendFirebaseNotification($request);
    //     }
    // }
    public static function sendNotification($order, $order_status)
    {
        if ($order->seller_id == \App\Models\User::where('user_type', 'admin')->first()->id) {
            $users = User::findMany([$order->user->id, $order->seller_id]);
        } else {
            $users = User::findMany([$order->user->id, $order->seller_id, \App\Models\User::where('user_type', 'admin')->first()->id]);
        }
        $order_notification = array();
        $order_notification['order_id'] = $order->id;
        $order_notification['order_code'] = $order->code;
        $order_notification['user_id'] = $order->user_id;
        $order_notification['seller_id'] = $order->seller_id;
        $order_notification['status'] = $order_status;
        Notification::send($users, new OrderNotification($order_notification));
    }
    public static function sendFirebaseNotification($req)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'to' => $req->device_token,
            'notification' => [
                'body' => $req->text,
                'title' => $req->title,
                'sound' => 'default' /*Default sound*/
            ],
            'data' => [
                'item_type' => $req->type,
                'item_type_id' => $req->id,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
            ]
        );
        //$fields = json_encode($arrayToSend);
        $headers = array(
            'Authorization: key=' . env('FCM_SERVER_KEY'),
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        $firebase_notification = new FirebaseNotification;
        $firebase_notification->title = $req->title;
        $firebase_notification->text = $req->text;
        $firebase_notification->item_type = $req->type;
        $firebase_notification->item_type_id = $req->id;
        $firebase_notification->receiver_id = $req->user_id;
        $firebase_notification->save();
    }
}
