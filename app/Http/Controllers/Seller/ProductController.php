<?php

namespace App\Http\Controllers\Seller;

use AizPackages\CombinationGenerate\Services\CombinationService;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTax;
use App\Models\ProductTranslation;
use App\Models\Wishlist;
use App\Models\User;
use App\Notifications\ShopProductNotification;
use Carbon\Carbon;
use Combinations;
use Artisan;
use Auth;
use Str;
use Illuminate\Support\Facades\DB;

use App\Services\ProductService;
use App\Services\ProductTaxService;
use App\Services\ProductFlashDealService;
use App\Services\ProductStockService;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    protected $productService;
    protected $productCategoryService;
    protected $productTaxService;
    protected $productFlashDealService;
    protected $productStockService;

    public function __construct(
        ProductService $productService,
        ProductTaxService $productTaxService,
        ProductFlashDealService $productFlashDealService,
        ProductStockService $productStockService
    ) {
        $this->productService = $productService;
        $this->productTaxService = $productTaxService;
        $this->productFlashDealService = $productFlashDealService;
        $this->productStockService = $productStockService;
    }

    // public function index(Request $request)
    // {
    //     $search = null;
    //     $products = Product::where('user_id', Auth::user()->id)->where('digital', 0)->where('auction_product', 0)->where('wholesale_product', 0)->orderBy('created_at', 'desc');
    //     if ($request->has('search')) {
    //         $search = $request->search;
    //         $products = $products->where('name', 'like', '%' . $search . '%');
    //     }
    //     $categories = Category::where('parent_id', 0)
    //         ->where('digital', 0)
    //         ->with('childrenCategories')
    //         ->get();
    //     $products = $products->paginate(10);
    //     return view('seller.product.products.index', compact('products', 'categories','search'));
    // }
    
//     public function index(Request $request)
// {
//     $search = $request->search;
//     $category_id = $request->category_id;
//     $brand_id = $request->brand_id;

//     $products = Product::where('user_id', Auth::user()->id)
//         ->where('digital', 0)
//         ->where('auction_product', 0)
//         ->where('wholesale_product', 0)
//         ->orderBy('created_at', 'desc');

//     if ($search) {
//         $products = $products->where('name', 'like', '%' . $search . '%');
//     }
//     if ($category_id) {
//         $products = $products->where('category_id', $category_id);
//     }
//     if ($brand_id) {
//         $products = $products->where('brand_id', $brand_id);
//     }

//     $categories = Category::where('parent_id', 0)
//         ->where('digital', 0)
//         ->with('childrenCategories')
//         ->get();

//     $brands = \App\Models\Brand::all();

//     $products = $products->paginate(10);

//     return view('seller.product.products.index', compact('products', 'categories', 'brands', 'search'));
// }

// public function index(Request $request)
// {
    
//     $search = $request->search;
//     $category_id = $request->category_id;
//     $brand_id = $request->brand_id;

//     // Start building the query for products
//     $productsQuery = Product::where('user_id', Auth::user()->id)
//                         ->where('digital', 0)
//                         ->where('auction_product', 0)
//                         ->where('wholesale_product', 0)
//                         ->orderBy('created_at', 'desc');

//     if ($search) {
//         $productsQuery->where('name', 'like', '%' . $search . '%');
//     }
//     if ($category_id) {
//         $productsQuery->whereHas('categories', function($query) use ($category_id) {
//             $query->where('categories.id', $category_id);
//         });
//     }
//     if ($brand_id) {
//         $productsQuery->where('brand_id', $brand_id);
//     }

//     // Execute the query to get the products
//     $products = $productsQuery->paginate(10);

//     // Fetch categories that are linked to the products being displayed
//     $categoryIds = $productsQuery->join('product_categories', 'products.id', '=', 'product_categories.product_id')
//                     ->pluck('product_categories.category_id')
//                     ->unique();

//     $categories = Category::whereIn('id', $categoryIds)
//                     ->where('parent_id', 0) // Assuming you still want to fetch only top-level categories
//                     ->with('childrenCategories')
//                     ->get();
//         \Log::info($categoryIds);
//     $brands = \App\Models\Brand::all();

//     return view('seller.product.products.index', compact('products', 'categories', 'brands', 'search'));
// }

        public function index(Request $request)
            {
                $userId = Auth::user()->id;
                $search = $request->search;
                $category_id = $request->category_id;
                $brand_id = $request->brand_id;
                $showAll = $request->query('all', false);
                // Build the query for products with applied filters
                $productsQuery = Product::where('user_id', $userId)
                                        ->where('digital', 0)
                                        ->where('auction_product', 0)
                                        ->where('wholesale_product', 0)
                                        ->orderBy('created_at', 'desc');
            
                if ($search) {
                    $productsQuery->where('name', 'like', '%' . $search . '%');
                }
                if ($category_id) {
                    $productsQuery->whereHas('categories', function($query) use ($category_id) {
                        $query->where('categories.id', $category_id);
                    });
                }
                if ($brand_id) {
                    $productsQuery->where('brand_id', $brand_id);
                }
            
                if ($request->has('subcategory') && $request->subcategory != '') {
                        $subcategory_id = $request->subcategory;
                        $productsQuery->whereHas('categories', function ($query) use ($subcategory_id) {
                            $query->where('categories.id', $subcategory_id);
                        });
                    }
                if ($request->has('subcategory2') && $request->subcategory2 != '') {
                        $subcategory_id2 = $request->subcategory2;
                        $productsQuery->whereHas('categories', function ($query) use ($subcategory_id2) {
                            $query->where('categories.id', $subcategory_id2);
                        });
                    }
                
                if ($showAll === 'true') {
                        $products = $productsQuery->get(); 
                    } else {
                        $products = $productsQuery->paginate(10); 
                    }
                // Fetch categories and brands associated with seller's products and are enabled in preferences
                $enabledCategoriesQuery = Category::whereExists(function ($query) use ($userId) {
                    $query->select(DB::raw(1))
                          ->from('seller_category_preferences')
                          ->whereColumn('seller_category_preferences.category_id', 'categories.id')
                          ->where('seller_category_preferences.user_id', $userId)
                          ->where('seller_category_preferences.status', 1);
                });
            
                $categoryIds = Product::where('user_id', $userId)
                                    ->where('digital', 0)
                                    ->where('auction_product', 0)
                                    ->where('wholesale_product', 0)
                                    ->join('product_categories', 'products.id', '=', 'product_categories.product_id')
                                    ->pluck('product_categories.category_id')
                                    ->unique();
            
                $categories = $enabledCategoriesQuery->where('parent_id',0)->whereIn('id', $categoryIds)->get();
                
                $sub_categories = $enabledCategoriesQuery->whereIn('id', $categoryIds)->where('parent_id', '!=', 0)->get();
                $brandIds = Product::where('user_id', $userId)
                                    ->where('digital', 0)
                                    ->where('auction_product', 0)
                                    ->where('wholesale_product', 0)
                                    ->pluck('brand_id')
                                    ->unique();
            if ($request->ajax()) {
                        return response()->json($products);
                    }
                $brands = \App\Models\Brand::whereIn('id', $brandIds)->get();
            
                return view('seller.product.products.index', compact('products', 'categories', 'brands', 'search','sub_categories'));
            }


    public function create(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check()) {
                flash(translate('Please upgrade your package.'))->warning();
                return back();
            }
        }
        
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->whereExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                      ->from('seller_category_preferences')
                      ->whereColumn('seller_category_preferences.category_id', 'categories.id')
                      ->where('seller_category_preferences.user_id', $userId)
                      ->where('seller_category_preferences.status', 1); // Adjusted from 'ins_enabled' to 'status'
            })
            ->with('childrenCategories')
            ->get();
        return view('seller.product.products.create', compact('categories','user'));
    }

    public function store(ProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check()) {
                flash(translate('Please upgrade your package.'))->warning();
                return redirect()->route('seller.products');
            }
        }

        $product = $this->productService->store($request->except([
            '_token', 'sku', 'choice', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]));
        $request->merge(['product_id' => $product->id]);

        ///Product categories
        $product->categories()->attach($request->category_ids);

        //VAT & Tax
        if ($request->tax_id) {
            $this->productTaxService->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        //Product Stock
        $this->productStockService->store($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id'
        ]), $product);

        // Product Translations
        $request->merge(['lang' => env('DEFAULT_LANGUAGE')]);
        ProductTranslation::create($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));
//Product sku
 if ($request->sku) {
        $sku = $request->sku;
        $parentSku = DB::table('parent_skus')->where('sku', $sku)->first();

        if ($parentSku) {
            // SKU exists in parent_skus, add to child_skus
            DB::table('child_skus')->insert([
                'product_id' => $product->id,
                'parent_id' => $parentSku->id,
                'sku' => $sku,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {

            // Add to Parent_skus
            DB::table('parent_skus')->insert([
                'product_id' => $product->id,
                'sku' => $sku,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }



        if (get_setting('product_approve_by_admin') == 1) {
            $users = User::findMany([auth()->user()->id, User::where('user_type', 'admin')->first()->id]);
            Notification::send($users, new ShopProductNotification('physical', $product));
        }

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('seller.products');
    }

public function edit(Request $request, $id)
{
    $product = Product::findOrFail($id);

    if (Auth::user()->id != $product->user_id) {
        flash(translate('This product is not yours.'))->warning();
        return back();
    }

    $lang = $request->lang;
    $tags = json_decode($product->tags);
    $categories = Category::where('parent_id', 0)
        ->where('digital', 0)
        ->where('status',1)
        ->with('childrenCategories')
        ->get();

    // Load the old categories from the product
    $old_categories = $product->categories->pluck('id')->toArray();

    return view('seller.product.products.edit', compact('product', 'categories', 'tags', 'lang', 'old_categories'));
}

    public function update(ProductRequest $request, Product $product)
    {
        //Product
        $product = $this->productService->update($request->except([
            '_token', 'sku', 'choice', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]), $product);

        $request->merge(['product_id' => $product->id]);

        //Product categories
        $product->categories()->sync($request->category_ids);

        //Product Stock
        $product->stocks()->delete();
        $this->productStockService->store($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id'
        ]), $product);

        //VAT & Tax
        if ($request->tax_id) {
            $product->taxes()->delete();
            $request->merge(['product_id' => $product->id]);
            $this->productTaxService->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        // Product Translations
        ProductTranslation::updateOrCreate(
            $request->only([
                'lang', 'product_id'
            ]),
            $request->only([
                'name', 'unit', 'description'
            ])
        );


        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back();
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = (new CombinationService())->generate_combination($options);
        return view('backend.product.products.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = (new CombinationService())->generate_combination($options);
        return view('backend.product.products.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }

    public function add_more_choice_option(Request $request)
    {
        $all_attribute_values = AttributeValue::with('attribute')->where('attribute_id', $request->attribute_id)->get();

        $html = '';

        foreach ($all_attribute_values as $row) {
            $html .= '<option value="' . $row->value . '">' . $row->value . '</option>';
        }

        echo json_encode($html);
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        if (addon_is_activated('seller_subscription') && $request->status == 1) {
            $shop = $product->user->shop;
            if (!seller_package_validity_check()) {
                return 2;
            }
        }
        $product->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->seller_featured = $request->status;
        if ($product->save()) {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return 1;
        }
        return 0;
    }

public function duplicate($id)
{
    $product = Product::find($id);

    if (Auth::user()->id != $product->user_id) {
        flash(translate('This product is not yours.'))->warning();
        return back();
    }

    if (addon_is_activated('seller_subscription')) {
        if (!seller_package_validity_check()) {
            flash(translate('Please upgrade your package.'))->warning();
            return back();
        }
    }

    //Product
    $product_new = $this->productService->product_duplicate_store($product);

    // Duplicate categories
    $product_new->categories()->sync($product->categories->pluck('id')->toArray());

    //Product Stock
    $this->productStockService->product_duplicate_store($product->stocks, $product_new);

    //VAT & Tax
    $this->productTaxService->product_duplicate_store($product->taxes, $product_new);

    flash(translate('Product has been duplicated successfully'))->success();
    return redirect()->route('seller.products.edit', $product_new->id); // Redirect to the edit page of the duplicated product
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (Auth::user()->id != $product->user_id) {
            flash(translate('This product is not yours.'))->warning();
            return back();
        }

        $product->product_translations()->delete();
        $product->categories()->detach();
        $product->stocks()->delete();
        $product->taxes()->delete();


        if (Product::destroy($id)) {
            Cart::where('product_id', $id)->delete();
            Wishlist::where('product_id', $id)->delete();

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_product_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $product_id) {
                $this->destroy($product_id);
            }
        }

        return 1;
    }
    
    public function getSubcategories(Request $request)
        {
            $subcategories = Category::where('parent_id', $request->category_id)->get();
            return response()->json($subcategories);
        }
        
        


}
