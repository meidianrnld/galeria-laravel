@extends('layouts.app', ['title' => $aplikasi->nama])

@section('content')
    <section class="page-head">
        <div>
            <h1>{{ $aplikasi->nama }}</h1>
            <p class="muted">{{ $aplikasi->satker->nama }} · {{ $aplikasi->kategori?->nama ?? 'Tanpa kategori' }}</p>
        </div>
        <div class="actions">
            <a class="button secondary" href="{{ route('katalog.index') }}">Kembali</a>
            @auth
                <a class="button" href="{{ route('admin.aplikasi.edit', $aplikasi) }}">Edit</a>
            @endauth
        </div>
    </section>

    <section class="grid two">
        <article class="panel">
            <h2>Profil Aplikasi</h2>
            <p>{{ $aplikasi->deskripsi }}</p>
            <div class="badge-row">
                <span class="badge">{{ ucfirst($aplikasi->status_implementasi) }}</span>
                <span class="badge {{ $aplikasi->status_verifikasi === 'terverifikasi' ? 'ok' : 'warn' }}">{{ ucfirst($aplikasi->status_verifikasi) }}</span>
                @if ($aplikasi->dapat_direplikasi)
                    <span class="badge ok">Dapat direplikasi</span>
                @endif
                @if ($aplikasi->tahun_pengembangan)
                    <span class="badge">{{ $aplikasi->tahun_pengembangan }}</span>
                @endif
            </div>
        </article>
        <aside class="panel">
            <h2>Tautan & Kontak</h2>
            <p><strong>Platform:</strong> {{ $aplikasi->platform ?? '-' }}</p>
            <p><strong>Kontak:</strong> {{ $aplikasi->kontak_pengelola ?? '-' }}</p>
            <p><strong>Demo:</strong> @if ($aplikasi->url_demo)<a href="{{ $aplikasi->url_demo }}" target="_blank">{{ $aplikasi->url_demo }}</a>@else - @endif</p>
            <p><strong>Produksi:</strong> @if ($aplikasi->url_produksi)<a href="{{ $aplikasi->url_produksi }}" target="_blank">{{ $aplikasi->url_produksi }}</a>@else - @endif</p>
        </aside>
    </section>

    <section class="grid two" style="margin-top:16px">
        <div class="panel">
            <h2>Technology Stack</h2>
            <div class="badge-row">
                @forelse ($aplikasi->teknologis as $teknologi)
                    <span class="badge">{{ $teknologi->tipe }}: {{ $teknologi->nama }}</span>
                @empty
                    <span class="muted">Belum ada teknologi.</span>
                @endforelse
            </div>
        </div>
        <div class="panel">
            <h2>Tim Pengembang</h2>
            <ul class="list">
                @forelse ($aplikasi->tims as $tim)
                    <li><strong>{{ $tim->nama }}</strong><div class="muted">{{ $tim->peran }} {{ $tim->kontak ? '· '.$tim->kontak : '' }}</div></li>
                @empty
                    <li class="muted">Belum ada tim pengembang.</li>
                @endforelse
            </ul>
        </div>
    </section>

    <section class="grid two" style="margin-top:16px">
        <div class="panel">
            <h2>Fitur</h2>
            <ul class="list">
                @forelse ($aplikasi->fiturs as $fitur)
                    <li><strong>{{ $fitur->nama }}</strong><div class="muted">{{ $fitur->deskripsi }}</div></li>
                @empty
                    <li class="muted">Belum ada fitur.</li>
                @endforelse
            </ul>
        </div>
        <div class="panel">
            <h2>Dokumentasi</h2>
            <ul class="list">
                @forelse ($aplikasi->dokumens as $dokumen)
                    <li><strong>{{ $dokumen->judul }}</strong><div><a href="{{ route('katalog.dokumen.download', [$aplikasi, $dokumen]) }}">{{ ucfirst($dokumen->tipe) }}</a> <span class="muted">· {{ $dokumen->version ?: 'Tanpa versi' }} · {{ $dokumen->mime_type }}</span></div></li>
                @empty
                    <li class="muted">Belum ada dokumen.</li>
                @endforelse
            </ul>
        </div>
    </section>

    <section class="grid two" style="margin-top:16px">
        <div class="panel">
            <h2>Riwayat Pengembangan</h2>
            <ul class="list">
                @forelse ($aplikasi->versis as $versi)
                    <li><strong>v{{ $versi->versi }}</strong><div class="muted">{{ $versi->tanggal_rilis?->format('d M Y') }} · {{ $versi->perubahan }}</div></li>
                @empty
                    <li class="muted">Belum ada changelog.</li>
                @endforelse
            </ul>
        </div>
        <div class="panel">
            <h2>Replikasi</h2>
            <ul class="list">
                @forelse ($aplikasi->replikasis as $replikasi)
                    <li><strong>{{ $replikasi->satker->nama }}</strong><div class="muted">{{ ucfirst($replikasi->status) }} {{ $replikasi->tanggal_replikasi ? '· '.$replikasi->tanggal_replikasi->format('d M Y') : '' }}</div></li>
                @empty
                    <li class="muted">Belum ada data replikasi.</li>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
