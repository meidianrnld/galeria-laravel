<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplikasiDokumen extends Model
{
    use HasFactory;

    protected $fillable = ['aplikasi_id', 'judul', 'tipe', 'file_name', 'file_size', 'mime_type', 'version', 'visibility'];

    protected function casts(): array
    {
        return ['file_size' => 'integer'];
    }

    public function aplikasi(): BelongsTo
    {
        return $this->belongsTo(Aplikasi::class);
    }
}
