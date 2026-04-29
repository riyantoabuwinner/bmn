<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentAssetTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_asset_id',
        'transaction_type',
        'reference_number',
        'transaction_date',
        'quantity',
        'unit_price',
        'total_price',
        'description',
        'status',
        'proof_document',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'approved_at' => 'datetime',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function currentAsset()
    {
        return $this->belongsTo(CurrentAsset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class , 'approved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
