<?php

namespace App\Models;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'asset_id', 'maintenance_type', 'scheduled_date',
        'condition_before', 'condition_after', 'description',
        'estimated_cost', 'actual_cost', 'status', 'completion_notes'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
