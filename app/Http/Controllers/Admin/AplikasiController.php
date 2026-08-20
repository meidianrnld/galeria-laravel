<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use App\Models\AplikasiKategori;
use App\Models\Satker;
use App\Models\Teknologi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AplikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aplikasi::with(['satker', 'kategori', 'teknologis'])->latest();

        if ($request->user()->role === 'admin_satker') {
            $query->where('satker_id', $request->user()->satker_id);
        }

        return view('admin.aplikasi.index', [
            'aplikasis' => $query->paginate(15),
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.aplikasi.form', $this->formData(new Aplikasi(), $request));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']).'-'.Str::lower(Str::random(5));

        if ($request->user()->role === 'admin_satker') {
            $data['satker_id'] = $request->user()->satker_id;
            $data['status_verifikasi'] = 'diajukan';
        }

        $aplikasi = Aplikasi::create($data);
        $aplikasi->teknologis()->sync($request->input('teknologi_ids', []));

        return redirect()->route('admin.aplikasi.index')->with('status', 'Aplikasi berhasil ditambahkan.');
    }

    public function edit(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);
        $aplikasi->load('teknologis');

        return view('admin.aplikasi.form', $this->formData($aplikasi, $request));
    }

    public function update(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);

        $data = $this->validated($request);

        if ($request->user()->role === 'admin_satker') {
            $data['satker_id'] = $request->user()->satker_id;
            $data['status_verifikasi'] = 'diajukan';
            $data['verified_at'] = null;
        }

        $aplikasi->update($data);
        $aplikasi->teknologis()->sync($request->input('teknologi_ids', []));

        return redirect()->route('admin.aplikasi.index')->with('status', 'Aplikasi berhasil diperbarui.');
    }

    public function destroy(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);
        $aplikasi->delete();

        return redirect()->route('admin.aplikasi.index')->with('status', 'Aplikasi berhasil dihapus.');
    }

    public function verify(Aplikasi $aplikasi)
    {
        $aplikasi->update([
            'status_verifikasi' => 'terverifikasi',
            'verified_at' => now(),
        ]);

        return back()->with('status', 'Aplikasi berhasil diverifikasi.');
    }

    private function formData(Aplikasi $aplikasi, Request $request): array
    {
        $satkers = Satker::orderBy('nama');

        if ($request->user()->role === 'admin_satker') {
            $satkers->where('id', $request->user()->satker_id);
        }

        return [
            'aplikasi' => $aplikasi,
            'satkers' => $satkers->get(),
            'kategoris' => AplikasiKategori::orderBy('nama')->get(),
            'teknologis' => Teknologi::orderBy('tipe')->orderBy('nama')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'satker_id' => ['required', 'exists:satkers,id'],
            'aplikasi_kategori_id' => ['nullable', 'exists:aplikasi_kategoris,id'],
            'nama' => ['required', 'string', 'max:255'],
            'singkatan' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'url_demo' => ['nullable', 'url', 'max:255'],
            'url_produksi' => ['nullable', 'url', 'max:255'],
            'platform' => ['nullable', 'string', 'max:255'],
            'status_implementasi' => ['required', 'in:pengembangan,pilot,produksi,nonaktif'],
            'status_verifikasi' => ['required', 'in:draft,diajukan,revisi,terverifikasi'],
            'tahun_pengembangan' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'dapat_direplikasi' => ['sometimes', 'boolean'],
            'kontak_pengelola' => ['nullable', 'string', 'max:255'],
            'teknologi_ids' => ['array'],
            'teknologi_ids.*' => ['exists:teknologis,id'],
        ]) + ['dapat_direplikasi' => $request->boolean('dapat_direplikasi')];
    }

    private function authorizeSatkerAccess(Request $request, Aplikasi $aplikasi): void
    {
        if ($request->user()->role === 'admin_satker' && $aplikasi->satker_id !== $request->user()->satker_id) {
            abort(403, 'Admin Satker hanya dapat mengelola aplikasi pada satkernya sendiri.');
        }
    }
}