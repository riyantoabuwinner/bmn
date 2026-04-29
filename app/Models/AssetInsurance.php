<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetInsurance extends Model
{
    protected $fillable = [
        'asset_id',
        'policy_number',
        'insurance_company',
        'start_date',
        'end_date',
        'coverage_amount',
        'premium_amount',
        'status',
        'document',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'coverage_amount' => 'decimal:2',
        'premium_amount' => 'decimal:2'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'created_by');
    }
}
