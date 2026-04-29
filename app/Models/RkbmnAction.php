<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkbmnAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'asset_id',
        'action_type', // Sewa, Jual, etc
        'justification',
        'estimated_revenue',
        'status',
        'created_by'
    ];

    protected $casts = [
        'year' => 'integer',
        'estimated_revenue' => 'decimal:2',
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
