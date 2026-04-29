<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{
    protected $table = 'asset_assignments';

    protected $fillable = [
        'asset_id', 'user_id', 'employee_name', 'employee_id_number',
        'position', 'department', 'assigned_date', 'status',
        'return_date', 'condition_on_assign', 'condition_on_return',
        'ba_file', 'notes'
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'return_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class , 'asset_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
