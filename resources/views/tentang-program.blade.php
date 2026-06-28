@extends('layouts.public')

@section('title', 'Tentang Program')

@php $activeNav = 'tentang-program'; @endphp

@section('styles')
.hero-program {
  background-color: var(--p-800);
  background-image:
    radial-gradient(circle at 15% 50%, rgba(251,191,36,0.15) 0%, transparent 55%),
    radial-gradient(circle at 85% 30%, rgba(255,255,255,0.06) 0%, transparent 50%),
    url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
@endsection

@section('content')

{{-- ══════════ HERO ══════════ --}}
<section class="hero-program py-24 md:py-32 relative overflow-hidden">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center">
      <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400/20 border border-yellow-400/40 rounded-full text-yellow-300 text-xs font-bold tracking-widest mb-8 uppercase">
        <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
        Program Pengabdian Kepada Masyarakat · Kemendiktisaintek 2026
      </div>
      <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-black text-white leading-tight mb-6">
        Tentang Program<br/>
        <span class="text-yellow-400">SADAR HUKUM</span>
      </h1>
      <p class="text-white/75 text-lg md:text-xl leading-relaxed max-w-3xl mx-auto mb-10">
        Portal transparansi hukum desa yang dibangun melalui sinergi antara Perguruan Tinggi
        dan Pemerintah Desa dalam kerangka Pengabdian Kepada Masyarakat.
      </p>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12">
        @foreach([
          ['val' => '2026',      'lbl' => 'Tahun Pelaksanaan'],
          ['val' => 'PKM',       'lbl' => 'Skema Program'],
          ['val' => 'Tontonunu', 'lbl' => 'Desa Sasaran'],
          ['val' => 'Bombana',   'lbl' => 'Kabupaten'],
        ] as $s)
        <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl px-4 py-5">
          <div class="font-display text-2xl font-black text-yellow-400 mb-1">{{ $s['val'] }}</div>
          <div class="text-xs text-white/65 leading-tight">{{ $s['lbl'] }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <div style="position:absolute;bottom:0;left:0;right:0;width:100%;height:50px;background:white;clip-path:ellipse(60% 100% at 50% 100%);"></div>
</section>


{{-- ══════════ LATAR BELAKANG ══════════ --}}
<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 gap-14 items-center">
      <div class="aos">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600">01 · Latar Belakang</span>
        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 mt-3 mb-6 leading-tight">
          Mengapa Program Ini Dibutuhkan?
        </h2>
        <div class="space-y-4 text-gray-600 leading-relaxed">
          <p>Masyarakat desa seringkali menghadapi tantangan nyata dalam memahami dan mengakses informasi hukum yang berlaku. Minimnya literasi hukum di tingkat desa berdampak pada rendahnya partisipasi warga dalam proses pemerintahan yang seharusnya bersifat terbuka dan demokratis.</p>
          <p>Desa Tontonunu, Kecamatan Tontonunu, Kabupaten Bombana merupakan salah satu desa yang masih memerlukan penguatan aksesibilitas informasi hukum. Peraturan desa yang dihasilkan selama ini belum sepenuhnya terdokumentasi dan dapat diakses oleh seluruh lapisan masyarakat secara mudah.</p>
          <p>Fakultas Hukum Universitas Muhammadiyah Kendari hadir menjawab tantangan ini melalui program Pengabdian Kepada Masyarakat yang didanai oleh Kemendiktisaintek Tahun Anggaran 2026, dengan membangun portal digital SADAR HUKUM sebagai jembatan antara produk hukum desa dan warganya.</p>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4 aos aos-delay-2">
        @foreach([
          ['icon'=>'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
             'label'=>'Minimnya Literasi Hukum','desc'=>'Warga belum memahami hak dan kewajiban dalam regulasi desa','color'=>'bg-red-50 text-red-600 border-red-100'],
          ['icon'=>'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
             'label'=>'Dokumen Tidak Terbuka','desc'=>'Peraturan desa belum terdokumentasi dan dapat diakses publik','color'=>'bg-amber-50 text-amber-600 border-amber-100'],
          ['icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
             'label'=>'Partisipasi Rendah','desc'=>'Warga kurang dilibatkan dalam proses pembentukan perdes','color'=>'bg-blue-50 text-blue-600 border-blue-100'],
          ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
             'label'=>'Solusi Digital','desc'=>'Teknologi sebagai jembatan transparansi hukum desa','color'=>'bg-primary-50 text-primary-600 border-primary-100'],
        ] as $item)
        <div class="rounded-2xl border p-5 card-hover {{ $item['color'] }}">
          <svg class="w-7 h-7 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}"/>
          </svg>
          <div class="font-semibold text-sm mb-1">{{ $item['label'] }}</div>
          <div class="text-xs opacity-80 leading-relaxed">{{ $item['desc'] }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


{{-- ══════════ TUJUAN ══════════ --}}
<section class="py-20 bg-gray-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 aos">
      <span class="text-xs font-bold uppercase tracking-widest text-primary-600">02 · Tujuan Program</span>
      <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 mt-3 mb-4">Apa yang Ingin Kami Capai?</h2>
      <p class="text-gray-500 max-w-2xl mx-auto">Program ini dirancang dengan tujuan yang terukur dan berorientasi pada peningkatan kualitas tata kelola hukum di tingkat desa.</p>
    </div>
    <div class="grid md:grid-cols-2 gap-5">
      @foreach([
        ['no'=>'01','title'=>'Meningkatkan Aksesibilitas Informasi Hukum',
         'desc'=>'Menyediakan platform digital yang memungkinkan seluruh warga Desa Tontonunu mengakses peraturan desa, SK Kepala Desa, dan dokumen hukum lainnya secara mudah, kapan saja, dan dari mana saja tanpa biaya.',
         'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['no'=>'02','title'=>'Mendorong Partisipasi Aktif Warga',
         'desc'=>'Membuka kanal partisipasi digital bagi warga untuk memberikan masukan atau catatan perbaikan terhadap rancangan peraturan desa sebelum ditetapkan, sehingga regulasi yang lahir mencerminkan aspirasi masyarakat.',
         'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['no'=>'03','title'=>'Mewujudkan Transparansi Tata Kelola Desa',
         'desc'=>'Mendorong pemerintah Desa Tontonunu untuk menerapkan prinsip open government dalam pengelolaan regulasi, sehingga setiap peraturan yang ditetapkan dapat dipertanggungjawabkan kepada publik secara transparan.',
         'icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
        ['no'=>'04','title'=>'Meningkatkan Kesadaran Hukum Masyarakat',
         'desc'=>'Membangun budaya sadar hukum di masyarakat desa melalui penyediaan informasi hukum yang mudah dipahami, serta edukasi tentang hak dan kewajiban warga dalam sistem pemerintahan desa.',
         'icon'=>'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
        ['no'=>'05','title'=>'Mengembangkan Model Desa Digital',
         'desc'=>'Menghasilkan model pengelolaan hukum desa berbasis teknologi yang dapat didokumentasikan, dipublikasikan, dan direplikasi oleh desa-desa lain di Kabupaten Bombana maupun daerah lainnya di Indonesia.',
         'icon'=>'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18'],
        ['no'=>'06','title'=>'Penguatan Kapasitas Perangkat Desa',
         'desc'=>'Meningkatkan kemampuan perangkat Desa Tontonunu dalam pengelolaan dan dokumentasi produk hukum desa secara digital, sehingga keberlanjutan program dapat terjaga setelah masa pengabdian berakhir.',
         'icon'=>'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
      ] as $i => $t)
      <div class="aos {{ $i % 2 === 1 ? 'aos-delay-1' : '' }} bg-white rounded-2xl border border-gray-100 shadow-sm p-6 card-hover flex gap-5">
        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary-600 flex items-center justify-center shadow">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $t['icon'] }}"/>
          </svg>
        </div>
        <div>
          <div class="text-xs font-bold text-primary-500 mb-1">Tujuan {{ $t['no'] }}</div>
          <h3 class="font-display font-bold text-gray-800 mb-2 text-base leading-tight">{{ $t['title'] }}</h3>
          <p class="text-sm text-gray-500 leading-relaxed">{{ $t['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


{{-- ══════════ DASAR PROGRAM ══════════ --}}
<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 gap-14 items-start">
      <div class="aos">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600">03 · Dasar Program</span>
        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 mt-3 mb-6 leading-tight">Landasan Hukum &amp; Regulasi</h2>
        <p class="text-gray-500 leading-relaxed mb-8">Program ini dilaksanakan berdasarkan kerangka regulasi yang kuat, mencakup peraturan perundang-undangan tentang desa, pendidikan tinggi, dan pengelolaan pemerintahan desa.</p>
        <div class="space-y-4">
          @foreach([
            ['no'=>'UU No. 6 Tahun 2014','title'=>'Undang-Undang tentang Desa',
             'desc'=>'Dasar hukum penyelenggaraan pemerintahan desa, kewenangan desa, serta hak warga dalam mengakses informasi pemerintahan desa.'],
            ['no'=>'PP No. 43 Tahun 2014','title'=>'Peraturan Pelaksanaan UU Desa',
             'desc'=>'Mengatur tata cara pembentukan peraturan desa, pengelolaan aset desa, dan keterlibatan masyarakat dalam musyawarah desa.'],
            ['no'=>'Permendikbudristek No. 53 Tahun 2023','title'=>'Standar Pendidikan Tinggi',
             'desc'=>'Mengatur kewajiban perguruan tinggi dalam melaksanakan tri dharma, termasuk pengabdian kepada masyarakat.'],
            ['no'=>'Pedoman PKM Kemendiktisaintek 2026','title'=>'Program Pengabdian Kepada Masyarakat',
             'desc'=>'Skema pendanaan dan pelaksanaan pengabdian berbasis kebutuhan masyarakat yang diselenggarakan Kemendiktisaintek TA 2026.'],
            ['no'=>'Perda Kabupaten Bombana','title'=>'Regulasi Tata Kelola Desa Kabupaten Bombana',
             'desc'=>'Peraturan daerah Kabupaten Bombana yang mengatur tata kelola pemerintahan desa dan kewenangan pembentukan produk hukum desa.'],
          ] as $d)
          <div class="flex gap-4 p-4 rounded-xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50/30 transition-all">
            <div class="flex-shrink-0 w-1.5 rounded-full bg-primary-500 self-stretch"></div>
            <div>
              <div class="text-xs font-bold text-primary-600 mb-0.5">{{ $d['no'] }}</div>
              <div class="font-semibold text-gray-800 text-sm mb-1">{{ $d['title'] }}</div>
              <div class="text-xs text-gray-500 leading-relaxed">{{ $d['desc'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="aos aos-delay-2">
        <div class="bg-primary-700 rounded-3xl p-8 text-white shadow-xl">
          <div class="text-xs font-bold uppercase tracking-widest text-primary-300 mb-4">Identitas Program</div>
          <div class="space-y-5">
            @foreach([
              ['lbl'=>'Nama Program',      'val'=>'Pengabdian Kepada Masyarakat (PKM)'],
              ['lbl'=>'Skema',             'val'=>'Reguler – Berbasis Kebutuhan Masyarakat'],
              ['lbl'=>'Sumber Dana',       'val'=>'Kemendiktisaintek TA 2026'],
              ['lbl'=>'Pelaksana',         'val'=>'Fakultas Hukum Universitas Muhammadiyah Kendari'],
              ['lbl'=>'Mitra',             'val'=>'Pemerintah Desa Tontonunu, Kecamatan Tontonunu, Kabupaten Bombana'],
              ['lbl'=>'Lokasi Kegiatan',   'val'=>'Desa Tontonunu, Kab. Bombana, Sulawesi Tenggara'],
              ['lbl'=>'Tahun Pelaksanaan', 'val'=>'2026'],
            ] as $item)
            <div class="flex flex-col gap-0.5 pb-4 border-b border-white/10 last:border-0 last:pb-0">
              <span class="text-xs text-primary-300 font-medium">{{ $item['lbl'] }}</span>
              <span class="text-sm font-semibold text-white leading-snug">{{ $item['val'] }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ══════════ MANFAAT ══════════ --}}
<section class="py-20 bg-gray-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 aos">
      <span class="text-xs font-bold uppercase tracking-widest text-primary-600">04 · Manfaat Program</span>
      <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 mt-3 mb-4">Siapa yang Mendapatkan Manfaat?</h2>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
      @foreach([
        ['pihak'=>'Warga Desa','color'=>'from-primary-500 to-primary-700',
         'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
         'manfaat'=>['Akses mudah ke seluruh peraturan desa','Bisa berpartisipasi dalam penyusunan perdes','Pemahaman hak dan kewajiban sebagai warga','Transparansi pengelolaan desa']],
        ['pihak'=>'Perangkat Desa','color'=>'from-teal-500 to-teal-700',
         'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
         'manfaat'=>['Sistem dokumentasi peraturan yang terstruktur','Alat bantu penyusunan perdes berbasis AI','Pemantauan partisipasi warga secara digital','Peningkatan kapasitas SDM perangkat desa']],
        ['pihak'=>'Akademisi','color'=>'from-amber-500 to-amber-700',
         'icon'=>'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
         'manfaat'=>['Wahana riset hukum desa berbasis data nyata','Model transfer pengetahuan yang terukur','Publikasi ilmiah dan luaran pengabdian','Penguatan kerjasama perguruan tinggi–desa']],
        ['pihak'=>'Pemerintah Daerah','color'=>'from-rose-500 to-rose-700',
         'icon'=>'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z',
         'manfaat'=>['Model desa digital yang dapat direplikasi','Data akurasi perdes Kabupaten Bombana','Peningkatan indeks tata kelola desa','Dukungan pada program Smart Village nasional']],
      ] as $i => $b)
      <div class="aos aos-delay-{{ $i }} bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover">
        <div class="bg-gradient-to-br {{ $b['color'] }} p-6 text-white">
          <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $b['icon'] }}"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-lg">{{ $b['pihak'] }}</h3>
        </div>
        <div class="p-5">
          <ul class="space-y-2">
            @foreach($b['manfaat'] as $m)
            <li class="flex items-start gap-2 text-sm text-gray-600">
              <svg class="w-4 h-4 text-primary-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
              {{ $m }}
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


{{-- ══════════ SASARAN & RUANG LINGKUP ══════════ --}}
<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 gap-14">
      <div class="aos">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600">05 · Sasaran Program</span>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-800 mt-3 mb-8">Kelompok Sasaran</h2>
        <div class="space-y-4">
          @foreach([
            ['nama'=>'Warga Desa Tontonunu','sub'=>'Kecamatan Tontonunu, Kabupaten Bombana',
             'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['nama'=>'Perangkat Desa Tontonunu','sub'=>'Kepala Desa, Sekretaris, dan Kaur/Kasi',
             'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['nama'=>'BPD Desa Tontonunu','sub'=>'Badan Permusyawaratan Desa selaku mitra legislatif desa',
             'icon'=>'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
            ['nama'=>'Pemerintah Kabupaten Bombana','sub'=>'DPMD dan instansi terkait sebagai pemangku kepentingan regional',
             'icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
          ] as $s)
          <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50/20 transition-all">
            <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-gray-800 text-sm">{{ $s['nama'] }}</div>
              <div class="text-xs text-gray-500 mt-0.5">{{ $s['sub'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="aos aos-delay-2">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600">06 · Ruang Lingkup</span>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-800 mt-3 mb-8">Tahapan Kegiatan</h2>
        <div class="space-y-5">
          @foreach([
            ['fase'=>'Fase 1','judul'=>'Analisis Kebutuhan & Perancangan',
             'isi'=>'Pemetaan kebutuhan hukum desa, inventarisasi peraturan yang berlaku, perancangan arsitektur sistem, dan penyusunan kerangka konten portal.'],
            ['fase'=>'Fase 2','judul'=>'Pembangunan Portal SADAR HUKUM',
             'isi'=>'Pengembangan aplikasi web berbasis Laravel, fitur manajemen perdes, sistem voting partisipatif, dan integrasi AI untuk penyusunan draf regulasi.'],
            ['fase'=>'Fase 3','judul'=>'Pelatihan & Pendampingan',
             'isi'=>'Pelatihan operator desa, sosialisasi portal kepada warga, workshop literasi digital hukum desa, serta pendampingan pengisian konten awal.'],
            ['fase'=>'Fase 4','judul'=>'Evaluasi & Publikasi',
             'isi'=>'Evaluasi dampak program, pengukuran tingkat adopsi, dokumentasi hasil sebagai luaran ilmiah, dan penyerahan sistem secara resmi kepada pemerintah desa.'],
          ] as $i => $f)
          <div class="flex gap-4">
            <div class="flex flex-col items-center">
              <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">{{ $i + 1 }}</div>
              @if($i < 3)<div class="w-0.5 flex-1 bg-primary-200 mt-2"></div>@endif
            </div>
            <div class="pb-5">
              <div class="text-xs font-bold text-primary-500 mb-0.5">{{ $f['fase'] }}</div>
              <div class="font-semibold text-gray-800 text-sm mb-1">{{ $f['judul'] }}</div>
              <div class="text-xs text-gray-500 leading-relaxed">{{ $f['isi'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ══════════ TIM PELAKSANA ══════════ --}}
<section class="py-20 bg-primary-700">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14 aos">
      <span class="text-xs font-bold uppercase tracking-widest text-primary-300">07 · Tim Pelaksana</span>
      <h2 class="font-display text-3xl md:text-4xl font-bold text-white mt-3 mb-2">Tim Pengabdian</h2>
      <p class="text-primary-200 text-sm">Fakultas Hukum Universitas Muhammadiyah Kendari</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="aos aos-delay-1 flex flex-col items-center text-center p-8 bg-white/10 backdrop-blur border-2 border-yellow-400/60 rounded-2xl">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-400 to-amber-600 flex items-center justify-center shadow-lg mb-5">
          <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 mb-4 text-xs font-bold bg-yellow-400 text-gray-900 rounded-full">★ Ketua Tim Pelaksana</span>
        <h3 class="font-display font-bold text-lg text-white mb-2">Dr. Ahmad Fauzi, S.H., M.H.</h3>
        <p class="text-sm text-primary-200 leading-relaxed">Dosen Tetap Fakultas Hukum<br/>Universitas Muhammadiyah Kendari</p>
      </div>
      <div class="aos aos-delay-2 flex flex-col items-center text-center p-8 bg-white/10 backdrop-blur border border-white/20 rounded-2xl">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-300 to-primary-500 flex items-center justify-center shadow-lg mb-5">
          <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 mb-4 text-xs font-bold bg-white/20 text-white rounded-full">Anggota Tim Pelaksana</span>
        <h3 class="font-display font-bold text-lg text-white mb-2">Nur Hasanah, S.H., M.H.</h3>
        <p class="text-sm text-primary-200 leading-relaxed">Dosen Tetap Fakultas Hukum<br/>Universitas Muhammadiyah Kendari</p>
      </div>
      <div class="aos aos-delay-3 flex flex-col items-center text-center p-8 bg-white/10 backdrop-blur border border-white/20 rounded-2xl">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center shadow-lg mb-5">
          <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 mb-4 text-xs font-bold bg-white/20 text-white rounded-full">Anggota Tim Pelaksana</span>
        <h3 class="font-display font-bold text-lg text-white mb-2">Rizky Pratama, S.H., M.Hum.</h3>
        <p class="text-sm text-primary-200 leading-relaxed">Dosen Tetap Fakultas Hukum<br/>Universitas Muhammadiyah Kendari</p>
      </div>
    </div>
  </div>
</section>


{{-- ══════════ CTA ══════════ --}}
<section class="py-20 bg-gray-50 border-t border-gray-100">
  <div class="max-w-3xl mx-auto px-4 text-center aos">
    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-primary-600 flex items-center justify-center shadow-lg">
      <svg class="w-8 h-8 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
      </svg>
    </div>
    <h2 class="font-display text-3xl font-bold text-gray-800 mb-4">Bergabung Bersama Kami</h2>
    <p class="text-gray-500 leading-relaxed mb-8">Daftarkan diri Anda sebagai warga Desa Tontonunu dan ikut berpartisipasi dalam mewujudkan desa yang sadar hukum, transparan, dan demokratis.</p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <a href="{{ route('register') }}"
         class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all hover:shadow-lg">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Daftar Sebagai Warga
      </a>
      <a href="{{ url('/') }}"
         class="inline-flex items-center justify-center gap-2 px-7 py-3.5 border border-primary-300 text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Kembali ke Beranda
      </a>
    </div>
  </div>
</section>

@endsection
