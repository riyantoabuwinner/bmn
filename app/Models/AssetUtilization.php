<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetUtilization extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'utilization_type', // Sewa, Pinjam Pakai, KSP, BGS, BSG
        'partner_name',
        'contract_number',
        'contract_date',
        'start_date',
        'end_date',
        'value',
        'status', // active, finished, extended
        'document',
        'description',
        'created_by'
    ];

    protected $casts = [
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'value' => 'decimal:2',
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
