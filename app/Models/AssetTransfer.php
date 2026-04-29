<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Asset;
use App\Models\User;

class AssetTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'transfer_type',
        'recipient_name',
        'sk_number',
        'sk_date',
        'value',
        'document',
        'description',
        'created_by',
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
