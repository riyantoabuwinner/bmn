<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkbmnDeletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'asset_id',
        'deletion_type',
        'justification',
        'status',
        'created_by'
    ];

    protected $casts = [
        'year' => 'integer',
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
