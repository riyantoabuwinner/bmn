<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetLocation extends Model
{
    protected $fillable = ['name', 'unit_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class , 'location_id');
    }
}
