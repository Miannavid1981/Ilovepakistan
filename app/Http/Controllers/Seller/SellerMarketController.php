<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SellerImportedProduct;
class SellerMarketController extends Controller
{

    public function index(Request $request)
    {
        // Get the user's selected categories
        $selectedCategories = auth()->user()->categoryPreferences->pluck('category_id')->toArray();

        // Filter products by name and category, and paginate them
        $query = Product::whereIn('category_id', $selectedCategories);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12); // Paginate the products (12 per page)

        // Get already imported product IDs for the user
        $importedProductIds = SellerImportedProduct::where('user_id', Auth::id())->pluck('product_id')->toArray();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('seller.market.partials.product_cards', compact('products', 'importedProductIds'))->render(),
                'pagination' => view('seller.market.partials.pagination', compact('products'))->render(),
            ]);
        }

        return view('seller.market.index', compact('products', 'importedProductIds'));
    }

    public function store(Request $request)
    {
        $productIds = $request->input('product_ids', []);
        $userId = Auth::id();

        foreach ($productIds as $productId) {
            SellerImportedProduct::updateOrCreate(
                ['user_id' => $userId, 'product_id' => $productId],
                [] // Additional fields can go here
            );
        }

        return response()->json(['success' => true, 'message' => 'Products imported successfully.']);
    }

}