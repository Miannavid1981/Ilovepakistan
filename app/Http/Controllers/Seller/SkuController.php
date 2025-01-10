<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildSku;
use Illuminate\Support\Facades\DB;


class SkuController extends Controller
{
           public function getSku(Request $request)
    {
       $fetchsku = DB::table('child_skus')
    ->join('products', 'child_skus.product_id', '=', 'products.id')
    ->select(
        'child_skus.*', 
        'products.name as product_name', 
        'products.description as product_description',
        'products.unit_price' // Selecting unit_price from the products table
    )
    ->get();

return view('seller.product.Sku.index')->with('fetchsku', $fetchsku);

    }
}
