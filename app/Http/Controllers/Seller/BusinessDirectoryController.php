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
            'business_type' => $request->business_type,
            'ownership_type' => $request->ownership_type,
            'google_sheet_url' => $request->google_sheet_url,
            'trust_level' => $request->trust_level,
            'notes' => $notesPath, // Store the file path
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
