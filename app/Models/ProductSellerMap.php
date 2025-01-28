<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PreventDemoModeChanges;
use App\Models\Product;

class ProductSellerMap extends Model
{
    protected $fillable = ['product_id', 'seller_id', 'imported', 'source_seller_id', 'sku', 'encrypted_value', 'encrypted_hash', 'original_skin'];
    protected $table = 'product_seller_map';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}