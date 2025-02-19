<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'payment_method', 'payment_details'];

    public function transactions() {
        return $this->hasMany(WalletTransaction::class);
    }

    public function credit($amount, $source, $description, $sourceUserId = null) {
        $this->increment('amount', $amount);
        $this->transactions()->create([
            'user_id' => $this->user_id,
            'amount' => $amount,
            'type' => 'credit',
            'source' => $source,
            'source_user_id' => $sourceUserId,
            'description' => $description,
        ]);
    }

    public function debit($amount, $source, $description, $sourceUserId = null) {
        if ($this->amount >= $amount) {
            $this->decrement('amount', $amount);
            $this->transactions()->create([
                'user_id' => $this->user_id,
                'amount' => $amount,
                'type' => 'debit',
                'source' => $source,
                'source_user_id' => $sourceUserId,
                'description' => $description,
            ]);
        } else {
            throw new \Exception("Insufficient balance for user ID: {$this->user_id}");
        }
    }
}
