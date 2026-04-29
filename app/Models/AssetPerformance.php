<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetPerformance extends Model
{
    protected $fillable = [
        'asset_id',
        'evaluation_date',
        'sbsk_target',
        'actual_usage',
        'efficiency_ratio',
        'category',
        'status',
        'recommendation',
        'created_by'
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'sbsk_target' => 'decimal:2',
        'actual_usage' => 'decimal:2',
        'efficiency_ratio' => 'decimal:2',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    // Auto-calculate status based on efficiency ratio
    public static function calculateStatus($ratio)
    {
        if ($ratio > 110) {
            return 'Overutilized';
        }
        elseif ($ratio < 90) {
            return 'Underutilized';
        }
        else {
            return 'Optimal';
        }
    }
}
