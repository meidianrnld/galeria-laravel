@extends('layouts.app', ['title' => 'Manajemen Aplikasi'])

@section('content')
    <section class="page-head">
        <div>
            <h1>Manajemen Aplikasi</h1>
            <p class="muted">Kelola profil, metadata, status implementasi, dan verifikasi aplikasi.</p>
        </div>
        <div class="actions">
            <a class="button" href="{{ route('admin.aplikasi.create') }}">Tambah Aplikasi</a>
        </div>
    </section>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Satker</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Teknologi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($aplikasis as $aplikasi)
                <tr>
                    <td><strong>{{ $aplikasi->nama }}</strong><div class="muted">{{ $aplikasi->singkatan }}</div></td>
                    <td>{{ $aplikasi->satker->nama }}</td>
                    <td>{{ $aplikasi->kategori?->nama ?? '-' }}</td>
                    <td>
                        <span class="badge">{{ ucfirst($aplikasi->status_implementasi) }}</span>
                        <span class="badge {{ $aplikasi->status_verifikasi === 'terverifikasi' ? 'ok' : 'warn' }}">{{ ucfirst($aplikasi->status_verifikasi) }}</span>
                    </td>
                    <td>
                        @foreach ($aplikasi->teknologis->take(3) as $teknologi)
                            <span class="badge">{{ $teknologi->nama }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="actions">
                            <a class="button secondary" href="{{ route('katalog.show', $aplikasi) }}">Detail</a>
                            <a class="button secondary" href="{{ route('admin.aplikasi.edit', $aplikasi) }}">Edit</a>
                            <a class="button secondary" href="{{ route('admin.aplikasi.detail.edit', $aplikasi) }}">Kelola Detail</a>
                            @if ($aplikasi->status_verifikasi !== 'terverifikasi')
                                <form method="post" action="{{ route('admin.aplikasi.verify', $aplikasi) }}">
                                    @csrf
                                    <button class="button" type="submit">Verifikasi</button>
                                </form>
                            @endif
                            <form method="post" action="{{ route('admin.aplikasi.destroy', $aplikasi) }}" onsubmit="return confirm('Hapus aplikasi ini?')">
                                @csrf
                                @method('delete')
                                <button class="button danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada aplikasi.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">{{ $aplikasis->links() }}</div>
@endsection
