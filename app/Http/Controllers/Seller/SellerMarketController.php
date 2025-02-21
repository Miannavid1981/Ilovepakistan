<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SellerImportedProduct;
use Auth;
use App\Models\User;
use App\Models\ProductSellerMap;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
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
        $importedProductIds = ProductSellerMap::where('seller_id', Auth::id())->pluck('product_id')->toArray();

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
        $seller = User::find($seller_id)->get();
        foreach ($productIds as $productId) {
            $product = Product::find($productId);
        
            if ($product) {

                $skin = get_product_full_skin_no(auth()->user(), $product);
                
                // Encrypt the value using Laravel's Crypt
                $encrypted = Crypt::encryptString($skin);
        
                // Hash the encrypted string (sha256) and encode it in base64
                $hashed = hash('sha256', $encrypted);  // You can use sha256 or another fixed-length hash
                $base64 = base64_encode($hashed);      // Encode hash to Base64 for display or storage
        
                // Truncate the hash to get a 10-character length (example length)
                $encryptedHash = Str::limit($base64, 10, '');
        
                            // Check if the ProductSellerMap already exists
                $exists = ProductSellerMap::where([
                    'product_id' => $product->id,
                    'seller_id' => $seller_id,
                    'source_seller_id' => $product->user_id,
                    'original_skin' => !empty($skin) ? $skin : ''
                ])->exists();

                if (!$exists) {
                    ProductSellerMap::create([
                        'product_id' => $product->id,
                        'seller_id' => $seller_id,
                        'source_seller_id' => $product->user_id,
                        'original_skin' => !empty($skin) ? $skin : '',
                        'encrypted_hash' => !empty($skin) ? $encryptedHash : null,
                        'encrypted_value' => !empty($skin) ? $encrypted : null,
                        'sku' => $product->stocks ? $product->stocks[0]->sku : null,
                        'imported' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        return response()->json(['success' => true, 'message' => 'Products mapped to sellers successfully.']);
    }

}