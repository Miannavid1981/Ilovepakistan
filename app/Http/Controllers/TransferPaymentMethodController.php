<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferPaymentMethod;

class TransferPaymentMethodController extends Controller
{
    public function showDetails($slug)
    {
        $method = TransferPaymentMethod::where('slug', $slug)->first();

        if (!$method) {
            return response('<div class="alert alert-danger">Payment method not found.</div>', 404);
        }

        return view('frontend.partials.payment_method_detail', compact('method'));
    }
}
