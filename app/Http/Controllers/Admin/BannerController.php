<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('backend.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('backend.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|integer', // this will be the upload_id
        ]);

        Banner::create([
            'image' => $request->image,
        ]);

        return redirect()->route('admin.home_banners.index')->with('success', 'Banner added!');
    }

    public function destroy($id)
    {
        $banner = \App\Models\Banner::findOrFail($id);

        // optional: delete image file too
        if ($banner->image && \Storage::disk('public')->exists($banner->image)) {
            \Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.home_banners.index')->with('success', 'Banner deleted successfully!');
    }

}
