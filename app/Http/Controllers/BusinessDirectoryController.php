<?php

namespace App\Http\Controllers;

use AizPackages\CombinationGenerate\Services\CombinationService;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Category;
use App\Models\BusinessDirectory;
use App\Models\City;
use Illuminate\Support\Facades\Auth;


class BusinessDirectoryController extends Controller
{
  
    public function __construct() {

    }
    public function index()
    {
        // Seller can only see their own business directory entries with pagination
        $business_directory = BusinessDirectory::paginate(10); // Show 10 items per page

        return view('backend.business_directory.index', compact('business_directory'));
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
