<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetDeletion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id', 'asset_type',
        'deletion_type', 'sk_number', 'sk_date',
        'document', 'description', 'value', 'created_by',
    ];

    protected $casts = [
        'sk_date' => 'date',
    ];

    public function asset()
    {
        return $this->morphTo('asset')->withTrashed();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
