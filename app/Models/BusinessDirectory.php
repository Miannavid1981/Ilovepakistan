<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessDirectory extends Model
{
    use HasFactory;

    protected $table = 'business_directory';

    protected $fillable = [
        'user_id', 'name', 'phone', 'whatsapp_no', 'designation', 'company', 'city_id', 'area', 
        'category_id',  'business_type', 'ownership_type', 'google_sheet_url', 'trust_level', 'notes',
        'brand_id'
    ];
    

    /**
     * Get the user who owns this business entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city associated with this business.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the area associated with this business.
     */
    // public function area(): BelongsTo
    // {
    //     return $this->belongsTo(Area::class);
    // }

    /**
     * Get the category associated with this business.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the business type associated with this business.
     */
//     public function businessType(): BelongsTo
//     {
//         return $this->belongsTo(BusinessType::class);
//     }

}