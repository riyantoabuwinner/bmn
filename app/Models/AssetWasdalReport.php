<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetWasdalReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'period_year',
        'report_type',
        'condition_status',
        'usage_status',
        'document',
        'description',
        'created_by',
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
