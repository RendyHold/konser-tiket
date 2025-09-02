<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Acara extends Model
{
    protected $fillable = ['nama','tanggal','lokasi','kuota'];
    protected $casts = ['tanggal' => 'datetime'];
    public function pendaftarans(): HasMany { return $this->hasMany(Pendaftaran::class); }
}
