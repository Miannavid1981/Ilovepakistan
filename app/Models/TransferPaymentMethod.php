<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferPaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'transfer_payment_methods';

    protected $fillable = [
        'status',
        'type',
        'slug',
        'title',
        'account_title',
        'account_no',
        'iban',
        'image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}