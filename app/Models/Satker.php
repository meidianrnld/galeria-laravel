<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Satker extends Model
{
    use HasFactory;

    protected $fillable = ['provinsi_id', 'kode', 'nama', 'jenis'];

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function aplikasis(): HasMany
    {
        return $this->hasMany(Aplikasi::class);
    }
}
