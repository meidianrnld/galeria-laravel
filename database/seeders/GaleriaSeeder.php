<?php

namespace Database\Seeders;

use App\Models\Aplikasi;
use App\Models\AplikasiDokumen;
use App\Models\AplikasiFitur;
use App\Models\AplikasiKategori;
use App\Models\AplikasiReplikasi;
use App\Models\AplikasiTim;
use App\Models\AplikasiVersi;
use App\Models\Satker;
use App\Models\Teknologi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GaleriaSeeder extends Seeder
{
    public function run(): void
    {
        $satkers = collect([
            ['kode' => '1700', 'nama' => 'BPS Provinsi Bengkulu', 'jenis' => 'provinsi'],
            ['kode' => '1701', 'nama' => 'BPS Kabupaten Bengkulu Selatan', 'jenis' => 'kabupaten_kota'],
            ['kode' => '1702', 'nama' => 'BPS Kabupaten Rejang Lebong', 'jenis' => 'kabupaten_kota'],
            ['kode' => '1703', 'nama' => 'BPS Kabupaten Bengkulu Utara', 'jenis' => 'kabupaten_kota'],
            ['kode' => '1771', 'nama' => 'BPS Kota Bengkulu', 'jenis' => 'kabupaten_kota'],
        ])->mapWithKeys(fn ($data) => [$data['kode'] => Satker::firstOrCreate(['kode' => $data['kode']], $data)]);

        $kategoris = collect([
            ['nama' => 'Tata Kelola Organisasi', 'deskripsi' => 'Aplikasi pendukung administrasi, pengendalian, dan manajemen internal.'],
            ['nama' => 'Kegiatan Statistik', 'deskripsi' => 'Aplikasi pendukung produksi, pengumpulan, dan pengolahan data statistik.'],
            ['nama' => 'Pelayanan Publik', 'deskripsi' => 'Aplikasi untuk layanan pengguna data dan kanal informasi publik.'],
            ['nama' => 'Monitoring & Evaluasi', 'deskripsi' => 'Aplikasi dashboard, pemantauan, pelaporan, dan evaluasi kegiatan.'],
        ])->mapWithKeys(function ($data) {
            $data['slug'] = Str::slug($data['nama']);
            return [$data['nama'] => AplikasiKategori::firstOrCreate(['slug' => $data['slug']], $data)];
        });

        $teknologis = collect([
            ['nama' => 'Laravel', 'tipe' => 'Framework', 'lisensi' => 'MIT'],
            ['nama' => 'React', 'tipe' => 'Frontend', 'lisensi' => 'MIT'],
            ['nama' => 'AdminLTE', 'tipe' => 'UI Component', 'lisensi' => 'MIT'],
            ['nama' => 'MariaDB', 'tipe' => 'Database', 'lisensi' => 'GPL'],
            ['nama' => 'MySQL', 'tipe' => 'Database', 'lisensi' => 'GPL/Commercial'],
            ['nama' => 'PostgreSQL', 'tipe' => 'Database', 'lisensi' => 'PostgreSQL'],
            ['nama' => 'Bootstrap', 'tipe' => 'UI Component', 'lisensi' => 'MIT'],
        ])->mapWithKeys(fn ($data) => [$data['nama'] => Teknologi::firstOrCreate(['nama' => $data['nama'], 'tipe' => $data['tipe']], $data)]);

        User::firstOrCreate(
            ['email' => 'admin.provinsi@bps.go.id'],
            [
                'satker_id' => $satkers['1700']->id,
                'name' => 'Admin Provinsi',
                'username' => 'adminprov',
                'role' => 'admin_provinsi',
                'jabatan' => 'Tim SIM',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin.satker@bps.go.id'],
            [
                'satker_id' => $satkers['1771']->id,
                'name' => 'Admin Satker Kota Bengkulu',
                'username' => 'adminkota',
                'role' => 'admin_satker',
                'jabatan' => 'Tim SIM Satker',
                'password' => Hash::make('password'),
            ]
        );
        User::firstOrCreate(
            ['email' => 'viewer@bps.go.id'],
            [
                'satker_id' => $satkers['1700']->id,
                'name' => 'Executive Viewer',
                'username' => 'viewer',
                'role' => 'executive_viewer',
                'jabatan' => 'Pimpinan',
                'password' => Hash::make('password'),
            ]
        );

        $galeria = Aplikasi::firstOrCreate(
            ['slug' => 'galeria'],
            [
                'satker_id' => $satkers['1700']->id,
                'aplikasi_kategori_id' => $kategoris['Tata Kelola Organisasi']->id,
                'nama' => 'GALERIA',
                'singkatan' => 'GALERIA',
                'deskripsi' => 'Galeri Sistem Informasi dan Aplikasi untuk inventarisasi, dokumentasi, pencarian, verifikasi, dan replikasi aplikasi BPS se-Provinsi Bengkulu.',
                'platform' => 'Web',
                'status_implementasi' => 'pengembangan',
                'status_verifikasi' => 'terverifikasi',
                'tahun_pengembangan' => 2026,
                'dapat_direplikasi' => true,
                'kontak_pengelola' => 'Tim SIM BPS Provinsi Bengkulu',
                'verified_at' => now(),
            ]
        );
        $galeria->teknologis()->syncWithoutDetaching([
            $teknologis['Laravel']->id,
            $teknologis['React']->id,
            $teknologis['AdminLTE']->id,
            $teknologis['MariaDB']->id,
        ]);

        AplikasiFitur::firstOrCreate(['aplikasi_id' => $galeria->id, 'nama' => 'Katalog Aplikasi'], [
            'deskripsi' => 'Menampilkan daftar aplikasi yang dapat dicari dan difilter berdasarkan kategori, satker, status, dan teknologi.',
            'kategori' => 'Katalog',
        ]);
        AplikasiFitur::firstOrCreate(['aplikasi_id' => $galeria->id, 'nama' => 'Verifikasi Data Aplikasi'], [
            'deskripsi' => 'Admin Provinsi dapat memeriksa dan memverifikasi data aplikasi yang diajukan Admin Satker.',
            'kategori' => 'Administrasi',
        ]);
        AplikasiTim::firstOrCreate(['aplikasi_id' => $galeria->id, 'nama' => 'Tim SIM'], [
            'peran' => 'Pengembang dan pengelola sistem',
            'kontak' => 'BPS Provinsi Bengkulu',
        ]);
        AplikasiDokumen::firstOrCreate(['aplikasi_id' => $galeria->id, 'judul' => 'SRS GALERIA'], [
            'tipe' => 'srs',
            'url' => 'https://example.test/dokumen/srs-galeria.pdf',
        ]);
        AplikasiVersi::firstOrCreate(['aplikasi_id' => $galeria->id, 'versi' => '0.1.0'], [
            'tanggal_rilis' => '2026-08-20',
            'perubahan' => 'Fondasi katalog, dashboard, dan manajemen aplikasi dibuat.',
        ]);
        AplikasiReplikasi::firstOrCreate(['aplikasi_id' => $galeria->id, 'satker_id' => $satkers['1771']->id], [
            'status' => 'direncanakan',
            'catatan' => 'Contoh data peta replikasi awal.',
        ]);

        $simonik = Aplikasi::firstOrCreate(
            ['slug' => 'simonik'],
            [
                'satker_id' => $satkers['1771']->id,
                'aplikasi_kategori_id' => $kategoris['Monitoring & Evaluasi']->id,
                'nama' => 'SIMONIK',
                'singkatan' => 'SIMONIK',
                'deskripsi' => 'Contoh aplikasi monitoring kegiatan internal untuk memantau progres, kendala, dan tindak lanjut pelaksanaan kegiatan.',
                'platform' => 'Web',
                'status_implementasi' => 'produksi',
                'status_verifikasi' => 'diajukan',
                'tahun_pengembangan' => 2025,
                'dapat_direplikasi' => true,
                'kontak_pengelola' => 'Admin Satker Kota Bengkulu',
            ]
        );
        $simonik->teknologis()->syncWithoutDetaching([$teknologis['Laravel']->id, $teknologis['MySQL']->id, $teknologis['Bootstrap']->id]);
    }
}
