<?php

namespace App\Http\Controllers;

use App\Models\Perdes;
use App\Models\PerdesVote;
use Illuminate\Http\Request;

class PartisipasiController extends Controller
{
    private function guardWarga(): void
    {
        $user = auth()->user();
        if (! $user || $user->role !== 'warga') {
            abort(403, 'Halaman ini hanya untuk warga desa yang terdaftar.');
        }
        if (! $user->penduduk) {
            abort(403, 'Akun Anda belum terhubung dengan data kependudukan.');
        }
    }

    public function index()
    {
        $this->guardWarga();

        $draftPerdes = Perdes::where('status', 'draft')
            ->withCount('votes')
            ->latest()
            ->get();

        return view('partisipasi.index', compact('draftPerdes'));
    }

    public function show(Perdes $perdes)
    {
        $this->guardWarga();

        abort_if($perdes->status !== 'draft', 404, 'Perdes ini tidak terbuka untuk partisipasi.');

        $penduduk  = auth()->user()->penduduk;
        $summary   = $perdes->voteSummary();
        $votes     = $perdes->votes()->latest()->take(20)->get();

        // Cek via DB — lebih reliable dari session
        $sudahVote = PerdesVote::where('perdes_id', $perdes->id)
            ->where('nik', $penduduk->nik)
            ->value('suara');

        return view('partisipasi.show', compact('perdes', 'summary', 'votes', 'sudahVote', 'penduduk'));
    }

    public function vote(Request $request, Perdes $perdes)
    {
        $this->guardWarga();

        abort_if($perdes->status !== 'draft', 403);

        $data = $request->validate([
            'suara'  => 'required|in:setuju,menolak,perbaikan',
            'alasan' => 'nullable|string|max:1000',
        ]);

        $penduduk = auth()->user()->penduduk;

        $exists = PerdesVote::where('perdes_id', $perdes->id)
            ->where('nik', $penduduk->nik)
            ->exists();

        if ($exists) {
            return back()->withErrors(['suara' => 'Anda sudah memberikan suara untuk rancangan ini.']);
        }

        PerdesVote::create([
            'perdes_id'  => $perdes->id,
            'nama'       => $penduduk->nama,
            'nik'        => $penduduk->nik,
            'suara'      => $data['suara'],
            'alasan'     => $data['alasan'] ?? null,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('partisipasi.show', $perdes);
    }
}
