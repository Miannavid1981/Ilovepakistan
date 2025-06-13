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

    public function index()
    {
        $methods = TransferPaymentMethod::latest()->paginate(10);
        return view('backend.transfer_payment_methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:mobile,bank',
            'title' => 'required|string',
            'account_title' => 'required|string',
            'account_no' => 'nullable|string',
            'iban' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->status ?? 1;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('transfer_payment_methods', 'public');
        }

        TransferPaymentMethod::create($data);

        return redirect()->route('admin_transfer_payment_methods')->with('success', 'Payment method created.');
    }

    public function edit($id)
    {
        $method = TransferPaymentMethod::findOrFail($id);
        return view('backend.transfer_payment_methods.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = TransferPaymentMethod::findOrFail($id);

        $request->validate([
            'type' => 'required|in:mobile,bank',
            'title' => 'required|string',
            'account_title' => 'required|string',
            'account_no' => 'nullable|string',
            'iban' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->status ?? 1;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('transfer_payment_methods', 'public');
        }

        $method->update($data);

        return redirect()->route('admin_transfer_payment_methods')->with('success', 'Payment method updated.');
    }
}
