<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplikasiFitur extends Model
{
    use HasFactory;

    protected $fillable = ['aplikasi_id', 'nama', 'deskripsi', 'kategori'];

    public function aplikasi(): BelongsTo
    {
        return $this->belongsTo(Aplikasi::class);
    }
}
