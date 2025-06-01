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

    public static function credit($obj = []) {

        $amount = $obj['amount'] ?? 0;
        $user_id = $obj['user_id'] ?? 0;
        $type = $obj['type'] ?? 'credit';
        $source = $obj['source'] ?? 'system';
        $description = $obj['description'] ?? '';
        $wallet_id = $obj['wallet_id'] ?? 0;
        $sourceUserId = $obj['sourceUserId'] ?? Auth::id();

        try {
            $this->increment('amount', $amount);
            $this->transactions()->create([
                'user_id' => $user_id,
                'amount' => $amount,
                'type' => 'credit',
                'source' => $source,
                'source_user_id' => $sourceUserId,
                'description' => $description,
            ]);
            return true;
        } catch(\Exception $e) {
           return false;
        }

       
    }

    public static function debit($amount, $source, $description, $sourceUserId = null) {
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
