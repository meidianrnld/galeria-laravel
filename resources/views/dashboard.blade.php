@extends('layouts.app', ['title' => 'Dashboard GALERIA'])

@section('content')
    <section class="page-head">
        <div>
            <h1>Dashboard GALERIA</h1>
            <p class="muted">Inventarisasi, dokumentasi, dan replikasi aplikasi BPS se-Provinsi Bengkulu.</p>
        </div>
        <div class="actions">
            <a class="button" href="{{ route('katalog.index') }}">Buka Katalog</a>
            @auth
                <a class="button secondary" href="{{ route('admin.aplikasi.create') }}">Tambah Aplikasi</a>
            @else
                <a class="button secondary" href="{{ route('login') }}">Login Admin</a>
            @endauth
        </div>
    </section>

    <section class="grid stats">
        <div class="card"><div class="stat-value">{{ $totalAplikasi }}</div><div class="muted">Total aplikasi</div></div>
        <div class="card"><div class="stat-value">{{ $terverifikasi }}</div><div class="muted">Terverifikasi</div></div>
        <div class="card"><div class="stat-value">{{ $dapatDireplikasi }}</div><div class="muted">Siap direplikasi</div></div>
        <div class="card"><div class="stat-value">{{ $totalSatker }}</div><div class="muted">Satuan kerja</div></div>
    </section>

    <section class="grid two">
        <div class="panel">
            <h2>Aplikasi Terbaru</h2>
            <ul class="list">
                @forelse ($terbaru as $aplikasi)
                    <li>
                        <strong><a href="{{ route('katalog.show', $aplikasi) }}">{{ $aplikasi->nama }}</a></strong>
                        <div class="muted">{{ $aplikasi->satker->nama }} · {{ $aplikasi->kategori?->nama ?? 'Tanpa kategori' }}</div>
                    </li>
                @empty
                    <li class="muted">Belum ada aplikasi.</li>
                @endforelse
            </ul>
        </div>
        <div class="panel">
            <h2>Sebaran Kategori</h2>
            <ul class="list">
                @foreach ($perKategori as $kategori)
                    <li><strong>{{ $kategori->nama }}</strong><span class="muted"> · {{ $kategori->aplikasis_count }} aplikasi</span></li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
