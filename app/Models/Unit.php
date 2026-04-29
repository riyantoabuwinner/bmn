<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'type', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Unit::class , 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Unit::class , 'parent_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function locations()
    {
        return $this->hasMany(AssetLocation::class);
    }
}
