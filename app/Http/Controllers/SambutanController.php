<?php

namespace App\Http\Controllers;

use App\Models\Sambutan;
use App\Models\Setting;
use App\Services\AiDraftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SambutanController extends Controller
{
    public function index()
    {
        $sambutans = Sambutan::with('user')->latest()->paginate(12);
        return view('admin.sambutan.index', compact('sambutans'));
    }

    public function create()
    {
        $aiReady = filled(Setting::get('ai_provider'))
            && filled(Setting::get('ai_model'))
            && filled(Setting::get('ai_api_key'));

        return view('admin.sambutan.create', compact('aiReady'));
    }

    public function generate(Request $request, AiDraftService $ai)
    {
        $request->validate([
            'judul'   => 'required|string|max:200',
            'acara'   => 'required|string|max:100',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $provider     = Setting::get('ai_provider');
        $model        = Setting::get('ai_model');
        $encryptedKey = Setting::get('ai_api_key');

        if (! filled($provider) || ! filled($model) || ! filled($encryptedKey)) {
            return response()->json([
                'message' => 'Konfigurasi AI belum lengkap. Atur penyedia, model, dan API key di halaman Pengaturan.',
            ], 422);
        }

        try {
            $apiKey = decrypt($encryptedKey);
        } catch (Throwable) {
            return response()->json([
                'message' => 'API key tersimpan tidak valid. Simpan ulang API key di halaman Pengaturan.',
            ], 422);
        }

        $desaNama = Setting::get('desa_nama', 'Tontonunu');
        $kecamatan = Setting::get('desa_kecamatan', '');
        $kabupaten = Setting::get('desa_kabupaten', '');

        $prompt  = "Buatkan naskah sambutan resmi Kepala Desa untuk acara: \"{$request->acara}\".";
        $prompt .= "\nJudul sambutan: \"{$request->judul}\".";
        $prompt .= "\nDesa: {$desaNama}" . ($kecamatan ? ", Kecamatan {$kecamatan}" : '') . ($kabupaten ? ", {$kabupaten}" : '') . '.';
        $prompt .= "\nSambutan harus formal, hangat, dan relevan dengan tema acara.";
        if ($request->filled('catatan')) {
            $prompt .= "\n\nCatatan tambahan dari pengguna: {$request->catatan}";
        }

        try {
            $draft = $ai->generateSambutan($provider, $model, $apiKey, $prompt);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Gagal membuat sambutan: ' . $e->getMessage(),
            ], 502);
        }

        if (blank($draft)) {
            return response()->json(['message' => 'Layanan AI tidak mengembalikan hasil. Coba lagi.'], 502);
        }

        if (! preg_match('/<(h[23]|p|strong)\b/i', $draft)) {
            return response()->json(['message' => 'AI tidak menghasilkan format HTML yang valid. Coba lagi.'], 502);
        }

        $sambutan = Sambutan::create([
            'user_id' => Auth::id(),
            'judul'   => $request->judul,
            'acara'   => $request->acara,
            'catatan' => $request->catatan,
            'isi'     => $draft,
        ]);

        return response()->json(['redirect' => route('admin.sambutan.show', $sambutan)]);
    }

    public function show(Sambutan $sambutan)
    {
        return view('admin.sambutan.show', compact('sambutan'));
    }

    public function update(Request $request, Sambutan $sambutan)
    {
        $request->validate(['isi' => 'required|string']);
        $sambutan->update(['isi' => $request->isi]);
        return back()->with('success', 'Sambutan berhasil disimpan.');
    }

    public function destroy(Sambutan $sambutan)
    {
        $sambutan->delete();
        return redirect()->route('admin.sambutan.index')->with('success', 'Sambutan berhasil dihapus.');
    }
}
