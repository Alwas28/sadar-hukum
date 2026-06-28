<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perdes extends Model
{
    public const DEFAULT_PROMPT_TEMPLATES = [
        'perdes' => <<<'TEXT'
Panduan isi setiap bagian:
1. Menimbang: Cantumkan minimal 3 butir — (a) filosofis: manfaat sosial bagi masyarakat desa; (b) sosiologis: kondisi nyata yang melatarbelakangi; (c) yuridis: kewenangan desa berdasarkan UU No. 6 Tahun 2014 tentang Desa.
2. Mengingat: Cantumkan dasar hukum dari yang tertinggi — UUD 1945, UU tentang Desa, Peraturan Pemerintah, Permendagri, Peraturan Daerah, hingga Peraturan Desa terkait yang berlaku.
3. Memutuskan & Menetapkan: Sertakan persetujuan bersama BPD sesuai format yang diperintahkan sistem.
4. Batang Tubuh: Sertakan BAB Ketentuan Umum (definisi istilah kunci), BAB pengaturan utama sesuai topik, BAB Sanksi (jika relevan), dan BAB Ketentuan Penutup.
5. Penutup: Nyatakan bahwa peraturan ini dicatat dalam Lembaran Desa.
TEXT,

        'perkades' => <<<'TEXT'
Panduan isi setiap bagian:
1. Menimbang: Cantumkan minimal 2 butir pertimbangan teknis — alasan kebutuhan pelaksanaan dan kewenangan Kepala Desa mengeluarkan peraturan ini.
2. Mengingat: Cantumkan dasar hukum relevan termasuk Peraturan Desa induk (jika ada) yang menjadi dasar Peraturan Kepala Desa ini.
3. Memutuskan & Menetapkan: Tanpa persetujuan BPD — ikuti format yang diperintahkan sistem.
4. Batang Tubuh: Sertakan pasal-pasal teknis pelaksanaan, tata cara/prosedur, dan ketentuan penutup.
5. Penutup: Nyatakan bahwa peraturan ini dicatat dalam Berita Desa.
TEXT,

        'sk_kades' => <<<'TEXT'
Panduan isi setiap bagian:
1. Menimbang: Cantumkan 2–3 butir alasan dan pertimbangan mengapa keputusan ini perlu ditetapkan.
2. Mengingat: Cantumkan dasar hukum dan dokumen rujukan yang melandasi keputusan ini.
3. Menetapkan: Gunakan format diktum bernomor (KESATU, KEDUA, dst.) sebagaimana diperintahkan sistem — bukan pasal-pasal.
4. Lampiran: Jika diperlukan, sertakan rincian teknis (susunan tim, nama-nama, dsb.) sebagai lampiran.
5. Penutup: Nyatakan keputusan ini mulai berlaku pada tanggal ditetapkan.
TEXT,
    ];

    protected $table = 'perdes';

    protected $fillable = ['user_id', 'jenis', 'judul', 'isi', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(PerdesVote::class);
    }

    public function voteSummary(): array
    {
        $counts = $this->votes()->selectRaw('suara, count(*) as total')->groupBy('suara')->pluck('total', 'suara')->toArray();
        $total  = array_sum($counts);
        return [
            'total'     => $total,
            'setuju'    => $counts['setuju']    ?? 0,
            'menolak'   => $counts['menolak']   ?? 0,
            'perbaikan' => $counts['perbaikan'] ?? 0,
            'pct_setuju'    => $total ? round(($counts['setuju']    ?? 0) / $total * 100) : 0,
            'pct_menolak'   => $total ? round(($counts['menolak']   ?? 0) / $total * 100) : 0,
            'pct_perbaikan' => $total ? round(($counts['perbaikan'] ?? 0) / $total * 100) : 0,
        ];
    }

    public static function jenisLabel(string $jenis): string
    {
        return match ($jenis) {
            'perdes' => 'Peraturan Desa',
            'perkades' => 'Peraturan Kepala Desa',
            'sk_kades' => 'SK Kepala Desa',
            default => $jenis,
        };
    }

    public static function defaultPromptTemplate(string $jenis): string
    {
        return self::DEFAULT_PROMPT_TEMPLATES[$jenis] ?? self::DEFAULT_PROMPT_TEMPLATES['perdes'];
    }

    public static function jenisHeading(string $jenis): string
    {
        return match ($jenis) {
            'perdes' => 'PERATURAN DESA',
            'perkades' => 'PERATURAN KEPALA DESA',
            'sk_kades' => 'KEPUTUSAN KEPALA DESA',
            default => strtoupper($jenis),
        };
    }
}
