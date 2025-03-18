<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessDirectory;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\Category;
// use App\Models\BusinessDirectory;
class BusinessDirectoryController extends Controller
{
    public function index()
    {
        // Seller can only see their own business directory entries
        $business_directory = BusinessDirectory::where('user_id', Auth::id())->paginate(10);
        return view('seller.business_directory.index', compact('business_directory'));
    }

    public function create()
    {
        return view('seller.business_directory.create', [
            'cities' => City::where('state_id', 2728)->get(),
            'areas' => [], // You might want to fetch areas based on the selected city dynamically via AJAX
            'categories' => Category::all(),
            'businessTypes' => [],
        ]);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'company' => 'nullable|string|max:255', // Allow null values
            'city_id' => 'required|exists:cities,id', // Ensure city_id is required
            'area' => 'nullable|string|max:255', // Validate area_id if provided
            'category_id' => 'required|exists:categories,id', // Ensure category_id is required
            'business_type' => 'nullable|string|max:255', // Validate if provided
        ]);
        

        BusinessDirectory::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'company' => $request->company,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'category_id' => $request->category_id,
            'business_type' => $request->business_type,
        ]);

        return redirect()->route('seller.business-directory.index')->with('success', 'Business added successfully.');
    }
    public function destroy(BusinessDirectory $business_directory)
    {
        if ($business_directory->user_id !== Auth::id()) {
            return redirect()->route('seller.business-directory.index')->with('error', 'Unauthorized.');
        }

        $business_directory->delete();
        return redirect()->route('seller.business-directory.index')->with('success', 'Business deleted successfully.');
    }

}
