<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SellerImportedProduct;
use Auth;
use App\Models\User;
use App\Models\ProductSellerMap;
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
        $seller_id = Auth::id();
        
        foreach ($productIds as $productId) {
            $product = Product::find($productId);
        
            if ($product) {
                
                // Find or create the seller
                $source_seller = User::find($product->user_id)->get();
        
                // Create or update the ProductSellerMap
                ProductSellerMap::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'seller_id' => $seller_id,
                        'source_seller_id' => $source_seller
                    ],
                    [
                        'sku' => $product->sku,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
        
        return response()->json(['success' => true, 'message' => 'Products mapped to sellers successfully.']);
    }

}