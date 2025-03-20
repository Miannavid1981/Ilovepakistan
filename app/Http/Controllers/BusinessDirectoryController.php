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
            'whatsapp_no' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'area' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'product_category_id' => 'required|exists:categories,id',
            'business_type' => 'required|string|max:255',
            'ownership_type' => 'required|string|max:255',
            'google_sheet_url' => 'nullable|url',
            'trust_level' => 'required|integer|min:1|max:5',
        ]);
    
        BusinessDirectory::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'whatsapp_no' => $request->whatsapp_no,
            'designation' => $request->designation,
            'company' => $request->company,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'category_id' => $request->category_id,
            'product_category_id' => $request->product_category_id,
            'business_type' => $request->business_type,
            'ownership_type' => $request->ownership_type,
            'google_sheet_url' => $request->google_sheet_url,
            'trust_level' => $request->trust_level,
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
