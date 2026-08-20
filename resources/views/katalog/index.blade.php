@extends('layouts.app', ['title' => 'Katalog Aplikasi'])

@section('content')
    <section class="page-head">
        <div>
            <h1>Katalog Aplikasi</h1>
            <p class="muted">Temukan aplikasi berdasarkan nama, kategori, satker, status, dan potensi replikasi.</p>
        </div>
    </section>

    <form class="filters" method="get" action="{{ route('katalog.index') }}">
        <input name="q" value="{{ request('q') }}" placeholder="Cari aplikasi, singkatan, atau deskripsi">
        <select name="kategori">
            <option value="">Semua kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" @selected(request('kategori') == $kategori->id)>{{ $kategori->nama }}</option>
            @endforeach
        </select>
        <select name="satker">
            <option value="">Semua satker</option>
            @foreach ($satkers as $satker)
                <option value="{{ $satker->id }}" @selected(request('satker') == $satker->id)>{{ $satker->nama }}</option>
            @endforeach
        </select>
        <select name="status">
            <option value="">Semua status</option>
            @foreach (['pengembangan', 'pilot', 'produksi', 'nonaktif'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="button" type="submit">Filter</button>
    </form>

    <section class="grid cards">
        @forelse ($aplikasis as $aplikasi)
            <article class="card">
                <h2><a href="{{ route('katalog.show', $aplikasi) }}">{{ $aplikasi->nama }}</a></h2>
                <p class="muted">{{ $aplikasi->satker->nama }} · {{ $aplikasi->kategori?->nama ?? 'Tanpa kategori' }}</p>
                <p>{{ Str::limit($aplikasi->deskripsi, 150) }}</p>
                <div class="badge-row">
                    <span class="badge">{{ ucfirst($aplikasi->status_implementasi) }}</span>
                    <span class="badge {{ $aplikasi->status_verifikasi === 'terverifikasi' ? 'ok' : 'warn' }}">{{ ucfirst($aplikasi->status_verifikasi) }}</span>
                    @if ($aplikasi->dapat_direplikasi)
                        <span class="badge ok">Dapat direplikasi</span>
                    @endif
                </div>
                <div class="badge-row">
                    @foreach ($aplikasi->teknologis->take(4) as $teknologi)
                        <span class="badge">{{ $teknologi->nama }}</span>
                    @endforeach
                </div>
            </article>
        @empty
            <div class="panel">Belum ada aplikasi yang sesuai filter.</div>
        @endforelse
    </section>

    <div class="pagination">{{ $aplikasis->links() }}</div>
@endsection
