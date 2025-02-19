<?php


namespace App\Services;

use App\Models\Order;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionService {
    public static function handleOrderDelivery(Order $order) {
        DB::transaction(function () use ($order) {
            $admin = User::where('role', 'admin')->first();
            if (!$admin) {
                throw new \Exception("Admin user not found!");
            }

            $adminWallet = Wallet::firstOrCreate(['user_id' => $admin->id]);

            foreach ($order->orderDetails as $detail) {
                $seller = User::find($detail->seller_id);
                $sourceSeller = User::find($detail->source_seller_id);

                $sellerWallet = $seller ? Wallet::firstOrCreate(['user_id' => $seller->id]) : null;
                $sourceSellerWallet = $sourceSeller ? Wallet::firstOrCreate(['user_id' => $sourceSeller->id]) : null;

                // Transfer Admin Profit
                if ($detail->admin_profit_amount > 0) {
                    $adminWallet->credit(
                        $detail->admin_profit_amount,
                        'system',
                        "Admin profit from Order #{$order->id}, Product #{$detail->product_id}",
                        $detail->seller_id
                    );
                }

                // Transfer Source Seller Profit (if applicable)
                if ($sourceSellerWallet && $detail->source_seller_profit_amount > 0) {
                    $sourceSellerWallet->credit(
                        $detail->source_seller_profit_amount,
                        'system',
                        "Source Seller commission from Order #{$order->id}, Product #{$detail->product_id}",
                        $detail->seller_id
                    );
                }


                // Transfer Seller Profit
                  if ($sellerWallet && $detail->seller_profit_amount > 0) {
                    $sellerWallet->credit(
                        $detail->seller_profit_amount,
                        'system',
                        "Seller earnings from Order #{$order->id}, Product #{$detail->product_id}",
                        $admin->id
                    );
                }
            }

            // Update order status to delivered
            $order->update(['status' => 'delivered']);
        });
    }
}
