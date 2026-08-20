<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplikasiReplikasi extends Model
{
    use HasFactory;

    protected $fillable = ['aplikasi_id', 'satker_id', 'status', 'tanggal_replikasi', 'catatan'];

    protected function casts(): array
    {
        return ['tanggal_replikasi' => 'date'];
    }

    public function aplikasi(): BelongsTo
    {
        return $this->belongsTo(Aplikasi::class);
    }

    public function satker(): BelongsTo
    {
        return $this->belongsTo(Satker::class);
    }
}
