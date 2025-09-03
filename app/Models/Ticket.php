<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['code','user_id','npm','status','scanned_at','scanned_by','claimed_at','npm_proof_path'];
    protected $casts = ['scanned_at' => 'datetime', 'claimed_at' => 'datetime'];
    protected $perPage = 5;

    public function user()      { return $this->belongsTo(User::class); }
    public function scannedBy() { return $this->belongsTo(User::class, 'scanned_by'); }
}


