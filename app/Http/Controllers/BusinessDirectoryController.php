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

use App\Models\Brand;
use App\Models\SellerCategoryPreference;


class BusinessDirectoryController extends Controller
{
  
    public function __construct() {

    }
    public function index(Request $request)
    {
     
        $query = BusinessDirectory::orderBy('created_at', 'DESC');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('ownership_type')) {
            $query->where('ownership_type', $request->ownership_type);
        }

        if ($request->filled('business_type')) {
            $query->where('business_type', $request->business_type);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('trust_level')) {
            $query->where('trust_level', $request->trust_level);
        }
        
        $categories = Category::all();
        $brands = Brand::all();
        $cities = City::where('state_id', 2728)->get();

        $business_directory = $query->paginate(20);

        return view('backend.business_directory.index', compact('business_directory', 'categories', 'brands', 'cities'));
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
