<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use App\Models\AplikasiDokumen;
use App\Models\AplikasiFitur;
use App\Models\AplikasiTim;
use App\Models\AplikasiVersi;
use Illuminate\Http\Request;

class AplikasiDetailController extends Controller
{
    public function edit(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);

        $aplikasi->load(['fiturs', 'tims', 'dokumens', 'versis']);

        return view('admin.aplikasi.detail', compact('aplikasi'));
    }

    public function storeFitur(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);

        $aplikasi->fiturs()->create($request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]));

        return back()->with('status', 'Fitur berhasil ditambahkan.');
    }

    public function destroyFitur(Request $request, Aplikasi $aplikasi, AplikasiFitur $fitur)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);
        $this->ensureChildBelongsToAplikasi($aplikasi, $fitur->aplikasi_id);

        $fitur->delete();

        return back()->with('status', 'Fitur berhasil dihapus.');
    }

    public function storeTim(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);

        $aplikasi->tims()->create($request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'peran' => ['required', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:255'],
        ]));

        return back()->with('status', 'Tim pengembang berhasil ditambahkan.');
    }

    public function destroyTim(Request $request, Aplikasi $aplikasi, AplikasiTim $tim)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);
        $this->ensureChildBelongsToAplikasi($aplikasi, $tim->aplikasi_id);

        $tim->delete();

        return back()->with('status', 'Tim pengembang berhasil dihapus.');
    }

    public function storeDokumen(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);

        $aplikasi->dokumens()->create($request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
        ]));

        return back()->with('status', 'Dokumen berhasil ditambahkan.');
    }

    public function destroyDokumen(Request $request, Aplikasi $aplikasi, AplikasiDokumen $dokumen)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);
        $this->ensureChildBelongsToAplikasi($aplikasi, $dokumen->aplikasi_id);

        $dokumen->delete();

        return back()->with('status', 'Dokumen berhasil dihapus.');
    }

    public function storeVersi(Request $request, Aplikasi $aplikasi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);

        $aplikasi->versis()->create($request->validate([
            'versi' => ['required', 'string', 'max:255'],
            'tanggal_rilis' => ['nullable', 'date'],
            'perubahan' => ['required', 'string'],
        ]));

        return back()->with('status', 'Changelog berhasil ditambahkan.');
    }

    public function destroyVersi(Request $request, Aplikasi $aplikasi, AplikasiVersi $versi)
    {
        $this->authorizeSatkerAccess($request, $aplikasi);
        $this->ensureChildBelongsToAplikasi($aplikasi, $versi->aplikasi_id);

        $versi->delete();

        return back()->with('status', 'Changelog berhasil dihapus.');
    }

    private function authorizeSatkerAccess(Request $request, Aplikasi $aplikasi): void
    {
        if ($request->user()->role === 'admin_satker' && $aplikasi->satker_id !== $request->user()->satker_id) {
            abort(403, 'Admin Satker hanya dapat mengelola aplikasi pada satkernya sendiri.');
        }
    }

    private function ensureChildBelongsToAplikasi(Aplikasi $aplikasi, int $aplikasiId): void
    {
        if ($aplikasi->id !== $aplikasiId) {
            abort(404);
        }
    }
}
