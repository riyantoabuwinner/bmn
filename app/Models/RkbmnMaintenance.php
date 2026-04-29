<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkbmnMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'asset_id',
        'condition_summary',
        'maintenance_type',
        'estimated_cost',
        'justification',
        'status',
        'created_by'
    ];

    protected $casts = [
        'year' => 'integer',
        'estimated_cost' => 'decimal:2',
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
