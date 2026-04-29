<?php

namespace App\Models;

use App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class AssetOpname extends Model
{
    protected $fillable = [
        'asset_id', 'opname_date', 'physical_condition', 'system_condition',
        'discrepancy_notes', 'checked_by', 'status', 'documentation'
    ];

    protected $casts = [
        'opname_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class , 'asset_id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class , 'checked_by');
    }
}
