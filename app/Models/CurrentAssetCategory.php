<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentAssetCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function currentAssets()
    {
        return $this->hasMany(CurrentAsset::class , 'category_id');
    }
}
