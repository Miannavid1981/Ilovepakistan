<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerWalletDepositRequest extends Model
{
    use HasFactory;
    protected $table = 'customer_wallet_deposit_requests';

    protected $fillable = [
        'user_id', 'amount', 'status', 'payment_receipt'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
