<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aplikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'satker_id',
        'aplikasi_kategori_id',
        'nama',
        'slug',
        'singkatan',
        'deskripsi',
        'url_demo',
        'url_produksi',
        'platform',
        'status_implementasi',
        'status_verifikasi',
        'tahun_pengembangan',
        'dapat_direplikasi',
        'kontak_pengelola',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'dapat_direplikasi' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    public function satker(): BelongsTo
    {
        return $this->belongsTo(Satker::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(AplikasiKategori::class, 'aplikasi_kategori_id');
    }

    public function teknologis(): BelongsToMany
    {
        return $this->belongsToMany(Teknologi::class, 'aplikasi_teknologi')->withTimestamps();
    }

    public function tims(): HasMany
    {
        return $this->hasMany(AplikasiTim::class);
    }

    public function fiturs(): HasMany
    {
        return $this->hasMany(AplikasiFitur::class);
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(AplikasiDokumen::class);
    }

    public function medias(): HasMany
    {
        return $this->hasMany(AplikasiMedia::class);
    }

    public function replikasis(): HasMany
    {
        return $this->hasMany(AplikasiReplikasi::class);
    }

    public function versis(): HasMany
    {
        return $this->hasMany(AplikasiVersi::class);
    }
}
