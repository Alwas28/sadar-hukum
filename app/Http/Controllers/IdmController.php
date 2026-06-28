<?php

namespace App\Http\Controllers;

use App\Models\Idm;
use Illuminate\Http\Request;

class IdmController extends Controller
{
    public function index()
    {
        $records = Idm::orderByDesc('tahun')->get();
        $latest  = $records->first();
        return view('admin.idm.index', compact('records', 'latest'));
    }

    public function create()
    {
        return view('admin.idm.form', ['idm' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Idm::create($data);
        return redirect()->route('admin.idm.index')->with('success', 'Data IDM tahun '.$data['tahun'].' berhasil disimpan.');
    }

    public function edit(Idm $idm)
    {
        return view('admin.idm.form', compact('idm'));
    }

    public function update(Request $request, Idm $idm)
    {
        $data = $this->validated($request, $idm->id);
        $idm->update($data);
        return redirect()->route('admin.idm.index')->with('success', 'Data IDM tahun '.$data['tahun'].' berhasil diperbarui.');
    }

    public function destroy(Idm $idm)
    {
        $idm->delete();
        return back()->with('success', 'Data IDM berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'tahun'      => 'required|integer|min:2000|max:' . (date('Y') + 1)
                          . '|unique:idms,tahun' . ($ignoreId ? ",{$ignoreId}" : ''),
            'status'     => 'required|in:Sangat Tertinggal,Tertinggal,Berkembang,Maju,Mandiri',
            'skor_idm'   => 'required|numeric|min:0|max:1',
            'skor_iks'   => 'required|numeric|min:0|max:1',
            'skor_ike'   => 'required|numeric|min:0|max:1',
            'skor_ikl'   => 'required|numeric|min:0|max:1',
            'keterangan' => 'nullable|string|max:1000',
        ]);
    }
}
