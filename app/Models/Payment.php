<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'borrowing_id', 'amount', 'payment_method',
        'proof_of_payment', 'paid_at', 'verified_by'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class , 'verified_by');
    }
}
