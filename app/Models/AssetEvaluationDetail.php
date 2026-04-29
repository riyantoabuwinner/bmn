<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetEvaluationDetail extends Model
{
    protected $fillable = [
        'asset_evaluation_id', 'asset_id', 'asset_type',
        'condition_status', 'action_needed', 'notes'
    ];

    public function evaluation()
    {
        return $this->belongsTo(AssetEvaluation::class);
    }

    public function asset()
    {
        return $this->belongsTo(\App\Models\Asset::class);
    }
}
