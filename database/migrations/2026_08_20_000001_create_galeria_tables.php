<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinsis', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama')->unique();
            $table->timestamps();
        });

        Schema::create('satkers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provinsi_id')->constrained('provinsis')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('jenis')->default('kabupaten_kota');
            $table->timestamps();
        });

        Schema::create('aplikasi_kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('teknologis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('tipe', [
                'Bahasa Pemrograman', 'Framework', 'Frontend', 'Database', 'Library',
                'API', 'Web Server', 'DevOps', 'UI Component', 'Lainnya',
            ]);
            $table->string('lisensi')->nullable();
            $table->timestamps();
            $table->unique(['nama', 'tipe']);
        });

        Schema::create('aplikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('satker_id')->constrained('satkers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('aplikasi_kategori_id')->nullable()->constrained('aplikasi_kategoris')->nullOnDelete();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('singkatan')->nullable();
            $table->text('deskripsi');
            $table->string('url_demo')->nullable();
            $table->string('url_produksi')->nullable();
            $table->string('platform')->nullable();
            $table->string('status_implementasi')->default('pengembangan');
            $table->string('status_verifikasi')->default('draft');  
            $table->unsignedSmallInteger('tahun_pengembangan')->nullable();
            $table->boolean('dapat_direplikasi')->default(false);
            $table->string('kontak_pengelola')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('aplikasi_teknologi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->cascadeOnDelete();
            $table->foreignId('teknologi_id')->constrained('teknologis')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['aplikasi_id', 'teknologi_id']);
        });

        Schema::create('aplikasi_tims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->cascadeOnDelete();
            $table->string('nama');
            $table->string('username')->nullable();
            $table->string('peran');
            $table->string('kontak')->nullable();
            $table->timestamps();
        });

        Schema::create('fitur_kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('aplikasi_fiturs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->cascadeOnDelete();
            $table->foreignId('fitur_kategori_id')->nullable()->constrained('fitur_kategoris')->nullOnDelete();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('aplikasi_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->cascadeOnDelete();
            $table->string('judul');
            $table->string('tipe')->default('user_guide');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->string('version')->nullable();
            $table->enum('visibility', ['public', 'admin'])->default('public');
            $table->timestamps();
        });

        Schema::create('aplikasi_medias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->cascadeOnDelete();
            $table->string('judul');
            $table->string('tipe')->default('screenshot');
            $table->string('url');
            $table->timestamps();
        });

        Schema::create('aplikasi_replikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->cascadeOnDelete();
            $table->foreignId('satker_id')->constrained('satkers')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('status')->default('direncanakan');
            $table->date('tanggal_replikasi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('aplikasi_versis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplikasi_id')->constrained('aplikasis')->cascadeOnDelete();
            $table->string('versi');
            $table->date('tanggal_rilis')->nullable();
            $table->text('perubahan');
            $table->timestamps();
        });

        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('aksi');
            $table->string('target')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_logs');
        Schema::dropIfExists('aplikasi_versis');
        Schema::dropIfExists('aplikasi_replikasis');
        Schema::dropIfExists('aplikasi_medias');
        Schema::dropIfExists('aplikasi_dokumens');
        Schema::dropIfExists('aplikasi_fiturs');
        Schema::dropIfExists('aplikasi_tims');
        Schema::dropIfExists('aplikasi_teknologi');
        Schema::dropIfExists('aplikasis');
        Schema::dropIfExists('teknologis');
        Schema::dropIfExists('aplikasi_kategoris');
        Schema::dropIfExists('satkers');
        Schema::dropIfExists('fitur_kategoris');
        Schema::dropIfExists('provinsis');
    }
};
