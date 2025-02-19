<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Models\CommissionHistory;
use App\Models\WalletTransaction;
use Auth;

class CommissionHistoryController extends Controller
{
    public function index(Request $request) {
        $seller_id = Auth::user()->id;
        $date_range = null;
    
        // Fetch wallet transactions for the seller
        $commission_history = WalletTransaction::where('user_id', $seller_id)
            ->orderBy('created_at', 'desc');
    
        // Filter by date range
        if ($request->date_range) {
            $date_range = $request->date_range;
            $date_range1 = explode(" / ", $request->date_range);
            $commission_history = $commission_history->whereBetween('created_at', [$date_range1[0], $date_range1[1]]);
        }
    
        $commission_history = $commission_history->paginate(10);
    
        // Calculate admin profit for each transaction
        foreach ($commission_history as $transaction) {
            $order = $transaction->order;
            $total_admin_profit = 0;
    
            if ($order) {
                foreach ($order->orderDetails as $detail) {
                    $product = $detail->product;
                    if ($product) {
                        $product_price = $product->price;
                        $admin_profit = $product_price - $transaction->amount;
                        $total_admin_profit += max($admin_profit, 0); // Ensure no negative values
                    }
                }
            }
    
            $transaction->admin_profit = $total_admin_profit;
        }
    
        return view('seller.commission_history.index', compact('commission_history', 'seller_id', 'date_range'));
    }
    
}
