<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetPsp extends Model
{
    use HasFactory;

    protected $table = 'asset_psp';

    protected $fillable = [
        'asset_id',
        'sk_number',
        'sk_date',
        'status', // active, inactive
        'document',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'sk_date' => 'date',
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
