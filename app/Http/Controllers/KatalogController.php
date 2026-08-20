<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\AplikasiKategori;
use App\Models\Satker;
use App\Models\Teknologi;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Aplikasi::query()
            ->with(['satker', 'kategori', 'teknologis'])
            ->latest();

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('nama', 'like', "%{$search}%")
                    ->orWhere('singkatan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('aplikasi_kategori_id', $request->integer('kategori'));
        }

        if ($request->filled('satker')) {
            $query->where('satker_id', $request->integer('satker'));
        }

        if ($request->filled('status')) {
            $query->where('status_implementasi', $request->string('status'));
        }

        if ($request->boolean('replikasi')) {
            $query->where('dapat_direplikasi', true);
        }

        return view('katalog.index', [
            'aplikasis' => $query->paginate(9)->withQueryString(),
            'kategoris' => AplikasiKategori::orderBy('nama')->get(),
            'satkers' => Satker::orderBy('nama')->get(),
            'teknologis' => Teknologi::orderBy('nama')->get(),
        ]);
    }

    public function show(Aplikasi $aplikasi)
    {
        $aplikasi->load([
            'satker',
            'kategori',
            'teknologis',
            'tims',
            'fiturs',
            'dokumens',
            'medias',
            'replikasis.satker',
            'versis',
        ]);

        return view('katalog.show', compact('aplikasi'));
    }

    public function dashboard()
    {
        return view('dashboard', [
            'totalAplikasi' => Aplikasi::count(),
            'terverifikasi' => Aplikasi::where('status_verifikasi', 'terverifikasi')->count(),
            'dapatDireplikasi' => Aplikasi::where('dapat_direplikasi', true)->count(),
            'totalSatker' => Satker::count(),
            'perKategori' => AplikasiKategori::withCount('aplikasis')->orderByDesc('aplikasis_count')->get(),
            'perSatker' => Satker::withCount('aplikasis')->orderByDesc('aplikasis_count')->get(),
            'terbaru' => Aplikasi::with(['satker', 'kategori'])->latest()->limit(5)->get(),
        ]);
    }
}
