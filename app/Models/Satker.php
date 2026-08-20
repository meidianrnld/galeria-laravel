<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satker extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama', 'jenis'];

    public function aplikasis(): HasMany
    {
        return $this->hasMany(Aplikasi::class);
    }
}
