<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplikasiMedia extends Model
{
    use HasFactory;

    protected $table = 'aplikasi_medias';

    protected $fillable = ['aplikasi_id', 'judul', 'tipe', 'url'];

    public function aplikasi(): BelongsTo
    {
        return $this->belongsTo(Aplikasi::class);
    }
}
