<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    protected $fillable = ['npm','nama','email','no_hp'];
    public function pendaftarans(): HasMany { return $this->hasMany(Pendaftaran::class); }
}
