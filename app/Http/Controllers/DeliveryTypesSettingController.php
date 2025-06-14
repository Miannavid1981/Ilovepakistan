<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryTypesSetting;

class DeliveryTypesSettingController extends Controller
{
    public function index()
    {
        $setting = DeliveryTypesSetting::firstOrCreate([]);
        return view('backend.delivery_types.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = DeliveryTypesSetting::first();

        $setting->update([
            'personal' => $request->has('personal'),
            'family_friends' => $request->has('family_friends'),
            'others' => $request->has('others'),
        ]);

        return redirect()->back()->with('success', 'Delivery types updated successfully.');
    }
}
