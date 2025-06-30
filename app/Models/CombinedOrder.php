<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PreventDemoModeChanges;

class CombinedOrder extends Model
{
    use PreventDemoModeChanges;

    public function orders(){
    	return $this->hasMany(Order::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
      public function updateMainStatus()
    {
        $statusWeights = [
            'Pending'    => 1,
            'Confirmed'  => 2,
            'Picked Up'  => 3,
            'On The Way' => 4,
            'Delivered'  => 5,
        ];

        $statuses = $this->orders()->pluck('delivery_status')->toArray();

        if (empty($statuses)) return;

        $totalWeight = 0;
        $count = 0;

        foreach ($statuses as $status) {
            if (isset($statusWeights[$status])) {
                $totalWeight += $statusWeights[$status];
                $count++;
            }
        }

        if ($count === 0) return;

        $averageWeight = floor($totalWeight / $count); // Use floor instead of round
        $reverseMap = array_flip($statusWeights);
        $newStatus = $reverseMap[$averageWeight] ?? 'Pending';
        $newStatus = strtolower(str_replace(" ", "_", $newStatus));
        $this->status = $newStatus;
        $this->save();
    }
}
