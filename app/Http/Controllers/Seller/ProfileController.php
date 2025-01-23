<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\SellerProfileRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\SellerCategoryPreference;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses; 
        return view('seller.profile.index', compact('user','addresses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerProfileRequest $request , $id)
    {
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        
        $user->avatar_original = $request->photo;

        $shop = $user->shop;

        if($shop){
            $shop->cash_on_delivery_status = $request->cash_on_delivery_status;
            $shop->bank_payment_status = $request->bank_payment_status;
            $shop->bank_name = $request->bank_name;
            $shop->bank_acc_name = $request->bank_acc_name;
            $shop->bank_acc_no = $request->bank_acc_no;
            $shop->bank_routing_no = $request->bank_routing_no;

            $shop->save();
        }

        $user->save();

        flash(translate('Your Profile has been updated successfully!'))->success();
        return back();
    }

    public function savePreferences(Request $request)
    {
        $request->validate([
            'categories' => 'required|array|max:3', // Allow only 3 categories
            'categories.*' => 'exists:categories,id'
        ]);

        $user = auth()->user();

        // Clear previous preferences
        $user->categoryPreferences()->delete();

        // Save new preferences
        foreach ($request->categories as $categoryId) {
            SellerCategoryPreference::create([
                'user_id' => $user->id,
                'category_id' => $categoryId,
            ]);
        }

        return redirect()->back()->with('success', 'Category preferences saved successfully!');
    }
}
