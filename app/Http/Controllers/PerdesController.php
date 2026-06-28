<?php

namespace App\Http\Controllers;

use App\Models\Perdes;
use App\Models\Setting;
use App\Models\StrukturDesa;
use App\Services\AiDraftService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class PerdesController extends Controller
{
    private const JENIS_LABEL = [
        'perdes' => 'Peraturan Desa (Perdes)',
        'perkades' => 'Peraturan Kepala Desa (Perkades)',
        'sk_kades' => 'Keputusan Kepala Desa (SK Kades)',
    ];

    public function index(Request $request)
    {
        $query = Perdes::with('user')->latest();

        if (in_array($request->status, ['draft', 'selesai'], true)) {
            $query->where('status', $request->status);
        }

        $perdes = $query->paginate(10)->withQueryString();

        $counts = [
            'total' => Perdes::count(),
            'selesai' => Perdes::where('status', 'selesai')->count(),
            'draft' => Perdes::where('status', 'draft')->count(),
        ];

        return view('admin.perdes.index', compact('perdes', 'counts'));
    }

    public function create()
    {
        $aiReady = filled(Setting::get('ai_provider'))
            && filled(Setting::get('ai_model'))
            && filled(Setting::get('ai_api_key'));

        return view('admin.perdes.create', compact('aiReady'));
    }

    public function generate(Request $request, AiDraftService $ai)
    {
        $request->validate([
            'jenis' => 'required|in:perdes,perkades,sk_kades',
            'judul' => 'required|string|max:200',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $provider = Setting::get('ai_provider');
        $model = Setting::get('ai_model');
        $encryptedKey = Setting::get('ai_api_key');

        if (! filled($provider) || ! filled($model) || ! filled($encryptedKey)) {
            return response()->json([
                'message' => 'Konfigurasi AI belum lengkap. Atur penyedia, model, dan API key di halaman Pengaturan.',
            ], 422);
        }

        try {
            $apiKey = decrypt($encryptedKey);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'API key tersimpan tidak valid. Simpan ulang API key di halaman Pengaturan.',
            ], 422);
        }

        $template = Setting::get("ai_prompt_template_{$request->jenis}") ?: Perdes::defaultPromptTemplate($request->jenis);

        $prompt  = sprintf('Buatkan draf %s dengan judul: "%s".', self::JENIS_LABEL[$request->jenis], $request->judul);
        $prompt .= "\n\n".$this->wilayahInstruction();
        $prompt .= "\n\nWAJIB: Draf HARUS mencakup bagian Menimbang dan Mengingat secara lengkap dengan format HTML yang ditentukan pada instruksi sistem, dilanjutkan Memutuskan/Menetapkan, Batang Tubuh (pasal-pasal), dan Penutup. Jangan lewatkan satu bagian pun.";
        $prompt .= "\n\n".$this->jenisStructureInstruction($request->jenis);
        if ($request->filled('catatan')) {
            $prompt .= "\n\nCatatan dari pengguna: ".$request->catatan;
        }
        $prompt .= "\n\nPanduan isi:\n".$template;

        try {
            $draft = $ai->generate($provider, $model, $apiKey, $prompt);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Gagal membuat draf: '.$e->getMessage(),
            ], 502);
        }

        if (blank($draft)) {
            return response()->json([
                'message' => 'Layanan AI tidak mengembalikan hasil. Coba lagi.',
            ], 502);
        }

        // Pastikan AI mengembalikan HTML, bukan plain text / markdown
        if (! preg_match('/<(h[23]|p|ol|li)\b/i', $draft)) {
            return response()->json([
                'message' => 'AI tidak menghasilkan format HTML yang valid. Coba lagi — pastikan model yang dipilih mendukung instruksi sistem (gunakan GPT-4o, Claude Sonnet, atau Gemini Pro ke atas).',
            ], 502);
        }

        // Pastikan Menimbang dan Mengingat ada di dalam draf
        if (! str_contains($draft, 'Menimbang') || ! str_contains($draft, 'Mengingat')) {
            return response()->json([
                'message' => 'Draf yang dihasilkan AI tidak lengkap (tidak ada bagian Menimbang / Mengingat). Coba lagi atau gunakan model AI yang lebih kuat.',
            ], 502);
        }

        $perdes = Perdes::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'judul' => $request->judul,
            'isi' => $draft,
            'status' => 'draft',
        ]);

        return response()->json(['redirect' => route('admin.perdes.show', $perdes)]);
    }

    public function show(Perdes $perdes)
    {
        $voteSummary = $perdes->status === 'draft' ? $perdes->voteSummary() : null;
        $voteList    = $perdes->status === 'draft'
            ? $perdes->votes()->latest()->paginate(10, ['*'], 'vpage')
            : null;

        return view('admin.perdes.show', compact('perdes', 'voteSummary', 'voteList'));
    }

    public function update(Request $request, Perdes $perdes)
    {
        abort_if($perdes->status !== 'draft', 403, 'Peraturan yang sudah selesai tidak dapat diedit.');

        $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
        ]);

        $perdes->update($request->only('judul', 'isi'));

        return redirect()->route('admin.perdes.show', $perdes)->with('success', 'Perubahan berhasil disimpan.');
    }

    public function toggleStatus(Perdes $perdes)
    {
        $perdes->update(['status' => $perdes->status === 'selesai' ? 'draft' : 'selesai']);

        return back()->with('success', 'Status peraturan berhasil diperbarui.');
    }

    public function destroy(Perdes $perdes)
    {
        $perdes->delete();

        return redirect()->route('admin.perdes.index')->with('success', 'Draf berhasil dihapus.');
    }

    public function pdf(Perdes $perdes)
    {
        $s = Setting::pluck('value', 'key');
        $kepalaDesa = StrukturDesa::find('kepala_desa');
        $sekretarisDesa = StrukturDesa::find('sekretaris');
        $logoPath = $s->get('desa_logo') ? Storage::disk('public')->path($s->get('desa_logo')) : null;
        $fileName = Str::slug($perdes->judul).'.pdf';
        $isiPdf = $this->transformIsiForPdf($perdes->isi);

        $pdfSettings = [
            'font_family'   => $s->get('pdf_font_family',   'Arial'),
            'font_size'     => (int)   ($s->get('pdf_font_size',     12)),
            'line_spacing'  => (float) ($s->get('pdf_line_spacing',  1.5)),
            'margin_top'    => (float) ($s->get('pdf_margin_top',    4)),
            'margin_left'   => (float) ($s->get('pdf_margin_left',   3)),
            'margin_right'  => (float) ($s->get('pdf_margin_right',  3)),
            'margin_bottom' => (float) ($s->get('pdf_margin_bottom', 3)),
        ];

        return Pdf::loadView('admin.perdes.pdf', compact('perdes', 's', 'kepalaDesa', 'sekretarisDesa', 'logoPath', 'isiPdf', 'pdfSettings'))
            ->setPaper('a4', 'portrait')
            ->download($fileName);
    }

    private function transformIsiForPdf(string $html): string
    {
        // 0. Hapus paragraf kosong/spasi-saja — penyebab utama halaman kosong di PDF
        $html = preg_replace('/<p[^>]*>\s*(<br\s*\/?>\s*)*<\/p>/i', '', $html);

        // 1. Menimbang/Mengingat → tabel flat satu level: label|sep|num|text per baris
        //    Nested table dihindari karena dompdf kehilangan posisi & tambah spasi saat page-break
        $html = preg_replace_callback(
            '/<p[^>]*><strong>(Menimbang|Mengingat)[^<]*<\/strong><\/p>\s*(<ol[^>]*>.*?<\/ol>)/si',
            static function (array $m): string {
                $label   = htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8');
                $olHtml  = $m[2];
                $isAlpha = (bool) preg_match('/type=["\']a["\']/i', $olHtml);

                preg_match_all('/<li[^>]*>(.*?)<\/li>/si', $olHtml, $liMatches);

                $letters = range('a', 'z');
                $rows    = '';
                foreach ($liMatches[1] as $i => $content) {
                    $prefix    = $isAlpha ? ($letters[$i % 26].'.') : (($i + 1).'.');
                    // Label dan titik dua hanya di baris pertama; baris berikutnya kosong
                    $headCells = ($i === 0)
                        ? '<td class="k-label">'.$label.'</td><td class="k-sep">:</td>'
                        : '<td class="k-label"></td><td class="k-sep"></td>';
                    $rows .= '<tr>'.$headCells
                        .'<td class="li-num">'.$prefix.'</td>'
                        .'<td class="li-text">'.trim($content).'</td>'
                        .'</tr>';
                }

                return '<table class="konsideran">'.$rows.'</table>';
            },
            $html
        );

        // 2. Ayat pasal <p>(1) teks</p> → hanging indent table
        $html = preg_replace_callback(
            '/<p[^>]*>\((\d+)\)\s+(.*?)<\/p>/si',
            static function (array $m): string {
                return '<table class="ayat-row"><tr>'
                    .'<td class="ayat-num">('.$m[1].')</td>'
                    .'<td class="ayat-text">'.$m[2].'</td>'
                    .'</tr></table>';
            },
            $html
        );

        return $html;
    }

    private function wilayahInstruction(): string
    {
        $desa = Setting::get('desa_nama');
        $kecamatan = Setting::get('desa_kecamatan');
        $kabupaten = Setting::get('desa_kabupaten');
        $provinsi = Setting::get('desa_provinsi');

        if (! filled($desa) && ! filled($kecamatan) && ! filled($kabupaten) && ! filled($provinsi)) {
            return 'Informasi wilayah (desa/kecamatan/kabupaten/provinsi) belum diatur di Pengaturan, gunakan placeholder umum seperti "[Nama Desa]".';
        }

        return sprintf(
            'Gunakan nama wilayah berikut secara konsisten di seluruh draf (pembukaan, menimbang, dan pasal terkait): Desa %s, Kecamatan %s, Kabupaten/Kota %s, Provinsi %s.',
            $desa ?: '[Nama Desa]',
            $kecamatan ?: '[Nama Kecamatan]',
            $kabupaten ?: '[Nama Kabupaten/Kota]',
            $provinsi ?: '[Nama Provinsi]',
        );
    }

    private function jenisStructureInstruction(string $jenis): string
    {
        $desa = Setting::get('desa_nama') ?: '[Nama Desa]';

        return match ($jenis) {
            'perdes' => sprintf(
                'Untuk bagian Memutuskan & Menetapkan, tulis tiga baris rata tengah dengan <h3>: "Dengan Persetujuan Bersama", "BADAN PERMUSYAWARATAN DESA %s", "dan KEPALA DESA %s", lalu <h3>MEMUTUSKAN:</h3>, kemudian <p>Menetapkan : <strong>PERATURAN DESA %s TENTANG [JUDUL HURUF BESAR].</strong></p>. Pada bagian Penutup, sebutkan bahwa peraturan desa ini akan dimuat dalam Lembaran Desa %s.',
                strtoupper($desa), strtoupper($desa), strtoupper($desa), $desa,
            ),
            'perkades' => sprintf(
                'Untuk bagian Memutuskan & Menetapkan (tanpa persetujuan BPD, karena Peraturan Kepala Desa ditetapkan langsung oleh Kepala Desa), tulis <h3>MEMUTUSKAN:</h3> lalu <p>Menetapkan : <strong>PERATURAN KEPALA DESA %s TENTANG [JUDUL HURUF BESAR].</strong></p>. Pada bagian Penutup, sebutkan bahwa peraturan ini akan dimuat dalam Berita Desa %s.',
                strtoupper($desa), $desa,
            ),
            'sk_kades' => sprintf(
                'Untuk bagian Menetapkan, gunakan format diktum bernomor KESATU, KEDUA, dan seterusnya (bukan pasal-pasal) memakai <ol type="1">, didahului <h3>MEMUTUSKAN:</h3> dan <p>Menetapkan : <strong>KEPUTUSAN KEPALA DESA %s TENTANG [JUDUL HURUF BESAR].</strong></p>. Pada bagian Penutup, cukup nyatakan bahwa keputusan ini mulai berlaku pada tanggal ditetapkan, tanpa pengundangan dalam Lembaran/Berita Desa.',
                strtoupper($desa),
            ),
            default => '',
        };
    }
}
