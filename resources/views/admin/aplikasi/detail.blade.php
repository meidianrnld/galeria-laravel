@extends('layouts.app', ['title' => 'Detail Administratif Aplikasi'])

@section('content')
    <section class="page-head">
        <div>
            <h1>Detail Aplikasi</h1>
            <p class="muted">{{ $aplikasi->nama }} · {{ $aplikasi->satker->nama }}</p>
        </div>
        <div class="actions">
            <a class="button secondary" href="{{ route('admin.aplikasi.index') }}">Kembali</a>
            <a class="button secondary" href="{{ route('katalog.show', $aplikasi) }}">Lihat Publik</a>
        </div>
    </section>

    <section class="grid two">
        <div class="panel">
            <h2>Fitur</h2>
            <form method="post" action="{{ route('admin.aplikasi.detail.fitur.store', $aplikasi) }}">
                @csrf
                <div class="form-grid">
                    <div><label>Nama fitur</label><input name="nama" required></div>
                    <div><label>Kategori</label><select name="fitur_kategori_id"><option value="">Tanpa kategori</option>@foreach ($fiturKategoris as $kategori)<option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>@endforeach</select></div>
                    <div class="full"><label>Deskripsi</label><textarea name="deskripsi"></textarea></div>
                </div>
                <button class="button" type="submit" style="margin-top:12px">Tambah Fitur</button>
            </form>
            <ul class="list" style="margin-top:16px">
                @forelse ($aplikasi->fiturs as $fitur)
                    <li>
                        <strong>{{ $fitur->nama }}</strong>
                        <div class="muted">{{ $fitur->kategori?->nama ?? 'Tanpa kategori' }} {{ $fitur->deskripsi ? '· '.$fitur->deskripsi : '' }}</div>
                        <form method="post" action="{{ route('admin.aplikasi.detail.fitur.destroy', [$aplikasi, $fitur]) }}" style="margin-top:8px">
                            @csrf
                            @method('delete')
                            <button class="button danger" type="submit">Hapus</button>
                        </form>
                    </li>
                @empty
                    <li class="muted">Belum ada fitur.</li>
                @endforelse
            </ul>
        </div>

        <div class="panel">
            <h2>Tim Pengembang</h2>
            <form method="post" action="{{ route('admin.aplikasi.detail.tim.store', $aplikasi) }}">
                @csrf
                <div class="form-grid">
                    <div><label>Nama</label><input name="nama" required></div>
                    <div><label>Username</label><input name="username"></div>
                    <div><label>Peran</label><input name="peran" required></div>
                    <div><label>Kontak</label><input name="kontak"></div>
                </div>
                <button class="button" type="submit" style="margin-top:12px">Tambah Tim</button>
            </form>
            <ul class="list" style="margin-top:16px">
                @forelse ($aplikasi->tims as $tim)
                    <li>
                        <strong>{{ $tim->nama }}</strong>
                        <div class="muted">{{ $tim->peran }} {{ $tim->kontak ? '· '.$tim->kontak : '' }}</div>
                        <form method="post" action="{{ route('admin.aplikasi.detail.tim.destroy', [$aplikasi, $tim]) }}" style="margin-top:8px">
                            @csrf
                            @method('delete')
                            <button class="button danger" type="submit">Hapus</button>
                        </form>
                    </li>
                @empty
                    <li class="muted">Belum ada tim pengembang.</li>
                @endforelse
            </ul>
        </div>
    </section>

    <section class="grid two" style="margin-top:16px">
        <div class="panel">
            <h2>Dokumentasi</h2>
            <form method="post" enctype="multipart/form-data" action="{{ route('admin.aplikasi.detail.dokumen.store', $aplikasi) }}">
                @csrf
                <div class="form-grid">
                    <div><label>Judul</label><input name="judul" required></div>
                    <div><label>Tipe</label><input name="tipe" value="user_guide" required></div>
                    <div><label>Versi</label><input name="version"></div>
                    <div><label>Visibilitas</label><select name="visibility"><option value="public">Publik</option><option value="admin">Admin</option></select></div>
                    <div class="full"><label>File dokumen</label><input type="file" name="dokumen" required></div>
                </div>
                <button class="button" type="submit" style="margin-top:12px">Tambah Dokumen</button>
            </form>
            <ul class="list" style="margin-top:16px">
                @forelse ($aplikasi->dokumens as $dokumen)
                    <li>
                        <strong>{{ $dokumen->judul }}</strong>
                        <div class="muted">{{ $dokumen->tipe }} · {{ $dokumen->version ?: 'Tanpa versi' }} · {{ $dokumen->visibility }}</div>
                        <form method="post" action="{{ route('admin.aplikasi.detail.dokumen.destroy', [$aplikasi, $dokumen]) }}" style="margin-top:8px">
                            @csrf
                            @method('delete')
                            <button class="button danger" type="submit">Hapus</button>
                        </form>
                    </li>
                @empty
                    <li class="muted">Belum ada dokumen.</li>
                @endforelse
            </ul>
        </div>

        <div class="panel">
            <h2>Changelog</h2>
            <form method="post" action="{{ route('admin.aplikasi.detail.versi.store', $aplikasi) }}">
                @csrf
                <div class="form-grid">
                    <div><label>Versi</label><input name="versi" required></div>
                    <div><label>Tanggal rilis</label><input type="date" name="tanggal_rilis"></div>
                    <div class="full"><label>Perubahan</label><textarea name="perubahan" required></textarea></div>
                </div>
                <button class="button" type="submit" style="margin-top:12px">Tambah Changelog</button>
            </form>
            <ul class="list" style="margin-top:16px">
                @forelse ($aplikasi->versis as $versi)
                    <li>
                        <strong>v{{ $versi->versi }}</strong>
                        <div class="muted">{{ $versi->tanggal_rilis?->format('d M Y') }} {{ $versi->perubahan ? '· '.$versi->perubahan : '' }}</div>
                        <form method="post" action="{{ route('admin.aplikasi.detail.versi.destroy', [$aplikasi, $versi]) }}" style="margin-top:8px">
                            @csrf
                            @method('delete')
                            <button class="button danger" type="submit">Hapus</button>
                        </form>
                    </li>
                @empty
                    <li class="muted">Belum ada changelog.</li>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
