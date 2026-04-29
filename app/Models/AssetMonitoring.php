<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMonitoring extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'inspection_date',
        'inspector_name',
        'usage_conformity',
        'is_idle',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'is_idle' => 'boolean',
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
