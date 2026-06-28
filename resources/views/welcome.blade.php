@php
use App\Models\Halaman;
use App\Models\Pengumuman;
use App\Models\Perdes;
use App\Models\Setting;
use App\Models\StrukturDesa;

$themeColor = Setting::get('theme_color', 'hijau');
$themeMode  = Setting::get('theme_mode', 'light');
$isDark     = $themeMode === 'dark';

// Tentang & Kontak
$aboutDesc1      = Setting::get('about_desc1', 'Desa Tontonunu adalah salah satu desa yang terletak di Kabupaten Bombana, Provinsi Sulawesi Tenggara. Portal SADAR HUKUM hadir sebagai wujud komitmen Pemerintah Desa Tontonunu dalam mewujudkan tata kelola desa yang transparan, akuntabel, dan partisipatif.');
$aboutDesc2      = Setting::get('about_desc2', 'Melalui platform ini, seluruh warga dapat mengakses, memahami, dan berpartisipasi dalam proses hukum desa secara mudah dan terbuka. Karena hukum adalah milik semua.');
$aboutStat1Val   = Setting::get('about_stat1_value', '2024');
$aboutStat1Lbl   = Setting::get('about_stat1_label', 'Portal diluncurkan');
$aboutStat2Val   = Setting::get('about_stat2_value', '100%');
$aboutStat2Lbl   = Setting::get('about_stat2_label', 'Akses publik gratis');
$statPenduduk    = Setting::get('desa_stat_penduduk', '2847');
$statKk          = Setting::get('desa_stat_kk', '724');
$statPeraturan   = Setting::get('desa_stat_peraturan', '24');
$statDusun       = Setting::get('desa_stat_dusun', '6');
$contactAddress  = Setting::get('contact_address', 'Jl. Poros Tontonunu No. 01, Kab. Bombana, Sulawesi Tenggara');
$contactPhone    = Setting::get('contact_phone', '+62 401 – XXXXXXX');
$contactHours    = Setting::get('contact_hours', 'Senin–Jumat, 08.00–15.00');
$contactEmail    = Setting::get('contact_email', 'desa.tontonunu@gmail.com');

$struktur       = StrukturDesa::all()->keyBy('jabatan');
$halamans       = Halaman::where('is_published', true)->orderBy('urutan')->orderBy('created_at')->get();
$perdesList     = Perdes::where('status', 'selesai')->latest()->get();
$pengumumanList = Pengumuman::published()->where('tipe', 'pengumuman')->limit(5)->get();
$beritaList     = Pengumuman::published()->where('tipe', 'berita')->limit(3)->get();

// Header
$headerType   = Setting::get('header_type', 'default');
$headerImage  = Setting::get('header_image');
$headerVideo  = Setting::get('header_video');
$headerPoster = Setting::get('header_video_poster');
$headerSlides = json_decode(Setting::get('header_slideshow', '[]'), true) ?? [];

$palettes = [
    'hijau'  => ['50'=>'#f0faf4','100'=>'#d9f2e3','200'=>'#b3e4c8','300'=>'#7dcca6','400'=>'#45ad7e','500'=>'#1f8f60','600'=>'#13734b','700'=>'#0f5c3c','800'=>'#0c4830','900'=>'#093826'],
    'langit' => ['50'=>'#ebf5fb','100'=>'#cfe8f7','200'=>'#9fd2ef','300'=>'#6fbce7','400'=>'#3fa6df','500'=>'#2b8fc8','600'=>'#2272a3','700'=>'#1a577e','800'=>'#123d59','900'=>'#0a2235'],
    'biru'   => ['50'=>'#eff6ff','100'=>'#dbeafe','200'=>'#bfdbfe','300'=>'#93c5fd','400'=>'#60a5fa','500'=>'#3b82f6','600'=>'#2563eb','700'=>'#1d4ed8','800'=>'#1e40af','900'=>'#1e3a8a'],
    'ungu'   => ['50'=>'#f5f3ff','100'=>'#ede9fe','200'=>'#ddd6fe','300'=>'#c4b5fd','400'=>'#a78bfa','500'=>'#8b5cf6','600'=>'#7c3aed','700'=>'#6d28d9','800'=>'#5b21b6','900'=>'#4c1d95'],
    'merah'  => ['50'=>'#fef2f2','100'=>'#fee2e2','200'=>'#fecaca','300'=>'#fca5a5','400'=>'#f87171','500'=>'#ef4444','600'=>'#dc2626','700'=>'#b91c1c','800'=>'#991b1b','900'=>'#7f1d1d'],
    'emas'   => ['50'=>'#fffbeb','100'=>'#fef3c7','200'=>'#fde68a','300'=>'#fcd34d','400'=>'#fbbf24','500'=>'#f59e0b','600'=>'#d97706','700'=>'#b45309','800'=>'#92400e','900'=>'#78350f'],
];
$p = $palettes[$themeColor] ?? $palettes['hijau'];
@endphp
<!DOCTYPE html>
<html lang="id" class="{{ $isDark ? 'dark' : '' }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SADAR HUKUM – Desa Tontonunu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            display: ['Playfair Display', 'serif'],
            body: ['Plus Jakarta Sans', 'sans-serif'],
          },
          colors: {
            primary: {!! json_encode($p) !!},
            emas: {
              50:  '#fffbeb',
              100: '#fef3c7',
              300: '#fde68a',
              400: '#fbbf24',
              500: '#f59e0b',
              600: '#d97706',
              700: '#b45309',
            }
          },
          animation: {
            'fade-up':     'fadeUp 0.6s ease forwards',
            'fade-in':     'fadeIn 0.5s ease forwards',
            'slide-right': 'slideRight 0.5s ease forwards',
          },
          keyframes: {
            fadeUp:      { '0%': { opacity: '0', transform: 'translateY(24px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
            fadeIn:      { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
            slideRight:  { '0%': { opacity: '0', transform: 'translateX(-20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
          }
        }
      }
    }
  </script>
  <style>
    :root {
      --p-50:  {{ $p['50'] }};
      --p-100: {{ $p['100'] }};
      --p-200: {{ $p['200'] }};
      --p-300: {{ $p['300'] }};
      --p-400: {{ $p['400'] }};
      --p-500: {{ $p['500'] }};
      --p-600: {{ $p['600'] }};
      --p-700: {{ $p['700'] }};
      --p-800: {{ $p['800'] }};
      --p-900: {{ $p['900'] }};
    }

    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-display { font-family: 'Playfair Display', serif; }

    .batik-bg {
      background-color: var(--p-700);
      background-image:
        radial-gradient(circle at 20% 30%, rgba(251,191,36,0.12) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .card-hover { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }

    /* nav item hover */
    .nav-item {
      padding: 0.25rem 0.625rem;
      border-radius: 0.5rem;
      transition: background 0.2s ease, color 0.2s ease;
    }
    #mainNav.nav-is-transparent .nav-item:hover {
      background: rgba(255,255,255,0.15);
      color: #ffffff !important;
    }
    #mainNav:not(.nav-is-transparent) .nav-item:hover {
      background: var(--p-50);
      color: var(--p-700);
    }

    .badge-glow { box-shadow: 0 0 16px rgba(251,191,36,0.4); }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--p-50); }
    ::-webkit-scrollbar-thumb { background: var(--p-600); border-radius: 3px; }

    .aos { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .aos.visible { opacity: 1; transform: translateY(0); }
    .aos-delay-1 { transition-delay: 0.1s; }
    .aos-delay-2 { transition-delay: 0.2s; }
    .aos-delay-3 { transition-delay: 0.3s; }
    .aos-delay-4 { transition-delay: 0.4s; }

    #mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
    #mobile-menu.open { max-height: 400px; }

    .tab-btn.active { background: var(--p-600); color: white; }
    .search-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(251,191,36,0.3); }
  </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-200">

<!-- ═══════════════════════════════════════════ NAVBAR -->
@php $navOverlay = in_array($headerType, ['image','slideshow','video']); @endphp

<nav id="mainNav"
     class="w-full z-50 top-0 transition-all duration-300 {{ $navOverlay ? 'fixed' : 'sticky bg-white/95 dark:bg-gray-900/95 backdrop-blur border-b border-primary-100 dark:border-gray-800 shadow-sm' }}">

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">

      {{-- Logo --}}
      <div class="flex items-center gap-3">
        <div id="navLogoBox" class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md transition-colors bg-primary-600">
          <svg class="w-6 h-6 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
          </svg>
        </div>
        <div>
          <div id="navBrandTitle" class="font-display font-bold text-base leading-tight transition-colors text-primary-700 dark:text-primary-300">SADAR HUKUM</div>
          <div id="navBrandSub"   class="text-xs leading-tight transition-colors text-gray-500 dark:text-gray-400">Desa Tontonunu</div>
        </div>
      </div>

      {{-- Menu desktop --}}
      <div class="hidden md:flex items-center gap-1 text-sm font-medium text-gray-600 dark:text-gray-300">
        <a href="#beranda"   class="nav-item hover:text-primary-700 transition-colors">Beranda</a>
        <a href="{{ url('/tentang-program') }}" class="nav-item hover:text-primary-700 transition-colors">Tentang Program</a>
        <a href="{{ url('/panduan') }}"         class="nav-item hover:text-primary-700 transition-colors">Panduan</a>
        <a href="#peraturan" class="nav-item hover:text-primary-700 transition-colors">Peraturan Desa</a>
        <a href="#statistik" class="nav-item hover:text-primary-700 transition-colors">Statistik</a>
        <a href="#kontak"    class="nav-item hover:text-primary-700 transition-colors">Kontak</a>
      </div>

      {{-- CTA desktop --}}
      <div class="hidden md:flex items-center gap-3">
        <a href="{{ route('login') }}" id="navMasukBtn"
           class="px-4 py-2 text-sm font-semibold rounded-lg transition-all text-primary-700 dark:text-primary-300 border border-primary-300 dark:border-primary-700 hover:bg-primary-50">
          Masuk
        </a>
        <a href="{{ route('register') }}"
           class="px-4 py-2 text-sm font-semibold text-hijau-900 bg-emas-400 hover:bg-emas-300 rounded-lg transition-all hover:scale-105 shadow-sm">
          Daftar
        </a>
      </div>

      {{-- Hamburger --}}
      <button id="navHamBtn" onclick="toggleMobileNav()" class="md:hidden p-2 rounded-lg transition-colors text-primary-700 dark:text-primary-300">
        <svg id="navHamIcon"   class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <svg id="navCloseIcon" class="w-6 h-6" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
  </div>

  {{-- Menu mobile --}}
  <div id="navMobileMenu" style="display:none"
       class="md:hidden border-t border-primary-100 bg-white/95 dark:bg-gray-900/95 backdrop-blur">
    <div class="px-4 py-4 flex flex-col gap-1 text-sm font-medium text-gray-600 dark:text-gray-300">
      <a href="#beranda"   onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Beranda</a>
      <a href="{{ url('/tentang-program') }}" onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Tentang Program</a>
      <a href="{{ url('/panduan') }}"         onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Panduan</a>
      <a href="#peraturan" onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Peraturan Desa</a>
      <a href="#statistik" onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Statistik</a>
      <a href="#kontak"    onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Kontak</a>
      <div class="flex gap-2 pt-3 mt-1 border-t border-gray-100 dark:border-gray-800">
        <a href="{{ route('login') }}"    class="flex-1 py-2.5 text-sm font-semibold text-center text-primary-700 border border-primary-300 rounded-xl">Masuk</a>
        <a href="{{ route('register') }}" class="flex-1 py-2.5 text-sm font-semibold text-center text-gray-900 bg-emas-400 rounded-xl">Daftar</a>
      </div>
    </div>
  </div>
</nav>


<!-- ═══════════════════════════════════════════ HERO -->
@if($headerType === 'slideshow' && count($headerSlides) >= 1)
{{-- ── SLIDESHOW ── --}}
@php $totalSlides = count($headerSlides); @endphp
<section id="beranda" style="position:relative;overflow:hidden;height:100vh;min-height:100vh;display:flex;flex-direction:column;justify-content:center;">

  {{-- Slide images — PHP render statis, JS kontrol opacity --}}
  @foreach($headerSlides as $idx => $slide)
  <div class="hero-slide"
       style="position:absolute;top:0;left:0;right:0;bottom:0;width:100%;height:100%;
              opacity:{{ $idx === 0 ? '1' : '0' }};transition:opacity 1s ease;">
    <img src="{{ asset('storage/'.$slide) }}"
         style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;"
         alt="Slide {{ $idx + 1 }}"/>
  </div>
  @endforeach

  {{-- Overlay gelap --}}
  <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(15,92,60,0.60);z-index:1;pointer-events:none;"></div>

  {{-- Dots navigasi --}}
  @if($totalSlides > 1)
  <div style="position:absolute;bottom:4rem;left:50%;transform:translateX(-50%);display:flex;gap:0.5rem;z-index:3;">
    @foreach($headerSlides as $idx => $slide)
    <button class="slide-dot" onclick="goToSlide({{ $idx }})"
            style="height:0.5rem;border-radius:9999px;border:none;cursor:pointer;transition:all 0.3s;
                   {{ $idx === 0 ? 'width:1.25rem;background:#fbbf24;' : 'width:0.5rem;background:rgba(255,255,255,0.4);' }}"></button>
    @endforeach
  </div>
  @endif

  @include('partials.hero-content', ['isDark' => $isDark, 'headerType' => $headerType])
</section>

@elseif($headerType === 'video' && $headerVideo)
{{-- ── VIDEO BACKGROUND ── --}}
<section id="beranda" class="relative overflow-hidden min-h-screen">
  <video autoplay muted loop playsinline
         class="absolute inset-0 w-full h-full object-cover z-0"
         @if($headerPoster) poster="{{ asset('storage/'.$headerPoster) }}" @endif>
    <source src="{{ asset('storage/'.$headerVideo) }}" type="video/mp4"/>
  </video>
  <div class="absolute inset-0 bg-hijau-900/65 z-10"></div>
  @include('partials.hero-content', ['isDark' => $isDark, 'headerType' => $headerType])
</section>

@elseif($headerType === 'image' && $headerImage)
{{-- ── GAMBAR BIASA ── --}}
<section id="beranda" class="relative overflow-hidden min-h-[560px] md:min-h-[640px]">
  <img src="{{ asset('storage/'.$headerImage) }}" class="absolute inset-0 w-full h-full object-cover z-0"/>
  <div class="absolute inset-0 bg-hijau-900/65 z-10"></div>
  @include('partials.hero-content', ['isDark' => $isDark, 'headerType' => $headerType])
</section>

@else
{{-- ── DEFAULT BATIK ── --}}
<section id="beranda" class="batik-bg relative overflow-hidden">
  <div class="absolute top-0 right-0 w-96 h-96 bg-emas-400/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl pointer-events-none"></div>
  <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/3 blur-3xl pointer-events-none"></div>
  @include('partials.hero-content', ['isDark' => $isDark, 'headerType' => $headerType])
</section>
@endif


<!-- ═══════════════════════════════════════════ KATEGORI PERATURAN -->
<section class="py-14 bg-gray-50 dark:bg-gray-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10 aos">
      <span class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">Kategori</span>
      <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mt-2">Jenis Peraturan Desa</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="aos aos-delay-1 group cursor-pointer">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center border border-primary-100 dark:border-gray-700 card-hover shadow-sm group-hover:border-primary-300 dark:group-hover:border-primary-700">
          <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center group-hover:bg-primary-100 dark:group-hover:bg-primary-900/50 transition-colors">
            <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          </div>
          <div class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Pemerintahan</div>
          <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">8 peraturan</div>
        </div>
      </div>
      <div class="aos aos-delay-2 group cursor-pointer">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center border border-primary-100 dark:border-gray-700 card-hover shadow-sm group-hover:border-primary-300 dark:group-hover:border-primary-700">
          <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-emas-50 dark:bg-emas-900/20 flex items-center justify-center group-hover:bg-emas-100 transition-colors">
            <svg class="w-7 h-7 text-emas-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Keuangan Desa</div>
          <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">6 peraturan</div>
        </div>
      </div>
      <div class="aos aos-delay-3 group cursor-pointer">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center border border-primary-100 dark:border-gray-700 card-hover shadow-sm group-hover:border-primary-300 dark:group-hover:border-primary-700">
          <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
            <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <div class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Kemasyarakatan</div>
          <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">5 peraturan</div>
        </div>
      </div>
      <div class="aos aos-delay-4 group cursor-pointer">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center border border-primary-100 dark:border-gray-700 card-hover shadow-sm group-hover:border-primary-300 dark:group-hover:border-primary-700">
          <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
            <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h.5A2.5 2.5 0 0020 5.5v-1.5M4 17l-1 1m14-1l1 1M12 20v1"/></svg>
          </div>
          <div class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Lingkungan Hidup</div>
          <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">5 peraturan</div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════ DAFTAR PERATURAN -->
<section id="peraturan" class="py-16 bg-white dark:bg-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
      <div class="aos">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">Dokumen</span>
        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mt-2">Peraturan Desa</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Semua dokumen hukum yang berlaku di Desa Tontonunu</p>
      </div>
      <div class="relative aos">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7 7 0 1110.65 17.65 7 7 0 0116.65 16.65z"/></svg>
        <input type="text" id="searchInput" placeholder="Cari peraturan..." oninput="filterPerdes()"
          class="search-input pl-9 pr-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 rounded-xl w-full md:w-72 focus:border-primary-400 transition-all"/>
      </div>
    </div>

    <div class="flex gap-2 mb-8 overflow-x-auto pb-1">
      <button onclick="filterTab('semua')" class="tab-btn active px-4 py-2 text-sm font-semibold rounded-lg border border-gray-200 dark:border-gray-600 whitespace-nowrap transition-all">Semua</button>
      <button onclick="filterTab('perdes')"   class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg border border-gray-200 dark:border-gray-600 whitespace-nowrap text-gray-600 dark:text-gray-300 hover:border-primary-300 transition-all">Peraturan Desa</button>
      <button onclick="filterTab('perkades')" class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg border border-gray-200 dark:border-gray-600 whitespace-nowrap text-gray-600 dark:text-gray-300 hover:border-primary-300 transition-all">Peraturan Kepala Desa</button>
      <button onclick="filterTab('sk_kades')" class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg border border-gray-200 dark:border-gray-600 whitespace-nowrap text-gray-600 dark:text-gray-300 hover:border-primary-300 transition-all">SK Kepala Desa</button>
    </div>

    <div id="perdesGrid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
      @forelse($perdesList as $pd)
      @php
        $jenisLabel = \App\Models\Perdes::jenisLabel($pd->jenis);
        $jenisBadge = match($pd->jenis) {
          'perdes'   => 'bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-400',
          'perkades' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400',
          'sk_kades' => 'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400',
          default    => 'bg-gray-100 text-gray-600',
        };
        $desc  = mb_strimwidth(strip_tags($pd->isi ?? ''), 0, 160, '...');
        $tgl   = $pd->updated_at ? $pd->updated_at->format('d M Y') : '-';
      @endphp
      <div class="perdes-card bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-5 card-hover shadow-sm"
           data-jenis="{{ $pd->jenis }}"
           data-title="{{ strtolower($pd->judul) }}">
        <div class="flex items-start justify-between mb-4">
          <span class="px-2.5 py-1 text-xs font-semibold rounded-lg {{ $jenisBadge }}">{{ $jenisLabel }}</span>
          <span class="text-xs text-gray-400">{{ $pd->updated_at ? $pd->updated_at->format('Y') : '' }}</span>
        </div>
        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm leading-snug mb-2">{{ $pd->judul }}</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mb-4 line-clamp-2">{{ $desc }}</p>
        <div class="flex items-center justify-between">
          <span class="flex items-center gap-1.5 text-xs text-gray-400">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ $tgl }}
          </span>
          <button onclick="showModal({{ json_encode($pd->judul) }}, {{ json_encode($desc) }}, {{ json_encode($tgl) }})"
                  class="flex items-center gap-1 text-xs font-semibold text-primary-700 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-200 transition-colors">
            Detail <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
      </div>
      @empty
      @endforelse
    </div>

    <div id="emptyState" class="{{ $perdesList->isEmpty() ? '' : 'hidden' }} text-center py-16">
      <svg class="w-16 h-16 mx-auto text-gray-200 dark:text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      <p class="text-gray-400 font-medium">Tidak ada peraturan ditemukan</p>
    </div>

    <div class="text-center mt-10">
      <button class="px-6 py-3 border border-primary-300 dark:border-primary-700 text-primary-700 dark:text-primary-400 font-semibold rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors text-sm">
        Lihat Semua Peraturan →
      </button>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════ STATISTIK -->
<section id="statistik" class="py-16 relative overflow-hidden" style="background-color: var(--p-800);">
  <div class="absolute inset-0 opacity-10" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4z'/%3E%3C/g%3E%3C/svg%3E\");"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center mb-12">
      <span class="text-xs font-bold uppercase tracking-widest text-emas-400">Data Desa</span>
      <h2 class="font-display text-3xl md:text-4xl font-bold text-white mt-2">Tontonunu Dalam Angka</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="text-center aos">
        <div class="text-5xl font-display font-black text-emas-400 mb-2" data-count="{{ preg_replace('/[^0-9]/', '', $statPenduduk) }}">0</div>
        <div class="text-white/70 text-sm">Jumlah Penduduk</div>
      </div>
      <div class="text-center aos aos-delay-1">
        <div class="text-5xl font-display font-black text-emas-400 mb-2" data-count="{{ preg_replace('/[^0-9]/', '', $statKk) }}">0</div>
        <div class="text-white/70 text-sm">Kepala Keluarga</div>
      </div>
      <div class="text-center aos aos-delay-2">
        <div class="text-5xl font-display font-black text-emas-400 mb-2" data-count="{{ preg_replace('/[^0-9]/', '', $statPeraturan) }}">0</div>
        <div class="text-white/70 text-sm">Peraturan Aktif</div>
      </div>
      <div class="text-center aos aos-delay-3">
        <div class="text-5xl font-display font-black text-emas-400 mb-2" data-count="{{ preg_replace('/[^0-9]/', '', $statDusun) }}">0</div>
        <div class="text-white/70 text-sm">Dusun / Wilayah</div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════ TENTANG -->
<section id="tentang" class="py-16 bg-gray-50 dark:bg-gray-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 gap-12 items-center">
      <div class="aos">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">Tentang Kami</span>
        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mt-2 mb-5">Desa Tontonunu,<br/>Kabupaten Bombana</h2>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4 text-sm">{{ $aboutDesc1 }}</p>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6 text-sm">{{ $aboutDesc2 }}</p>
        {{-- <div class="grid grid-cols-2 gap-4">
          <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-primary-100 dark:border-gray-700">
            <div class="text-primary-700 dark:text-primary-400 font-bold text-lg">{{ $aboutStat1Val }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $aboutStat1Lbl }}</div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-primary-100 dark:border-gray-700">
            <div class="text-primary-700 dark:text-primary-400 font-bold text-lg">{{ $aboutStat2Val }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $aboutStat2Lbl }}</div>
          </div>
        </div> --}}
        <a href="{{ route('tentang-program') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">Selengkapnya</a>
      </div>

      {{-- Struktur Organisasi --}}
      <div class="aos aos-delay-2">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
          <div class="px-6 py-4" style="background-color: var(--p-700);">
            <h3 class="font-semibold text-white text-sm">Struktur Pemerintah Desa</h3>
          </div>
          @php
          $struktCfg = [
            'kepala_desa' => ['init'=>'KD','bg'=>'bg-primary-200 dark:bg-primary-800','text'=>'text-primary-800 dark:text-primary-200','badge'=>true],
            'sekretaris'  => ['init'=>'SD','bg'=>'bg-blue-100 dark:bg-blue-900/30','text'=>'text-blue-700 dark:text-blue-400','badge'=>false],
            'bendahara'   => ['init'=>'BD','bg'=>'bg-amber-100 dark:bg-amber-900/30','text'=>'text-amber-700 dark:text-amber-400','badge'=>false],
            'ketua_bpd'   => ['init'=>'BP','bg'=>'bg-purple-100 dark:bg-purple-900/30','text'=>'text-purple-700 dark:text-purple-400','badge'=>false],
          ];
          @endphp
          <div class="p-5 space-y-3">
            @foreach($struktCfg as $jabatan => $cfg)
            @php $member = $struktur->get($jabatan); @endphp
            <div class="flex items-center gap-3 p-3 {{ $jabatan === 'kepala_desa' ? 'bg-primary-50 dark:bg-primary-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50' }} rounded-xl transition-colors">
              {{-- Foto atau inisial --}}
              @if($member?->foto)
                <img src="{{ Storage::url($member->foto) }}"
                     class="w-11 h-11 rounded-full object-cover flex-shrink-0 ring-2 ring-white dark:ring-gray-700 shadow-sm"/>
              @else
                <div class="w-11 h-11 rounded-full {{ $cfg['bg'] }} flex items-center justify-center font-bold {{ $cfg['text'] }} text-sm flex-shrink-0">{{ $cfg['init'] }}</div>
              @endif
              <div class="min-w-0">
                <div class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ \App\Models\StrukturDesa::label($jabatan) }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $member?->nama ?: '–' }}</div>
              </div>
              @if($cfg['badge'])
                <span class="ml-auto flex-shrink-0 px-2 py-0.5 bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-400 text-xs rounded-full font-medium">Aktif</span>
              @endif
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════ PENGUMUMAN -->
<section class="py-16 bg-white dark:bg-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
      <div class="aos">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">Terbaru</span>
        <h2 class="font-display text-3xl font-bold text-gray-800 dark:text-white mt-2">Pengumuman Desa</h2>
      </div>
    </div>
    @if($pengumumanList->isEmpty())
    <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-8">Belum ada pengumuman yang dipublikasikan.</p>
    @else
    <div class="space-y-4">
      @foreach($pengumumanList as $i => $pum)
      @php
        $delayClass = $i > 0 ? "aos-delay-{$i}" : '';
        $kat = $pum->kategori ?: 'Info';
      @endphp
      <div class="aos {{ $delayClass }} flex gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary-200 dark:hover:border-primary-700 transition-all card-hover cursor-pointer">
        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center">
          <svg class="w-6 h-6 text-primary-700 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex flex-wrap items-center gap-2 mb-1">
            <span class="text-xs font-semibold text-primary-700 dark:text-primary-400 bg-primary-100 dark:bg-primary-900/40 px-2 py-0.5 rounded-full">{{ $kat }}</span>
            <span class="text-xs text-gray-400">{{ $pum->tanggal_publikasi ? \Carbon\Carbon::parse($pum->tanggal_publikasi)->format('d M Y') : '' }}</span>
          </div>
          <h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm truncate">{{ $pum->judul }}</h4>
          @if($pum->ringkasan)
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">{{ $pum->ringkasan }}</p>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>


<!-- ═══════════════════════════════════════════ BERITA -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
      <div class="aos">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">Informasi</span>
        <h2 class="font-display text-3xl font-bold text-gray-800 dark:text-white mt-2">Berita Desa</h2>
      </div>
      @if($beritaList->isNotEmpty())
      <a href="{{ url('/berita') }}" class="text-sm font-semibold text-primary-700 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-200 transition-colors">Lihat semua →</a>
      @endif
    </div>
    @if($beritaList->isEmpty())
    <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-8">Belum ada berita yang dipublikasikan.</p>
    @else
    <div class="grid md:grid-cols-3 gap-6">
      @foreach($beritaList as $i => $brt)
      @php $delayClass = $i > 0 ? "aos-delay-{$i}" : ''; @endphp
      <a href="{{ route('berita.show', $brt->slug) }}" class="aos {{ $delayClass }} group block bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm card-hover overflow-hidden">
        @if($brt->gambar)
        <div class="h-48 overflow-hidden">
          <img src="{{ asset('storage/'.$brt->gambar) }}" alt="{{ $brt->judul }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
        </div>
        @else
        <div class="h-48 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/40 dark:to-primary-800/40 flex items-center justify-center">
          <svg class="w-16 h-16 text-primary-300 dark:text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        </div>
        @endif
        <div class="p-5">
          @if($brt->kategori)
          <span class="text-xs font-semibold text-primary-700 dark:text-primary-400 bg-primary-100 dark:bg-primary-900/40 px-2.5 py-1 rounded-full">{{ $brt->kategori }}</span>
          @endif
          <h3 class="font-semibold text-gray-800 dark:text-gray-100 mt-3 mb-2 leading-snug group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors line-clamp-2">{{ $brt->judul }}</h3>
          @if($brt->ringkasan)
          <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2 mb-3">{{ $brt->ringkasan }}</p>
          @endif
          <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">{{ $brt->tanggal_publikasi ? \Carbon\Carbon::parse($brt->tanggal_publikasi)->format('d M Y') : '' }}</span>
            <span class="text-xs font-semibold text-primary-700 dark:text-primary-400 group-hover:underline">Baca selengkapnya →</span>
          </div>
        </div>
      </a>
      @endforeach
    </div>
    @endif
  </div>
</section>


<!-- ═══════════════════════════════════════════ KERJASAMA -->
<section class="py-14 bg-white dark:bg-gray-800">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-3"
            style="background-color:var(--p-100);color:var(--p-700);">Mitra & Dukungan</span>
      <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white font-display">Kerjasama</h2>
      <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm">Didukung oleh institusi dan pemerintah daerah</p>
    </div>
    <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
      <div class="flex flex-col items-center gap-2">
        <img src="{{ asset('kerjasama/dikti.png') }}" alt="Kemendiktisaintek" class="h-16 md:h-20 object-contain"/>
        <span class="text-xs text-gray-400 text-center">Kemendiktisaintek</span>
      </div>
      <div class="flex flex-col items-center gap-2">
        <img src="{{ asset('kerjasama/umk.png') }}" alt="Universitas Muhammadiyah Kendari" class="h-16 md:h-20 object-contain"/>
        <span class="text-xs text-gray-400 text-center">Univ. Muhammadiyah Kendari</span>
      </div>
      <div class="flex flex-col items-center gap-2">
        <img src="{{ asset('kerjasama/bombana.png') }}" alt="Kabupaten Bombana" class="h-16 md:h-20 object-contain"/>
        <span class="text-xs text-gray-400 text-center">Kab. Bombana</span>
      </div>
      <div class="flex flex-col items-center gap-2">
        <img src="{{ asset('kerjasama/bima.png') }}" alt="Kabupaten Bima" class="h-16 md:h-20 object-contain"/>
        <span class="text-xs text-gray-400 text-center">Kab. Bima</span>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ HALAMAN STATIS -->
@foreach($halamans as $idx => $hal)
@php $reverse = $idx % 2 !== 0; @endphp
<section id="{{ $hal->slug }}" class="py-14 {{ $reverse ? 'bg-gray-50 dark:bg-gray-900' : 'bg-white dark:bg-gray-950' }}">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col {{ $reverse ? 'lg:flex-row-reverse' : 'lg:flex-row' }} gap-10 items-center">

      {{-- Foto --}}
      @if($hal->foto)
        <div class="w-full lg:w-2/5 flex-shrink-0 aos">
          <div class="rounded-2xl overflow-hidden shadow-md">
            <img src="{{ asset('storage/'.$hal->foto) }}"
                 alt="{{ $hal->judul }}"
                 class="w-full h-64 lg:h-80 object-cover"/>
          </div>
        </div>
      @endif

      {{-- Konten --}}
      <div class="flex-1 aos {{ $hal->foto ? '' : 'max-w-3xl mx-auto' }}">
        <span class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">
          {{ $hal->judul }}
        </span>
        @if($hal->ringkasan)
          <p class="mt-2 text-lg font-semibold text-gray-700 dark:text-gray-300 leading-snug">
            {{ $hal->ringkasan }}
          </p>
        @endif
        <div class="mt-4 prose prose-sm prose-gray dark:prose-invert max-w-none
                    [&_p]:text-gray-600 [&_p]:dark:text-gray-400 [&_p]:leading-relaxed [&_p]:mb-3
                    [&_h2]:font-display [&_h2]:text-gray-800 [&_h2]:dark:text-white [&_h2]:font-bold
                    [&_h3]:font-semibold [&_h3]:text-gray-700 [&_h3]:dark:text-gray-200
                    [&_ul]:space-y-1 [&_li]:text-gray-600 [&_li]:dark:text-gray-400
                    [&_strong]:text-gray-800 [&_strong]:dark:text-white">
          {!! $hal->isi !!}
        </div>
      </div>

    </div>
  </div>
</section>
@endforeach




<!-- ═══════════════════════════════════════════ KONTAK -->
<section id="kontak" class="py-16 bg-gray-50 dark:bg-gray-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 aos">
      <span class="text-xs font-bold uppercase tracking-widest text-primary-600 dark:text-primary-400">Hubungi Kami</span>
      <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mt-2">Kantor Desa Tontonunu</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="aos bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm text-center card-hover">
        <div class="w-12 h-12 mx-auto mb-4 bg-primary-100 dark:bg-primary-900/40 rounded-2xl flex items-center justify-center">
          <svg class="w-6 h-6 text-primary-700 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Alamat</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contactAddress }}</p>
      </div>
      <div class="aos aos-delay-1 bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm text-center card-hover">
        <div class="w-12 h-12 mx-auto mb-4 bg-primary-100 dark:bg-primary-900/40 rounded-2xl flex items-center justify-center">
          <svg class="w-6 h-6 text-primary-700 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        </div>
        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Telepon</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contactPhone }}<br/>{{ $contactHours }}</p>
      </div>
      <div class="aos aos-delay-2 bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm text-center card-hover">
        <div class="w-12 h-12 mx-auto mb-4 bg-primary-100 dark:bg-primary-900/40 rounded-2xl flex items-center justify-center">
          <svg class="w-6 h-6 text-primary-700 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Email</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contactEmail }}<br/>Respon dalam 1×24 jam</p>
      </div>
    </div>

    {{-- Google Maps Embed --}}
    <div class="mt-8 aos rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm" style="height: 360px;">
      <iframe
        src="https://maps.google.com/maps?q=Desa+Tontonunu,+Kabupaten+Bombana,+Sulawesi+Tenggara&output=embed&hl=id"
        width="100%"
        height="360"
        style="border:0; display:block;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Lokasi Kantor Desa Tontonunu">
      </iframe>
    </div>

  </div>
</section>


<!-- ═══════════════════════════════════════════ FOOTER -->
<footer class="bg-primary-800 py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-3 gap-8 mb-8">
      <div>
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow">
            <svg class="w-5 h-5 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
            </svg>
          </div>
          <div>
            <div class="font-display font-bold text-white text-base">SADAR HUKUM</div>
            <div class="text-xs text-primary-300">Desa Tontonunu</div>
          </div>
        </div>
        <p class="text-sm text-primary-300 leading-relaxed">
          Portal transparansi dan informasi peraturan desa untuk warga Tontonunu, Kabupaten Bombana.
        </p>
      </div>
      <div>
        <h4 class="text-xs font-bold uppercase tracking-widest text-primary-400 mb-4">Tautan</h4>
        <ul class="space-y-2 text-sm text-primary-200">
          <li><a href="#beranda"   class="hover:text-white transition-colors">Beranda</a></li>
          <li><a href="{{ url('/tentang-program') }}" class="hover:text-white transition-colors">Tentang Program</a></li>
          <li><a href="{{ url('/panduan') }}"         class="hover:text-white transition-colors">Panduan</a></li>
          <li><a href="#peraturan" class="hover:text-white transition-colors">Peraturan Desa</a></li>
          <li><a href="#statistik" class="hover:text-white transition-colors">Statistik</a></li>
          <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-xs font-bold uppercase tracking-widest text-primary-400 mb-4">Program</h4>
        <p class="text-sm text-primary-300 leading-relaxed">
          PKM Kemendiktisaintek 2026<br/>
          Fakultas Hukum<br/>
          Universitas Muhammadiyah Kendari<br/>
          × Pemdes Tontonunu
        </p>
      </div>
    </div>
    <div class="border-t border-primary-700 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-primary-400">
      <span>© {{ date('Y') }} Pemerintah Desa Tontonunu, Kab. Bombana</span>
      <span>Didukung oleh Kemendiktisaintek RI</span>
    </div>
  </div>
</footer>


<!-- ═══════════════════════════════════════════ MODAL -->
<div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
  <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-6 z-10 animate-fade-up">
    <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <div class="flex items-center gap-3 mb-4">
      <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-primary-700 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      </div>
      <div>
        <div id="modalNomor" class="font-bold text-primary-700 dark:text-primary-400 text-sm"></div>
        <div id="modalTanggal" class="text-xs text-gray-400"></div>
      </div>
    </div>
    <h3 id="modalJudul" class="font-display font-bold text-gray-800 dark:text-white text-lg mb-3 leading-snug"></h3>
    <p id="modalIsi" class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-6"></p>
    <div class="flex gap-3">
      <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-white text-sm font-semibold rounded-xl transition-colors" style="background-color: var(--p-600);" onmouseover="this.style.backgroundColor='var(--p-700)'" onmouseout="this.style.backgroundColor='var(--p-600)'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Unduh PDF
      </button>
      <button onclick="closeModal()" class="flex-1 px-4 py-2.5 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
        Tutup
      </button>
    </div>
  </div>
</div>


<!-- ═══════════════════════════════════════════ SCRIPTS -->
<script>
  /* ── Navbar overlay scroll ── */
  (function() {
    var overlay = {{ $navOverlay ? 'true' : 'false' }};
    var nav     = document.getElementById('mainNav');
    if (!overlay || !nav) return;

    function applyNav() {
      var scrolled = window.scrollY > 10;
      var light    = !scrolled;

      nav.style.background      = scrolled ? 'rgba(255,255,255,0.95)' : 'transparent';
      nav.style.backdropFilter  = scrolled ? 'blur(8px)' : 'none';
      nav.style.webkitBackdropFilter = scrolled ? 'blur(8px)' : 'none';
      nav.style.borderBottom    = scrolled ? '1px solid #d1fae5' : '1px solid transparent';
      nav.style.boxShadow       = scrolled ? '0 1px 6px rgba(0,0,0,0.08)' : 'none';

      if (light) { nav.classList.add('nav-is-transparent'); }
      else       { nav.classList.remove('nav-is-transparent'); }

      var logoBox = document.getElementById('navLogoBox');
      if (logoBox) logoBox.style.background = light ? 'rgba(255,255,255,0.2)' : '';

      var brandTitle = document.getElementById('navBrandTitle');
      if (brandTitle) brandTitle.style.color = light ? '#ffffff' : '';

      var brandSub = document.getElementById('navBrandSub');
      if (brandSub) brandSub.style.color = light ? 'rgba(255,255,255,0.7)' : '';

      document.querySelectorAll('.nav-item').forEach(function(el) {
        el.style.color = light ? 'rgba(255,255,255,0.9)' : '';
      });

      var masukBtn = document.getElementById('navMasukBtn');
      if (masukBtn) {
        masukBtn.style.color       = light ? '#ffffff' : '';
        masukBtn.style.borderColor = light ? 'rgba(255,255,255,0.4)' : '';
      }

      var hamBtn = document.getElementById('navHamBtn');
      if (hamBtn) hamBtn.style.color = light ? '#ffffff' : '';
    }

    window.addEventListener('scroll', applyNav, { passive: true });
    applyNav();
  })();

  /* ── Mobile nav toggle ── */
  function toggleMobileNav() {
    var menu      = document.getElementById('navMobileMenu');
    var hamIcon   = document.getElementById('navHamIcon');
    var closeIcon = document.getElementById('navCloseIcon');
    var isHidden  = menu.style.display === 'none' || menu.style.display === '';
    menu.style.display      = isHidden ? 'block' : 'none';
    hamIcon.style.display   = isHidden ? 'none'  : '';
    closeIcon.style.display = isHidden ? ''      : 'none';
  }
  function closeMobileNav() {
    document.getElementById('navMobileMenu').style.display  = 'none';
    document.getElementById('navHamIcon').style.display     = '';
    document.getElementById('navCloseIcon').style.display   = 'none';
  }

  /* ── Slideshow ── */
  @if($headerType === 'slideshow')
  (function() {
    var slides  = document.querySelectorAll('.hero-slide');
    var dots    = document.querySelectorAll('.slide-dot');
    var current = 0;

    window.goToSlide = function(idx) {
      slides.forEach(function(s, i) { s.style.opacity = i === idx ? '1' : '0'; });
      dots.forEach(function(d, i) {
        d.style.width      = i === idx ? '1.25rem' : '0.5rem';
        d.style.background = i === idx ? '#fbbf24' : 'rgba(255,255,255,0.4)';
      });
      current = idx;
    };

    if (slides.length > 1) {
      setInterval(function() { window.goToSlide((current + 1) % slides.length); }, 5000);
    }
  })();
  @endif

  function showModal(nomor, isi, tanggal) {
    const titles = {
      'Perdes No. 01/2026': 'Pengelolaan dan Larangan Membuang Sampah Sembarangan',
      'Perdes No. 02/2026': 'Anggaran Pendapatan dan Belanja Desa Tahun 2026',
      'Perdes No. 03/2025': 'Tata Cara Pembentukan dan Pengelolaan BUMDes',
      'Perdes No. 04/2025': 'Ketertiban Umum dan Ketentraman Masyarakat',
      'Perdes No. 05/2025': 'Laporan Pertanggungjawaban Realisasi APBDesa 2024',
      'Perdes No. 06/2024': 'Pelestarian Sumber Daya Alam dan Lingkungan Desa',
    };
    document.getElementById('modalNomor').textContent = nomor;
    document.getElementById('modalJudul').textContent = titles[nomor] || nomor;
    document.getElementById('modalIsi').textContent = isi;
    document.getElementById('modalTanggal').textContent = 'Ditetapkan: ' + tanggal;
    const modal = document.getElementById('modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeModal() {
    const modal = document.getElementById('modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function filterTab(kategori) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    const cards = document.querySelectorAll('.perdes-card');
    let visible = 0;
    cards.forEach(card => {
      const match = kategori === 'semua' || card.dataset.jenis === kategori;
      card.style.display = match ? '' : 'none';
      if (match) visible++;
    });
    document.getElementById('emptyState').classList.toggle('hidden', visible > 0);
  }

  function filterPerdes() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.perdes-card');
    let visible = 0;
    cards.forEach(card => {
      const title = (card.dataset.title || '') + card.querySelector('h3').textContent;
      const match = title.toLowerCase().includes(q);
      card.style.display = match ? '' : 'none';
      if (match) visible++;
    });
    document.getElementById('emptyState').classList.toggle('hidden', visible > 0);
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('.aos').forEach(el => observer.observe(el));

  function animateCounter(el, target, duration = 1500) {
    const start = performance.now();
    const update = (now) => {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.round(eased * target).toLocaleString('id-ID');
      if (progress < 1) requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
  }

  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        animateCounter(e.target, parseInt(e.target.dataset.count));
        counterObserver.unobserve(e.target);
      }
    });
  }, { threshold: 0.5 });
  document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));

  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });
</script>

</body>
</html>
