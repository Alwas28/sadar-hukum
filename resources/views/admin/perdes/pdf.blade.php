<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<style>
@php
  $ff = $pdfSettings['font_family'];
  $fs = $pdfSettings['font_size'];
  $ls = $pdfSettings['line_spacing'];
  $mt = $pdfSettings['margin_top'];
  $ml = $pdfSettings['margin_left'];
  $mr = $pdfSettings['margin_right'];
  $mb = $pdfSettings['margin_bottom'];
  $fontMap = [
    'Arial'           => ['regular' => 'arial.ttf',  'bold' => 'arialbd.ttf',  'italic' => 'ariali.ttf'],
    'Times New Roman' => ['regular' => 'times.ttf',  'bold' => 'timesbd.ttf',  'italic' => 'timesi.ttf'],
    'Courier New'     => ['regular' => 'cour.ttf',   'bold' => 'courbd.ttf',   'italic' => 'couri.ttf'],
  ];
@endphp

@if(isset($fontMap[$ff]))
  @font-face {
    font-family: '{{ $ff }}';
    font-weight: normal; font-style: normal;
    src: url('file:///C:/Windows/Fonts/{{ $fontMap[$ff]['regular'] }}') format('truetype');
  }
  @font-face {
    font-family: '{{ $ff }}';
    font-weight: bold; font-style: normal;
    src: url('file:///C:/Windows/Fonts/{{ $fontMap[$ff]['bold'] }}') format('truetype');
  }
  @font-face {
    font-family: '{{ $ff }}';
    font-weight: normal; font-style: italic;
    src: url('file:///C:/Windows/Fonts/{{ $fontMap[$ff]['italic'] }}') format('truetype');
  }
@endif

@page {
  margin: {{ $mt }}cm {{ $mr }}cm {{ $mb }}cm {{ $ml }}cm;
  size: A4 portrait;
}

body {
  font-family: '{{ $ff }}', 'DejaVu Sans', Helvetica, sans-serif;
  font-size: {{ $fs }}pt;
  color: #000;
  line-height: {{ $ls }};
}

/* ── Kop Surat ── */
.kop { text-align: center; border-bottom: 4px double #000; padding-bottom: 8pt; margin-bottom: 16pt; }
.kop img { width: 70pt; height: 70pt; margin-bottom: 4pt; }
.kop-nama { font-size: {{ $fs + 2 }}pt; font-weight: bold; margin: 2pt 0 1pt; }
.kop-sub  { font-size: {{ $fs }}pt; font-weight: normal; margin: 1pt 0; }

/* ── Header Dokumen ── */
.header-dokumen { text-align: center; margin: 16pt 0 20pt; }
.header-dokumen p { margin: 2pt 0; }
.jenis-judul  { font-size: {{ $fs }}pt; font-weight: bold; text-transform: uppercase; }
.nomor-judul  { font-size: {{ $fs }}pt; font-weight: bold; }
.tentang-text { font-size: {{ $fs }}pt; font-weight: normal; margin: 4pt 0 2pt; }
.judul-perdes { font-size: {{ $fs }}pt; font-weight: bold; text-transform: uppercase; }

/* ── Isi Draf ── */
.isi { text-align: justify; }
.isi h2 {
  text-align: center; font-size: {{ $fs }}pt; font-weight: bold;
  text-transform: uppercase; margin: 16pt 0 2pt;
}
.isi h3 {
  text-align: center; font-size: {{ $fs }}pt; font-weight: bold;
  margin: 6pt 0 3pt;
}
.isi p { margin: 3pt 0; text-align: justify; line-height: {{ $ls }}; }

/* ── Tabel Konsideran (Menimbang / Mengingat) — flat, satu level ── */
/* Struktur: k-label | k-sep | li-num | li-text  (tiap baris = satu butir) */
/* Flat table menghindari misalignment & blank space dompdf saat page-break */
.konsideran { width: 100%; border-collapse: collapse; margin: 0 0 8pt; }
.k-label    { width: 26mm; vertical-align: top; padding-right: 2mm; white-space: nowrap; }
.k-sep      { width: 6mm;  vertical-align: top; text-align: left; white-space: nowrap; padding-right: 2mm; }
.li-num     { width: 8mm;  vertical-align: top; white-space: nowrap; padding-bottom: 3pt; }
.li-text    { vertical-align: top; text-align: justify; line-height: {{ $ls }}; padding-bottom: 3pt; }

/* ── Ayat Pasal — format Word (nomor | teks) ── */
.ayat-row  { width: 100%; border-collapse: collapse; margin: 2pt 0; }
.ayat-num  { width: 12mm; vertical-align: top; white-space: nowrap; }
.ayat-text { vertical-align: top; text-align: justify; line-height: {{ $ls }}; }

/* ── Daftar biasa di luar konsideran ── */
.isi ol, .isi ul { margin: 3pt 0 8pt; padding-left: 10mm; }
.isi ol[type="a"] { list-style-type: lower-alpha; }
.isi ol[type="1"] { list-style-type: decimal; }
.isi ol li, .isi ul li { margin-bottom: 3pt; text-align: justify; }
.isi blockquote { border-left: 2pt solid #555; padding-left: 8mm; margin: 5pt 0; color: #333; }

/* ── Blok Tanda Tangan ── */
.ttd-kades      { margin-top: 24pt; margin-left: 55%; text-align: left; }
.ruang-ttd      { height: 56pt; }
.ttd-sekretaris { margin-top: 56pt; text-align: left; }
.lembaran-footer {
  border-top: 1pt solid #000; margin-top: 14pt; padding-top: 6pt;
  text-align: center; font-weight: bold; font-size: {{ $fs }}pt;
}
</style>
</head>
<body>

  {{-- KOP SURAT --}}
  <div class="kop">
    @if($logoPath)
      <img src="{{ $logoPath }}"/><br/>
    @endif
    <p class="kop-nama">KEPALA DESA {{ strtoupper($s->get('desa_nama', '[Nama Desa]')) }}</p>
    <p class="kop-sub">KECAMATAN {{ strtoupper($s->get('desa_kecamatan', '[Kecamatan]')) }}</p>
    <p class="kop-sub">KABUPATEN {{ strtoupper($s->get('desa_kabupaten', '[Kabupaten/Kota]')) }}</p>
  </div>

  {{-- HEADER DOKUMEN --}}
  <div class="header-dokumen">
    <p class="jenis-judul">{{ \App\Models\Perdes::jenisHeading($perdes->jenis) }} {{ strtoupper($s->get('desa_nama', '[Nama Desa]')) }}</p>
    <p class="nomor-judul">NOMOR ___ TAHUN {{ $perdes->created_at->format('Y') }}</p>
    <p class="tentang-text">TENTANG</p>
    <p class="judul-perdes">{{ strtoupper($perdes->judul) }}</p>
  </div>

  {{-- ISI DRAF AI (sudah ditransformasi untuk PDF) --}}
  <div class="isi">
    {!! $isiPdf !!}
  </div>

  {{-- BLOK PENETAPAN --}}
  <div class="ttd-kades">
    <p>Ditetapkan di {{ $s->get('desa_nama', '[Nama Desa]') }}<br/>
       pada tanggal {{ $perdes->created_at->locale('id')->translatedFormat('d F Y') }}</p>
    <p><strong>KEPALA DESA {{ strtoupper($s->get('desa_nama', '[Nama Desa]')) }},</strong></p>
    <div class="ruang-ttd"></div>
    <p><strong>{{ $kepalaDesa?->nama ? strtoupper($kepalaDesa->nama) : '( ........................................ )' }}</strong></p>
  </div>

  @if($perdes->jenis !== 'sk_kades')
    {{-- BLOK PENGUNDANGAN --}}
    <div class="ttd-sekretaris">
      <p>Diundangkan di {{ $s->get('desa_nama', '[Nama Desa]') }}<br/>
         pada tanggal {{ $perdes->created_at->locale('id')->translatedFormat('d F Y') }}</p>
      <p><strong>SEKRETARIS DESA {{ strtoupper($s->get('desa_nama', '[Nama Desa]')) }},</strong></p>
      <div class="ruang-ttd"></div>
      <p><strong>{{ $sekretarisDesa?->nama ? strtoupper($sekretarisDesa->nama) : '( ........................................ )' }}</strong></p>
    </div>

    <div class="lembaran-footer">
      {{ $perdes->jenis === 'perdes' ? 'LEMBARAN' : 'BERITA' }} DESA {{ strtoupper($s->get('desa_nama', '[Nama Desa]')) }} TAHUN {{ $perdes->created_at->format('Y') }} NOMOR ___
    </div>
  @endif

</body>
</html>
