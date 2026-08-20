<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplikasiVersi extends Model
{
    use HasFactory;

    protected $fillable = ['aplikasi_id', 'versi', 'tanggal_rilis', 'perubahan'];

    protected function casts(): array
    {
        return ['tanggal_rilis' => 'date'];
    }

    public function aplikasi(): BelongsTo
    {
        return $this->belongsTo(Aplikasi::class);
    }
}
