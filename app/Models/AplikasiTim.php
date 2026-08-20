<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplikasiTim extends Model
{
    use HasFactory;

    protected $fillable = ['aplikasi_id', 'nama', 'username', 'peran', 'kontak'];

    public function aplikasi(): BelongsTo
    {
        return $this->belongsTo(Aplikasi::class);
    }
}
