<?php

namespace App\Models;

use App\Models\Asset;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;

class AssetDistribution extends Model
{
    protected $fillable = [
        'asset_id', 'unit_id', 'recipient_name', 'recipient_position',
        'distribution_date', 'notes'
    ];

    protected $casts = [
        'distribution_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
