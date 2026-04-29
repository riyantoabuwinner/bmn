<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkbmnProcurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'name',
        'type',
        'quantity',
        'unit',
        'estimated_unit_price',
        'total_price',
        'priority',
        'justification',
        'status',
        'created_by'
    ];

    protected $casts = [
        'year' => 'integer',
        'quantity' => 'integer',
        'estimated_unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class , 'created_by');
    }
}
