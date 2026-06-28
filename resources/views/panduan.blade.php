@extends('layouts.public')

@section('title', 'Panduan')

@php $activeNav = 'panduan'; @endphp

@section('styles')
.tab-btn { padding:0.5rem 1.25rem; font-size:0.875rem; font-weight:600; border-radius:0.625rem; border:1px solid #e5e7eb; color:#6b7280; transition:all 0.2s; cursor:pointer; background:white; }
.tab-btn.active { background:var(--p-700); color:white; border-color:var(--p-700); }
.dark .tab-btn { background:#1f2937; border-color:#374151; color:#9ca3af; }
.dark .tab-btn.active { background:var(--p-700); color:white; border-color:var(--p-700); }
.tab-panel { display:none; }
.tab-panel.active { display:block; }

.step-num { width:2rem; height:2rem; border-radius:50%; background:var(--p-700); color:white; font-weight:700; font-size:0.875rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.step-line { width:2rem; display:flex; justify-content:center; flex-shrink:0; }

.perdes-node { border-left:3px solid var(--p-400); padding:0.75rem 1rem; margin-left:1rem; }
.perdes-node-title { font-weight:700; font-size:0.8125rem; color:var(--p-700); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem; }

.faq-item summary { cursor:pointer; list-style:none; }
.faq-item summary::-webkit-details-marker { display:none; }
.faq-item[open] summary .faq-icon { transform:rotate(45deg); }
.faq-icon { transition:transform 0.2s; }
@endsection

@section('content')

{{-- Hero --}}
<section class="py-14 bg-gradient-to-br from-primary-700 to-primary-900 relative overflow-hidden">
  <div class="absolute inset-0 opacity-10" style="background-image:url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff' fill-opacity='1' fill-rule='evenodd'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E\")"></div>
  <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 border border-white/20 rounded-full text-white/80 text-xs font-semibold mb-5">
      <svg class="w-3.5 h-3.5 text-emas-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>
      Pusat Informasi &amp; Panduan
    </div>
    <h1 class="font-display text-3xl md:text-4xl font-bold text-white leading-tight mb-4">
      Panduan Portal SADAR HUKUM
    </h1>
    <p class="text-primary-200 text-sm md:text-base leading-relaxed max-w-2xl mx-auto">
      Pelajari cara menggunakan portal, memahami struktur peraturan desa, dan temukan jawaban atas pertanyaan yang sering diajukan.
    </p>
  </div>
</section>

{{-- Tabs --}}
<div class="sticky top-16 z-40 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 shadow-sm">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex gap-2 overflow-x-auto">
    <button class="tab-btn active" onclick="switchTab('panduan-web', this)">
      <span class="flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        Panduan Penggunaan
      </span>
    </button>
    <button class="tab-btn" onclick="switchTab('struktur-perdes', this)">
      <span class="flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Struktur Peraturan Desa
      </span>
    </button>
    <button class="tab-btn" onclick="switchTab('tanya-jawab', this)">
      <span class="flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Tanya Jawab (FAQ)
      </span>
    </button>
  </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

  {{-- ═════ TAB 1: PANDUAN PENGGUNAAN ═════ --}}
  <div id="tab-panduan-web" class="tab-panel active">

    <div class="mb-10">
      <h2 class="font-display text-2xl font-bold text-gray-800 dark:text-white mb-2">Panduan Penggunaan Portal</h2>
      <p class="text-sm text-gray-500 dark:text-gray-400">Ikuti langkah-langkah berikut untuk memanfaatkan portal SADAR HUKUM secara optimal.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-12">

      {{-- Kartu 1 --}}
      <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm aos">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:var(--p-100)">
            <svg class="w-5 h-5" style="color:var(--p-700)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          </div>
          <h3 class="font-bold text-gray-800 dark:text-white">Mencari Peraturan Desa</h3>
        </div>
        <ol class="space-y-3">
          <li class="flex gap-3">
            <span class="step-num">1</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Buka halaman utama dan gulir ke bagian <strong class="text-gray-800 dark:text-gray-200">Peraturan Desa</strong>.</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">2</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Gunakan kotak <strong class="text-gray-800 dark:text-gray-200">Cari Peraturan</strong> untuk mengetik kata kunci, atau pilih tab jenis peraturan (Perdes / Perkades / SK Kepala Desa).</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">3</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Klik tombol <strong class="text-gray-800 dark:text-gray-200">Detail</strong> pada kartu untuk melihat ringkasan peraturan.</p>
          </li>
        </ol>
      </div>

      {{-- Kartu 2 --}}
      <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm aos aos-delay-1">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:var(--p-100)">
            <svg class="w-5 h-5" style="color:var(--p-700)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>
          <h3 class="font-bold text-gray-800 dark:text-white">Mendaftar sebagai Warga</h3>
        </div>
        <ol class="space-y-3">
          <li class="flex gap-3">
            <span class="step-num">1</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Klik tombol <strong class="text-gray-800 dark:text-gray-200">Daftar</strong> di pojok kanan atas navbar.</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">2</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Masukkan <strong class="text-gray-800 dark:text-gray-200">NIK</strong> dan <strong class="text-gray-800 dark:text-gray-200">Tanggal Lahir</strong> untuk verifikasi identitas dari data kependudukan desa.</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">3</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Setelah terverifikasi, buat <strong class="text-gray-800 dark:text-gray-200">Email &amp; Password</strong> untuk akun login Anda.</p>
          </li>
        </ol>
      </div>

      {{-- Kartu 3 --}}
      <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm aos">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:var(--p-100)">
            <svg class="w-5 h-5" style="color:var(--p-700)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <h3 class="font-bold text-gray-800 dark:text-white">Berpartisipasi dalam Perdes</h3>
        </div>
        <ol class="space-y-3">
          <li class="flex gap-3">
            <span class="step-num">1</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1"><strong class="text-gray-800 dark:text-gray-200">Login</strong> dengan akun warga yang sudah terdaftar.</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">2</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Buka menu <strong class="text-gray-800 dark:text-gray-200">Partisipasi</strong> dan pilih peraturan yang sedang dalam proses pembahasan.</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">3</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Baca draft peraturan, lalu pilih sikap: <strong class="text-gray-800 dark:text-gray-200">Setuju</strong>, <strong class="text-gray-800 dark:text-gray-200">Perlu Perbaikan</strong>, atau <strong class="text-gray-800 dark:text-gray-200">Menolak</strong>, serta tuliskan masukan Anda.</p>
          </li>
        </ol>
      </div>

      {{-- Kartu 4 --}}
      <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm aos aos-delay-1">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:var(--p-100)">
            <svg class="w-5 h-5" style="color:var(--p-700)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
          </div>
          <h3 class="font-bold text-gray-800 dark:text-white">Membaca Berita &amp; Pengumuman</h3>
        </div>
        <ol class="space-y-3">
          <li class="flex gap-3">
            <span class="step-num">1</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Gulir halaman utama ke bagian <strong class="text-gray-800 dark:text-gray-200">Pengumuman Desa</strong> untuk informasi resmi terbaru.</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">2</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Bagian <strong class="text-gray-800 dark:text-gray-200">Berita Desa</strong> menampilkan artikel dan liputan kegiatan desa.</p>
          </li>
          <li class="flex gap-3">
            <span class="step-num">3</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 pt-1">Klik kartu berita untuk membaca artikel lengkap di halaman detail.</p>
          </li>
        </ol>
      </div>

    </div>

  </div>{{-- /tab-panduan-web --}}


  {{-- ═════ TAB 2: STRUKTUR PERATURAN DESA ═════ --}}
  <div id="tab-struktur-perdes" class="tab-panel">

    <div class="mb-10">
      <h2 class="font-display text-2xl font-bold text-gray-800 dark:text-white mb-2">Struktur Peraturan Desa</h2>
      <p class="text-sm text-gray-500 dark:text-gray-400">Peraturan Desa memiliki anatomi baku yang ditetapkan oleh ketentuan perundang-undangan. Pahami setiap bagian di bawah ini.</p>
    </div>

    {{-- Jenis Peraturan --}}
    <div class="grid md:grid-cols-3 gap-5 mb-12">
      @foreach([
        ['jenis'=>'Peraturan Desa (Perdes)', 'singkat'=>'PERDES', 'warna'=>'primary', 'deskripsi'=>'Ditetapkan oleh Kepala Desa bersama BPD. Mengatur hal-hal yang bersifat umum dan mengikat seluruh warga desa.', 'contoh'=>['APBDesa', 'Tata Ruang', 'BUMDes', 'Ketertiban Umum']],
        ['jenis'=>'Peraturan Kepala Desa (Perkades)', 'singkat'=>'PERKADES', 'warna'=>'blue', 'deskripsi'=>'Ditetapkan oleh Kepala Desa untuk melaksanakan peraturan yang lebih tinggi atau Perdes yang memerlukan pengaturan teknis.', 'contoh'=>['Tata Cara Pelayanan', 'Jadwal Kegiatan', 'Prosedur Administrasi', 'Petunjuk Teknis']],
        ['jenis'=>'SK Kepala Desa', 'singkat'=>'SK KADES', 'warna'=>'amber', 'deskripsi'=>'Keputusan yang bersifat individual, konkret, dan final. Berisi penetapan seseorang atau sesuatu yang bersifat administratif.', 'contoh'=>['Pengangkatan Perangkat', 'Panitia Musdes', 'Tim Kerja Proyek', 'Penunjukan Pejabat']],
      ] as $j)
      @php
        $bc = $j['warna'] === 'amber' ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400' : "bg-{$j['warna']}-100 dark:bg-{$j['warna']}-900/40 text-{$j['warna']}-700 dark:text-{$j['warna']}-400";
        $bd = $j['warna'] === 'amber' ? 'border-amber-200 dark:border-amber-800' : "border-{$j['warna']}-200 dark:border-{$j['warna']}-800";
      @endphp
      <div class="bg-white dark:bg-gray-800 rounded-2xl border {{ $bd }} p-6 shadow-sm aos">
        <div class="inline-block px-2.5 py-1 text-xs font-bold rounded-lg mb-4 {{ $bc }}">{{ $j['singkat'] }}</div>
        <h3 class="font-bold text-gray-800 dark:text-white text-sm mb-2">{{ $j['jenis'] }}</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mb-4">{{ $j['deskripsi'] }}</p>
        <div>
          <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Contoh pengaturan:</p>
          <div class="flex flex-wrap gap-1.5">
            @foreach($j['contoh'] as $c)
            <span class="text-xs px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md">{{ $c }}</span>
            @endforeach
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Anatomi Perdes --}}
    <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-6 flex items-center gap-2">
      <svg class="w-5 h-5" style="color:var(--p-600)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
      Anatomi Peraturan Desa
    </h3>

    <div class="space-y-3 mb-12">
      @foreach([
        ['no'=>'A', 'judul'=>'Judul Peraturan', 'bg'=>'bg-primary-700', 'isi'=>'Mencantumkan nomor, tahun, dan nama peraturan. Format: "PERATURAN DESA [NAMA DESA] NOMOR [X] TAHUN [YYYY] TENTANG [NAMA PERATURAN]"', 'sub'=>[]],
        ['no'=>'B', 'judul'=>'Pembukaan', 'bg'=>'bg-primary-600', 'isi'=>'Bagian awal yang memuat dasar pertimbangan dan hukum pembentukan peraturan.', 'sub'=>[
          ['label'=>'Menimbang', 'keterangan'=>'Alasan filosofis, sosiologis, dan yuridis pembentukan peraturan. Minimal 3 butir pertimbangan: (a) manfaat sosial, (b) kondisi nyata di masyarakat, (c) kewenangan hukum.'],
          ['label'=>'Mengingat', 'keterangan'=>'Dasar hukum dari hierarki tertinggi: UUD 1945 → UU → PP → Permendagri → Perda → Perdes terkait.'],
          ['label'=>'Memperhatikan', 'keterangan'=>'(Opsional) Dokumen pendukung seperti hasil musyawarah atau aspirasi warga.'],
        ]],
        ['no'=>'C', 'judul'=>'Diktum (Memutuskan/Menetapkan)', 'bg'=>'bg-primary-500', 'isi'=>'Inti penetapan peraturan. Untuk Perdes, memuat kalimat "Dengan Persetujuan Bersama BADAN PERMUSYAWARATAN DESA [NAMA DESA] dan KEPALA DESA [NAMA DESA] MEMUTUSKAN: MENETAPKAN: PERATURAN DESA TENTANG..."', 'sub'=>[]],
        ['no'=>'D', 'judul'=>'Batang Tubuh', 'bg'=>'bg-primary-400', 'isi'=>'Isi pokok peraturan yang dibagi dalam BAB dan Pasal-Pasal.', 'sub'=>[
          ['label'=>'BAB I – Ketentuan Umum', 'keterangan'=>'Definisi dan istilah-istilah kunci yang digunakan dalam peraturan agar tidak menimbulkan penafsiran ganda.'],
          ['label'=>'BAB II – (Materi Pokok)', 'keterangan'=>'Substansi pengaturan utama sesuai topik peraturan. Bisa terdiri dari beberapa BAB tergantung kebutuhan.'],
          ['label'=>'BAB Sanksi', 'keterangan'=>'(Jika relevan) Jenis dan mekanisme sanksi bagi pelanggar ketentuan peraturan.'],
          ['label'=>'BAB Ketentuan Penutup', 'keterangan'=>'Pasal pemberlakuan, pencabutan aturan lama (jika ada), dan tanggal mulai berlaku.'],
        ]],
        ['no'=>'E', 'judul'=>'Penutup', 'bg'=>'bg-primary-300', 'isi'=>'Tempat dan tanggal penetapan, tanda tangan Kepala Desa beserta stempel, dan pernyataan bahwa peraturan ini dicatat dalam Lembaran Desa.', 'sub'=>[]],
        ['no'=>'F', 'judul'=>'Lampiran', 'bg'=>'bg-gray-400', 'isi'=>'(Opsional) Dokumen pendukung seperti peta, daftar, tabel, atau rincian teknis yang terlalu panjang jika dimuat di batang tubuh.', 'sub'=>[]],
      ] as $item)
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden aos">
        <div class="flex items-center gap-3 p-4">
          <div class="w-8 h-8 {{ $item['bg'] }} text-white rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">{{ $item['no'] }}</div>
          <div class="flex-1">
            <h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $item['judul'] }}</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">{{ $item['isi'] }}</p>
          </div>
        </div>
        @if(count($item['sub']))
        <div class="border-t border-gray-100 dark:border-gray-700 divide-y divide-gray-50 dark:divide-gray-700/50">
          @foreach($item['sub'] as $s)
          <div class="pl-14 pr-4 py-3 flex gap-3">
            <span class="text-xs font-semibold text-primary-700 dark:text-primary-400 w-40 flex-shrink-0">{{ $s['label'] }}</span>
            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $s['keterangan'] }}</p>
          </div>
          @endforeach
        </div>
        @endif
      </div>
      @endforeach
    </div>

    {{-- Alur Pembentukan --}}
    <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-6 flex items-center gap-2">
      <svg class="w-5 h-5" style="color:var(--p-600)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
      Alur Pembentukan Peraturan Desa
    </h3>
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
      <div class="space-y-0">
        @foreach([
          ['no'=>'1', 'judul'=>'Inisiasi / Usulan', 'keterangan'=>'Perdes dapat diprakarsai oleh Kepala Desa atau BPD. Usulan dapat pula berasal dari masyarakat melalui musyawarah desa.'],
          ['no'=>'2', 'judul'=>'Penyusunan Rancangan', 'keterangan'=>'Tim penyusun (Pemdes/BPD) menyiapkan rancangan peraturan berdasarkan kebutuhan dan aspirasi warga.'],
          ['no'=>'3', 'judul'=>'Konsultasi Publik', 'keterangan'=>'Rancangan disosialisasikan kepada masyarakat. Warga dapat memberikan masukan melalui portal SADAR HUKUM (fitur Partisipasi).'],
          ['no'=>'4', 'judul'=>'Pembahasan BPD', 'keterangan'=>'BPD membahas rancangan, mempertimbangkan masukan warga, dan memberikan persetujuan bersama Kepala Desa.'],
          ['no'=>'5', 'judul'=>'Penetapan &amp; Pengesahan', 'keterangan'=>'Kepala Desa menandatangani peraturan. Untuk perdes tertentu, dievaluasi oleh Camat/Bupati sebelum diberlakukan.'],
          ['no'=>'6', 'judul'=>'Pengundangan &amp; Publikasi', 'keterangan'=>'Peraturan dimuat dalam Lembaran Desa/Berita Desa dan dipublikasikan melalui portal SADAR HUKUM.'],
        ] as $i => $alur)
        <div class="flex gap-4">
          <div class="flex flex-col items-center">
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white flex-shrink-0" style="background:var(--p-700)">{{ $alur['no'] }}</div>
            @if($i < 5)
            <div class="w-0.5 flex-1 min-h-[2rem]" style="background:var(--p-200)"></div>
            @endif
          </div>
          <div class="pb-6 flex-1">
            <h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">{!! $alur['judul'] !!}</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{!! $alur['keterangan'] !!}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>{{-- /tab-struktur-perdes --}}


  {{-- ═════ TAB 3: TANYA JAWAB ═════ --}}
  <div id="tab-tanya-jawab" class="tab-panel">

    <div class="mb-10">
      <h2 class="font-display text-2xl font-bold text-gray-800 dark:text-white mb-2">Tanya Jawab (FAQ)</h2>
      <p class="text-sm text-gray-500 dark:text-gray-400">Kumpulan pertanyaan yang sering diajukan seputar portal dan peraturan desa.</p>
    </div>

    @php
    $faqs = [
      ['kategori'=>'Tentang Portal', 'warna'=>'primary', 'items'=>[
        ['q'=>'Apa itu Portal SADAR HUKUM?', 'a'=>'SADAR HUKUM (Sistem Akses Daring Regulasi Hukum) adalah portal digital Desa Tontonunu yang menghadirkan transparansi peraturan desa, informasi publik, dan partisipasi warga dalam proses pembentukan peraturan. Portal ini merupakan hasil program PKM Kemendiktisaintek 2026 antara Fakultas Hukum UMK dengan Pemdes Tontonunu.'],
        ['q'=>'Apakah portal ini gratis digunakan?', 'a'=>'Ya, seluruh layanan portal SADAR HUKUM dapat diakses secara gratis oleh seluruh warga. Tidak ada biaya apapun untuk melihat peraturan, membaca berita, atau bahkan mendaftar sebagai pengguna terdaftar.'],
        ['q'=>'Bagaimana cara menghubungi admin portal?', 'a'=>'Anda dapat menghubungi melalui kontak yang tersedia di bagian bawah halaman utama: kantor desa, nomor telepon, atau email resmi Pemerintah Desa Tontonunu.'],
      ]],
      ['kategori'=>'Pendaftaran & Akun', 'warna'=>'blue', 'items'=>[
        ['q'=>'Siapa yang bisa mendaftar sebagai pengguna?', 'a'=>'Hanya warga yang terdaftar di data kependudukan Desa Tontonunu yang dapat membuat akun. Verifikasi dilakukan menggunakan NIK dan tanggal lahir sesuai data kependudukan yang dimiliki pemerintah desa.'],
        ['q'=>'NIK saya tidak ditemukan, apa yang harus dilakukan?', 'a'=>'Jika NIK tidak ditemukan saat pendaftaran, kemungkinan data kependudukan Anda belum termuat di sistem. Silakan kunjungi Kantor Desa Tontonunu untuk memperbarui atau mendaftarkan data kependudukan Anda.'],
        ['q'=>'Apakah satu NIK bisa digunakan untuk beberapa akun?', 'a'=>'Tidak. Setiap NIK hanya dapat didaftarkan untuk satu akun. Sistem akan menolak pendaftaran jika NIK yang sama sudah pernah digunakan sebelumnya.'],
        ['q'=>'Bagaimana jika saya lupa password?', 'a'=>'Fitur reset password tersedia di halaman login. Masukkan email yang terdaftar, dan instruksi penggantian password akan dikirimkan ke email Anda.'],
      ]],
      ['kategori'=>'Partisipasi Warga', 'warna'=>'amber', 'items'=>[
        ['q'=>'Bagaimana cara berpartisipasi dalam pembentukan peraturan desa?', 'a'=>'Login dengan akun warga, buka menu Partisipasi, dan pilih peraturan yang sedang dalam proses pembahasan (status Draft). Baca draft peraturan secara lengkap, kemudian pilih sikap Anda (Setuju / Perlu Perbaikan / Menolak) beserta catatan atau masukan yang ingin Anda sampaikan.'],
        ['q'=>'Apakah suara dan masukan saya bersifat rahasia?', 'a'=>'Suara dan identitas warga bersifat teridentifikasi oleh sistem namun ditampilkan secara agregat kepada publik (hanya total jumlah, bukan nama individu). Masukan tertulis dapat dipertimbangkan oleh tim penyusun peraturan.'],
        ['q'=>'Apakah suara saya dapat diubah setelah dikirim?', 'a'=>'Tidak. Setelah suara dikirimkan, tidak dapat diubah. Pastikan Anda telah membaca draft peraturan secara lengkap sebelum memberikan suara.'],
        ['q'=>'Kapan batas waktu partisipasi?', 'a'=>'Setiap draft peraturan memiliki periode partisipasi yang ditetapkan oleh Pemerintah Desa. Peraturan yang sudah difinalisasi (status Selesai) tidak lagi menerima suara.'],
      ]],
      ['kategori'=>'Hukum & Peraturan', 'warna'=>'green', 'items'=>[
        ['q'=>'Apa dasar hukum kewenangan desa membentuk peraturan?', 'a'=>'Kewenangan desa untuk membentuk peraturan diatur dalam Undang-Undang Nomor 6 Tahun 2014 tentang Desa, khususnya Pasal 69 yang menyebut jenis peraturan di desa, serta Permendagri Nomor 111 Tahun 2014 tentang Pedoman Teknis Peraturan di Desa.'],
        ['q'=>'Apa perbedaan Perdes, Perkades, dan SK Kepala Desa?', 'a'=>'Perdes (Peraturan Desa) ditetapkan bersama BPD, bersifat umum dan mengikat seluruh warga. Perkades (Peraturan Kepala Desa) ditetapkan Kades untuk mengatur teknis pelaksanaan peraturan yang lebih tinggi, tanpa perlu persetujuan BPD. SK Kepala Desa bersifat individual, konkret, dan final — biasanya untuk pengangkatan atau penunjukan seseorang.'],
        ['q'=>'Apakah peraturan di portal ini sudah berlaku sah secara hukum?', 'a'=>'Ya. Peraturan yang ditampilkan di portal (status Selesai) merupakan peraturan yang telah melalui proses pembahasan resmi, ditandatangani Kepala Desa, dan dicatat dalam Lembaran/Berita Desa sesuai ketentuan yang berlaku.'],
        ['q'=>'Bagaimana jika saya merasa suatu peraturan bertentangan dengan kepentingan warga?', 'a'=>'Anda dapat menyampaikan keberatan melalui: (1) mekanisme partisipasi digital saat draft masih terbuka, (2) musyawarah desa yang diadakan Pemerintah Desa, atau (3) menyampaikan aspirasi langsung ke BPD sebagai lembaga perwakilan warga.'],
      ]],
    ];
    @endphp

    <div class="space-y-8">
      @foreach($faqs as $grup)
      @php
        $gw = $grup['warna'];
        $gbadge = $gw === 'green' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                : ($gw === 'amber' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400'
                : ($gw === 'blue'  ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400'
                : 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400'));
      @endphp
      <div class="aos">
        <div class="inline-block px-3 py-1 text-xs font-bold rounded-full mb-4 {{ $gbadge }}">{{ $grup['kategori'] }}</div>
        <div class="space-y-2">
          @foreach($grup['items'] as $faq)
          <details class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden group">
            <summary class="flex items-center justify-between gap-4 p-4 cursor-pointer select-none">
              <span class="font-semibold text-gray-800 dark:text-gray-100 text-sm leading-snug">{{ $faq['q'] }}</span>
              <svg class="faq-icon w-5 h-5 flex-shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
            </summary>
            <div class="px-4 pb-4 pt-0 border-t border-gray-50 dark:border-gray-700">
              <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mt-3">{{ $faq['a'] }}</p>
            </div>
          </details>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>

    {{-- CTA --}}
    <div class="mt-12 p-6 rounded-2xl border text-center aos" style="background:var(--p-50);border-color:var(--p-200)">
      <svg class="w-10 h-10 mx-auto mb-3" style="color:var(--p-600)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
      </svg>
      <h4 class="font-bold text-gray-800 dark:text-white mb-2">Masih ada pertanyaan?</h4>
      <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Hubungi langsung Kantor Desa Tontonunu atau kunjungi laman kontak kami.</p>
      <a href="{{ url('/') }}#kontak"
         class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-xl transition-all hover:opacity-90"
         style="background:var(--p-700)">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        Hubungi Kami
      </a>
    </div>

  </div>{{-- /tab-tanya-jawab --}}

</div>{{-- /container --}}

@endsection

@section('scripts')
<script>
  function switchTab(id, btn) {
    document.querySelectorAll('.tab-panel').forEach(function(p) { p.classList.remove('active'); });
    document.querySelectorAll('.tab-btn').forEach(function(b) { b.classList.remove('active'); });
    document.getElementById('tab-' + id).classList.add('active');
    btn.classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>
@endsection
