<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AiDraftService
{
    private const SAMBUTAN_SYSTEM_PROMPT = <<<'TEXT'
Anda adalah asisten penulis sambutan resmi Kepala Desa di Indonesia. Tugas Anda menghasilkan naskah sambutan formal, hangat, dan berbobot dalam Bahasa Indonesia baku.

FORMAT OUTPUT (WAJIB):
Keluarkan HANYA HTML mentah. DILARANG menggunakan blok kode markdown (``` atau ```html). DILARANG menambahkan kalimat pembuka seperti "Berikut adalah..." atau kalimat penutup. Respons langsung dimulai dari tag HTML pertama.

ATURAN TAG HTML (WAJIB):
- Gunakan HANYA: <h3>, <p>, <strong>, <em>. Jangan gunakan tag lain.
- Setiap paragraf dibungkus <p>...</p>.
- Bagian judul/subjudul (Assalamu'alaikum, Pembukaan, dll) pakai <h3>.
- Kutipan atau penekanan penting pakai <strong>.

STRUKTUR WAJIB:
1. Salam pembuka: <h3>Assalamu'alaikum Warahmatullahi Wabarakatuh,</h3> lalu salam lintas agama dalam <p>.
2. Sapaan hadirin: <p> berisi sapaan kepada tamu undangan, perangkat desa, dan warga (sesuaikan dengan acara).
3. Syukur: <p> berisi ungkapan syukur kepada Tuhan YME.
4. Isi utama: minimal 3 paragraf <p> yang membahas tema acara — relevan, inspiratif, dan berisi pesan bermakna.
5. Harapan & penutup: <p> berisi harapan dan ajakan.
6. Salam penutup: <h3>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</h3>

JANGAN sertakan: nama desa, nama kepala desa, tanggal, nomor, kop surat, tanda tangan — semua itu disediakan sistem.
TEXT;

    private const SYSTEM_PROMPT = <<<'TEXT'
Anda adalah asisten hukum pemerintahan desa di Indonesia yang menyusun draf regulasi desa resmi dalam Bahasa Indonesia baku, untuk dicetak sebagai dokumen PDF.

FORMAT OUTPUT (WAJIB):
Keluarkan HANYA HTML mentah — DILARANG KERAS menggunakan blok kode markdown (``` atau ```html) sebagai pembungkus. DILARANG menambahkan kalimat pembuka seperti "Berikut adalah..." atau kalimat penutup apa pun. Respons harus langsung dimulai dari tag HTML pertama.

ATURAN TAG HTML (WAJIB DIPATUHI):
- Gunakan HANYA tag <h2>, <h3>, <p>, <strong>, <em>, <ol>, <li>, <blockquote>. Jangan gunakan <html>, <body>, <table>, <div>, atau atribut style apa pun.
- <ol> untuk daftar Menimbang HARUS memakai atribut type="a" (huruf a, b, c, ...). <ol> untuk daftar Mengingat HARUS memakai atribut type="1" (angka 1, 2, 3, ...).
- Setiap <li> pada Menimbang/Mengingat diakhiri tanda titik koma (;), kecuali butir terakhir diakhiri titik (.).
- JANGAN menyertakan kop surat, nomor regulasi, atau judul resmi — semua itu sudah disediakan sistem di luar draf ini.
- JANGAN menyertakan blok "Ditetapkan di .../pada tanggal .../tanda tangan" — bagian itu disisipkan otomatis oleh sistem.

STRUKTUR WAJIB DAN URUTANNYA:
1. Pembukaan: <h3>DENGAN RAHMAT TUHAN YANG MAHA ESA</h3> lalu <h3>KEPALA DESA [NAMA DESA HURUF KAPITAL],</h3> — isi nama desa sesuai yang disebutkan dalam instruksi pengguna.
2. Menimbang: <p><strong>Menimbang :</strong></p> diikuti LANGSUNG <ol type="a"> berisi minimal 3 butir pertimbangan filosofis, sosiologis, dan yuridis.
3. Mengingat: <p><strong>Mengingat :</strong></p> diikuti LANGSUNG <ol type="1"> berisi dasar hukum relevan urut dari peraturan tertinggi ke terendah.
4. Memutuskan & Menetapkan: ikuti instruksi tambahan untuk jenis regulasi ini pada pesan pengguna.
5. Batang tubuh: gunakan <h2>BAB [angka romawi]</h2> lalu <h3>[NAMA BAB HURUF BESAR]</h3>, kemudian <h3>Pasal [angka]</h3> diikuti isi pasal sebagai <p>. Untuk pasal berayat: <p>(1) Teks ayat pertama ...</p>. Sertakan minimal: BAB Ketentuan Umum, BAB pengaturan utama, BAB Sanksi (jika relevan), BAB Ketentuan Penutup.
6. Penutup: paragraf penutup sesuai instruksi tambahan untuk jenis regulasi ini.
TEXT;

    public function generate(string $provider, string $model, string $apiKey, string $prompt): string
    {
        return match ($provider) {
            'openai' => $this->generateOpenAi($model, $apiKey, $prompt),
            'anthropic' => $this->generateAnthropic($model, $apiKey, $prompt),
            'google' => $this->generateGoogle($model, $apiKey, $prompt),
            default => throw new RuntimeException('Penyedia AI tidak dikenali.'),
        };
    }

    public function generateSambutan(string $provider, string $model, string $apiKey, string $prompt): string
    {
        return match ($provider) {
            'openai' => $this->generateOpenAiWithSystem($model, $apiKey, $prompt, self::SAMBUTAN_SYSTEM_PROMPT),
            'anthropic' => $this->generateAnthropicWithSystem($model, $apiKey, $prompt, self::SAMBUTAN_SYSTEM_PROMPT),
            'google' => $this->generateGoogleWithSystem($model, $apiKey, $prompt, self::SAMBUTAN_SYSTEM_PROMPT),
            default => throw new RuntimeException('Penyedia AI tidak dikenali.'),
        };
    }

    private function generateOpenAi(string $model, string $apiKey, string $prompt): string
    {
        return $this->generateOpenAiWithSystem($model, $apiKey, $prompt, self::SYSTEM_PROMPT);
    }

    private function generateOpenAiWithSystem(string $model, string $apiKey, string $prompt, string $system): string
    {
        $response = Http::withToken($apiKey)
            ->timeout(120)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'temperature' => 0.4,
                'max_tokens' => 4096,
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

        $this->assertSuccessful($response);

        return $this->cleanOutput((string) $response->json('choices.0.message.content'));
    }

    private function generateAnthropic(string $model, string $apiKey, string $prompt): string
    {
        return $this->generateAnthropicWithSystem($model, $apiKey, $prompt, self::SYSTEM_PROMPT);
    }

    private function generateAnthropicWithSystem(string $model, string $apiKey, string $prompt, string $system): string
    {
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01',
        ])
            ->timeout(120)
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => $model,
                'max_tokens' => 8192,
                'system' => $system,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

        $this->assertSuccessful($response);

        return $this->cleanOutput((string) $response->json('content.0.text'));
    }

    private function generateGoogle(string $model, string $apiKey, string $prompt): string
    {
        return $this->generateGoogleWithSystem($model, $apiKey, $prompt, self::SYSTEM_PROMPT);
    }

    private function generateGoogleWithSystem(string $model, string $apiKey, string $prompt, string $system): string
    {
        $response = Http::timeout(120)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'system_instruction' => ['parts' => [['text' => $system]]],
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => ['maxOutputTokens' => 8192],
            ]);

        $this->assertSuccessful($response);

        return $this->cleanOutput((string) $response->json('candidates.0.content.parts.0.text'));
    }

    private function cleanOutput(string $text): string
    {
        $text = trim($text);

        // 1. Strip markdown code fences (```html ... ``` or ``` ... ```)
        $text = preg_replace('/^```(?:html)?\s*/i', '', $text);
        $text = preg_replace('/\s*```\s*$/i', '', $text);
        $text = trim($text);

        // 2. Strip preamble prose before the first HTML opening tag
        //    (AI sometimes adds "Berikut adalah draf:" before the HTML)
        if (preg_match('/<[a-zA-Z][^>]*>/i', $text, $m, PREG_OFFSET_CAPTURE)) {
            $firstTagPos = (int) $m[0][1];
            if ($firstTagPos > 0) {
                $text = substr($text, $firstTagPos);
            }
        }

        // 3. Strip postamble prose after the last closing HTML tag
        if (preg_match_all('/<\/[a-zA-Z][^>]*>/i', $text, $m, PREG_OFFSET_CAPTURE)) {
            $last    = end($m[0]);
            $endPos  = (int) $last[1] + strlen($last[0]);
            if ($endPos < strlen($text)) {
                $text = substr($text, 0, $endPos);
            }
        }

        return trim($text);
    }

    private function assertSuccessful(Response $response): void
    {
        if ($response->failed()) {
            $message = $response->json('error.message') ?? $response->json('error.0.message');
            throw new RuntimeException($message ?? 'Gagal menghubungi layanan AI (HTTP '.$response->status().').');
        }
    }
}
