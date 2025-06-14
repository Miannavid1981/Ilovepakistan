<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryTypesSetting extends Model
{
    protected $fillable = ['personal', 'family_friends', 'others'];
}
