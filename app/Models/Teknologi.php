<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teknologi extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'tipe', 'lisensi'];

    public function aplikasis(): BelongsToMany
    {
        return $this->belongsToMany(Aplikasi::class, 'aplikasi_teknologi')->withTimestamps();
    }
}
