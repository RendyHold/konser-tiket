<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $fillable = ['kode_tiket','acara_id','mahasiswa_id','scanned','scanned_at'];
    protected $casts = ['scanned' => 'bool','scanned_at' => 'datetime'];
    public function acara(): BelongsTo { return $this->belongsTo(Acara::class); }
    public function mahasiswa(): BelongsTo { return $this->belongsTo(Mahasiswa::class); }
}
