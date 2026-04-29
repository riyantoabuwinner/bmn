<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetEvaluation extends Model
{
    protected $fillable = [
        'year', 'period_type', 'semester', 'status', 'created_by', 'finalized_at'
    ];

    protected $casts = [
        'year' => 'integer',
        'finalized_at' => 'date',
    ];

    public function details()
    {
        return $this->hasMany(AssetEvaluationDetail::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function getPeriodNameAttribute()
    {
        if ($this->period_type == 'semester') {
            return "Semester {$this->semester} Tahun {$this->year}";
        }
        return "Tahunan {$this->year}";
    }
}
