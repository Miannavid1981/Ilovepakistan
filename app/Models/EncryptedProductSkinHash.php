<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncryptedProductSkinHash extends Model
{
    use HasFactory;

    protected $fillable = ['original_value', 'encrypted_value', 'encrypted_hash'];
    protected $table = 'encrypted_product_skin_hashes';

    // You can add more functions if needed (e.g., mutators, accessors)
}
