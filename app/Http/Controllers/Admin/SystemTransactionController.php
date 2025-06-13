<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;

class SystemTransactionController extends Controller
{
    public function index()
    {
        $transactions = WalletTransaction::orderBy('created_at', 'DESC')->get();

        return view('backend.system_transactions.index', compact('transactions'));
    }
}
