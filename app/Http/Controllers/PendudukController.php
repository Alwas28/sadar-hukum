<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama', 'like', "%{$q}%")
                   ->orWhere('nik', 'like', "%{$q}%");
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif === '1');
        }

        $penduduk = $query->orderBy('nama')->paginate(15)->withQueryString();

        $stats = [
            'total'   => Penduduk::count(),
            'laki'    => Penduduk::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Penduduk::where('jenis_kelamin', 'P')->count(),
            'aktif'   => Penduduk::where('aktif', true)->count(),
        ];

        return view('admin.penduduk.index', compact('penduduk', 'stats'));
    }

    public function create()
    {
        return view('admin.penduduk.form', ['penduduk' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Penduduk::create($data);
        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.form', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $data = $this->validated($request, $penduduk->id);
        $penduduk->update($data);
        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return back()->with('success', 'Data penduduk berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'nik'               => 'required|digits:16|unique:penduduks,nik' . ($ignoreId ? ",{$ignoreId}" : ''),
            'nama'              => 'required|string|max:100',
            'jenis_kelamin'     => 'required|in:L,P',
            'tempat_lahir'      => 'required|string|max:100',
            'tanggal_lahir'     => 'required|date|before:today',
            'alamat'            => 'required|string|max:500',
            'rt'                => 'nullable|string|max:5',
            'rw'                => 'nullable|string|max:5',
            'agama'             => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan'         => 'nullable|in:' . implode(',', \App\Models\Penduduk::pekerjaanOptions()),
            'pendidikan'        => 'nullable|in:Tidak/Belum Sekolah,SD/Sederajat,SMP/Sederajat,SMA/Sederajat,D1/D2/D3,S1/D4,S2,S3',
            'aktif'             => 'boolean',
        ]);
    }
}
