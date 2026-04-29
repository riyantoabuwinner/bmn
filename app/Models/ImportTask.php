<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportTask extends Model
{
    protected $fillable = [
        'type', 'filename', 'status', 'total_rows', 'processed_rows', 'error_message', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressAttribute()
    {
        if ($this->total_rows <= 0) return 0;
        return min(100, round(($this->processed_rows / $this->total_rows) * 100));
    }
}
