<?php

// app/Models/PaidTicketClaim.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaidTicketClaim extends Model
{
    protected $fillable = [
        'user_id','npm','amount','npm_proof_path','payment_proof_path',
        'status','reject_reason','approved_at','ticket_code','final_ticket_path','qrcode_path'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
