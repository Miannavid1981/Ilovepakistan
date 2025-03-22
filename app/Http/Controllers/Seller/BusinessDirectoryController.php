<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessDirectory;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SellerCategoryPreference;

// use App\Models\BusinessDirectory;
class BusinessDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $query = BusinessDirectory::where('user_id', Auth::id())->orderBy('created_at', 'DESC');

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
        $category_ids =  SellerCategoryPreference::where('user_id', auth()->user()->id)->pluck('category_id');
        $categories = Category::whereIn('id', $category_ids)->get();
        $brands = Brand::all();
        $cities = City::where('state_id', 2728)->get();

        $business_directory = $query->paginate(10);

        return view('seller.business_directory.index', compact('business_directory', 'categories', 'brands', 'cities'));
    }


    public function create()
    {

       $category_ids =  SellerCategoryPreference::where('user_id', auth()->user()->id)->pluck('category_id');

        return view('seller.business_directory.create', [
            'cities' => City::where('state_id', 2728)->get(),
            'areas' => [], // You might want to fetch areas based on the selected city dynamically via AJAX
            'categories' => Category::whereIn('id', $category_ids)->get(),
            'brands' => Brand::all(),
            'businessTypes' => [],
        ]);
    }
    
    public function export()
    {
        $business_directory = BusinessDirectory::where('user_id', auth()->id())->get();

        $csvFileName = 'Business Directory ' . now()->format('Y-m-d h:i:s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
        ];

        $callback = function () use ($business_directory) {
            $file = fopen('php://output', 'w');

            // Add CSV Header
            fputcsv($file, [
                'ID', 'Name', 'Phone', 'WhatsApp No', 'Designation', 
                'Business Name', 'Product Brand', 'Product Category', 
                'Business Type', 'Ownership Type', 'City', 'Area', 
                'Trust Level', 'Google Sheet'
            ]);

            // Add Data Rows
            foreach ($business_directory as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->phone,
                    $item->whatsapp_no,
                    $item->designation,
                    $item->company,
                    optional($item->brand)->name,
                    optional($item->category)->name,
                    $item->business_type,
                    $item->ownership_type,
                    optional($item->city)->name,
                    $item->area,
                    str_repeat('⭐️', $item->trust_level),
                    $item->google_sheet_url ?: 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
            'business_type' => 'required|string|max:255',
            'ownership_type' => 'required|string|max:255',
            'google_sheet_url' => 'nullable|url',
            'trust_level' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|file|mimes:pdf,doc,docx,txt|max:2048', 
            'brand_id' => 'required|exists:brands,id',
            
        ]);
        $notesPath = null;
        if ($request->hasFile('notes')) {
            $notesPath = $request->file('notes')->store('business_notes', 'public');
        }

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
            'brand_id' => $request->brand_id,
            'business_type' => $request->business_type,
            'ownership_type' => $request->ownership_type,
            'google_sheet_url' => $request->google_sheet_url,
            'trust_level' => $request->trust_level,
            'notes' => $notesPath, // Store the file path
        ]);


        return redirect()->route('seller.business-directory.index')->with('success', 'Added successfully.');
    }

    public function destroy(BusinessDirectory $business_directory)
    {
        if ($business_directory->user_id !== Auth::id()) {
            return redirect()->route('seller.business-directory.index')->with('error', 'Unauthorized.');
        }

        $business_directory->delete();
        return redirect()->route('seller.business-directory.index')->with('success', 'Deleted successfully.');
    }

    public function edit($id)
    {
        $business_directory = BusinessDirectory::findOrFail($id);
        $cities = City::where('state_id', 2728)->get();
        $categories = Category::all();

        return view('seller.business_directory.edit', compact('business_directory', 'cities', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'area' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'business_type' => 'nullable|string|max:255',
            'trust_level' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|file|max:2048',
        ]);

        $business_directory = BusinessDirectory::findOrFail($id);
        
        // Handle File Upload
        if ($request->hasFile('notes')) {
            $notesPath = $request->file('notes')->store('business_notes', 'public');
            $business_directory->notes = $notesPath;
        }

        // Update Business Info
        $business_directory->update($request->except('notes'));

        return redirect()->route('seller.business-directory.index')->with('success', 'Business updated successfully.');
    }
}
