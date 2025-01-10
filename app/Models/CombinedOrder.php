<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CombinedOrder extends Model
{
    use HasFactory;
    protected $guarded = [];
    // public function orders(){
    // 	return $this->hasMany(Order::class);
    // }
    public function orders(){
    	return $this->hasMany(Order::class, 'combined_order_id', 'id');
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
