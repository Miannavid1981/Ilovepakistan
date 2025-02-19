<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model {
    use HasFactory;

    protected $fillable = ['wallet_id', 'user_id', 'order_id', 'amount', 'type', 'source', 'source_user_id', 'description'];

    public function wallet() {
        return $this->belongsTo(Wallet::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sourceUser() {
        return $this->belongsTo(User::class, 'source_user_id');
    }
}
