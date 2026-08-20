@extends('layouts.app', ['title' => $aplikasi->exists ? 'Edit Aplikasi' : 'Tambah Aplikasi'])

@section('content')
    <section class="page-head">
        <div>
            <h1>{{ $aplikasi->exists ? 'Edit Aplikasi' : 'Tambah Aplikasi' }}</h1>
            <p class="muted">Isi profil utama dan metadata aplikasi.</p>
        </div>
        <div class="actions">
            <a class="button secondary" href="{{ route('admin.aplikasi.index') }}">Kembali</a>
        </div>
    </section>

    <form class="panel" method="post" action="{{ $aplikasi->exists ? route('admin.aplikasi.update', $aplikasi) : route('admin.aplikasi.store') }}">
        @csrf
        @if ($aplikasi->exists)
            @method('put')
        @endif

        <div class="form-grid">
            <div>
                <label for="nama">Nama aplikasi</label>
                <input id="nama" name="nama" value="{{ old('nama', $aplikasi->nama) }}" required>
            </div>
            <div>
                <label for="singkatan">Singkatan</label>
                <input id="singkatan" name="singkatan" value="{{ old('singkatan', $aplikasi->singkatan) }}">
            </div>
            <div>
                <label for="satker_id">Satker pengembang</label>
                <select id="satker_id" name="satker_id" required>
                    @foreach ($satkers as $satker)
                        <option value="{{ $satker->id }}" @selected(old('satker_id', $aplikasi->satker_id) == $satker->id)>{{ $satker->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="aplikasi_kategori_id">Kategori</label>
                <select id="aplikasi_kategori_id" name="aplikasi_kategori_id">
                    <option value="">Tanpa kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(old('aplikasi_kategori_id', $aplikasi->aplikasi_kategori_id) == $kategori->id)>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="full">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi', $aplikasi->deskripsi) }}</textarea>
            </div>
            <div>
                <label for="platform">Platform</label>
                <input id="platform" name="platform" value="{{ old('platform', $aplikasi->platform) }}" placeholder="Web, mobile, desktop">
            </div>
            <div>
                <label for="tahun_pengembangan">Tahun pengembangan</label>
                <input id="tahun_pengembangan" name="tahun_pengembangan" type="number" min="2000" max="2100" value="{{ old('tahun_pengembangan', $aplikasi->tahun_pengembangan) }}">
            </div>
            <div>
                <label for="status_implementasi">Status implementasi</label>
                <select id="status_implementasi" name="status_implementasi" required>
                    @foreach (['pengembangan', 'pilot', 'produksi', 'nonaktif'] as $status)
                        <option value="{{ $status }}" @selected(old('status_implementasi', $aplikasi->status_implementasi ?? 'pengembangan') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status_verifikasi">Status verifikasi</label>
                <select id="status_verifikasi" name="status_verifikasi" required>
                    @foreach (['draft', 'diajukan', 'revisi', 'terverifikasi'] as $status)
                        <option value="{{ $status }}" @selected(old('status_verifikasi', $aplikasi->status_verifikasi ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="url_demo">URL demo</label>
                <input id="url_demo" name="url_demo" type="url" value="{{ old('url_demo', $aplikasi->url_demo) }}">
            </div>
            <div>
                <label for="url_produksi">URL produksi</label>
                <input id="url_produksi" name="url_produksi" type="url" value="{{ old('url_produksi', $aplikasi->url_produksi) }}">
            </div>
            <div>
                <label for="kontak_pengelola">Kontak pengelola</label>
                <input id="kontak_pengelola" name="kontak_pengelola" value="{{ old('kontak_pengelola', $aplikasi->kontak_pengelola) }}">
            </div>
            <div>
                <label>&nbsp;</label>
                <label><input type="checkbox" name="dapat_direplikasi" value="1" style="width:auto" @checked(old('dapat_direplikasi', $aplikasi->dapat_direplikasi))> Dapat direplikasi</label>
            </div>
            <div class="full">
                <label>Teknologi</label>
                <div class="badge-row">
                    @php($selected = collect(old('teknologi_ids', $aplikasi->teknologis?->pluck('id')->all() ?? []))->map(fn ($id) => (int) $id)->all())
                    @foreach ($teknologis as $teknologi)
                        <label class="badge">
                            <input type="checkbox" name="teknologi_ids[]" value="{{ $teknologi->id }}" style="width:auto" @checked(in_array($teknologi->id, $selected, true))>
                            {{ $teknologi->tipe }}: {{ $teknologi->nama }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="actions" style="margin-top:18px">
            <button class="button" type="submit">Simpan</button>
            <a class="button secondary" href="{{ route('admin.aplikasi.index') }}">Batal</a>
        </div>
    </form>
@endsection
