@php
use App\Models\Setting;
use App\Models\Halaman;

$themeColor = Setting::get('theme_color', 'hijau');
$themeMode  = Setting::get('theme_mode', 'light');
$isDark     = $themeMode === 'dark';

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
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title', 'SADAR HUKUM') – Desa Tontonunu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            display: ['Playfair Display', 'serif'],
            body:    ['Plus Jakarta Sans', 'sans-serif'],
          },
          colors: {
            primary: {!! json_encode($p) !!},
            emas: { 50:'#fffbeb',100:'#fef3c7',300:'#fde68a',400:'#fbbf24',500:'#f59e0b',600:'#d97706',700:'#b45309' },
            hijau: { 900: '#0c4830' },
          }
        }
      }
    }
  </script>
  <style>
    :root {
      --p-50:{{ $p['50'] }};--p-100:{{ $p['100'] }};--p-200:{{ $p['200'] }};
      --p-300:{{ $p['300'] }};--p-400:{{ $p['400'] }};--p-500:{{ $p['500'] }};
      --p-600:{{ $p['600'] }};--p-700:{{ $p['700'] }};--p-800:{{ $p['800'] }};--p-900:{{ $p['900'] }};
    }
    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-display { font-family: 'Playfair Display', serif; }

    .card-hover { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.10); }

    .nav-item { padding: 0.25rem 0.625rem; border-radius: 0.5rem; transition: background 0.2s ease, color 0.2s ease; }
    #mainNav:not(.nav-is-transparent) .nav-item:hover { background: var(--p-50); color: var(--p-700); }
    .nav-item-active { background: var(--p-50); color: var(--p-700); font-weight: 600; }

    .aos { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .aos.visible { opacity: 1; transform: translateY(0); }
    .aos-delay-1 { transition-delay: 0.1s; }
    .aos-delay-2 { transition-delay: 0.2s; }
    .aos-delay-3 { transition-delay: 0.3s; }
    .aos-delay-4 { transition-delay: 0.4s; }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--p-50); }
    ::-webkit-scrollbar-thumb { background: var(--p-600); border-radius: 3px; }

    @yield('styles')
  </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">

{{-- ══════════ NAVBAR ══════════ --}}
@php $activeNav = $activeNav ?? ''; @endphp
<nav id="mainNav"
     class="sticky top-0 w-full z-50 transition-all duration-300 bg-white/95 dark:bg-gray-900/95 backdrop-blur border-b border-primary-100 dark:border-gray-800 shadow-sm">

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">

      {{-- Logo --}}
      <a href="{{ url('/') }}" class="flex items-center gap-3">
        <div id="navLogoBox" class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md transition-colors bg-primary-600">
          <svg class="w-6 h-6 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
          </svg>
        </div>
        <div>
          <div class="font-display font-bold text-base leading-tight text-primary-700 dark:text-primary-300">SADAR HUKUM</div>
          <div class="text-xs leading-tight text-gray-500 dark:text-gray-400">Desa Tontonunu</div>
        </div>
      </a>

      {{-- Menu desktop --}}
      <div class="hidden md:flex items-center gap-1 text-sm font-medium text-gray-600 dark:text-gray-300">
        <a href="{{ url('/') }}"              class="nav-item {{ $activeNav === 'beranda' ? 'nav-item-active' : 'hover:text-primary-700' }}">Beranda</a>
        <a href="{{ url('/tentang-program') }}" class="nav-item {{ $activeNav === 'tentang-program' ? 'nav-item-active' : 'hover:text-primary-700' }}">Tentang Program</a>
        <a href="{{ url('/panduan') }}"        class="nav-item {{ $activeNav === 'panduan' ? 'nav-item-active' : 'hover:text-primary-700' }}">Panduan</a>
        <a href="{{ url('/') }}#peraturan"    class="nav-item hover:text-primary-700">Peraturan Desa</a>
        <a href="{{ url('/') }}#statistik"    class="nav-item hover:text-primary-700">Statistik</a>
        <a href="{{ url('/') }}#kontak"       class="nav-item hover:text-primary-700">Kontak</a>
      </div>

      {{-- CTA desktop --}}
      <div class="hidden md:flex items-center gap-3">
        <a href="{{ route('login') }}"
           class="px-4 py-2 text-sm font-semibold rounded-lg transition-all text-primary-700 dark:text-primary-300 border border-primary-300 dark:border-primary-700 hover:bg-primary-50">
          Masuk
        </a>
        <a href="{{ route('register') }}"
           class="px-4 py-2 text-sm font-semibold text-gray-900 bg-emas-400 hover:bg-emas-300 rounded-lg transition-all hover:scale-105 shadow-sm">
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

  {{-- Mobile menu --}}
  <div id="navMobileMenu" style="display:none"
       class="md:hidden border-t border-primary-100 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur">
    <div class="px-4 py-4 flex flex-col gap-1 text-sm font-medium text-gray-600 dark:text-gray-300">
      <a href="{{ url('/') }}"                onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700 {{ $activeNav === 'beranda' ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">Beranda</a>
      <a href="{{ url('/tentang-program') }}" onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700 {{ $activeNav === 'tentang-program' ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">Tentang Program</a>
      <a href="{{ url('/panduan') }}"         onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700 {{ $activeNav === 'panduan' ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">Panduan</a>
      <a href="{{ url('/') }}#peraturan"      onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Peraturan Desa</a>
      <a href="{{ url('/') }}#statistik"      onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Statistik</a>
      <a href="{{ url('/') }}#tentang"        onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Tentang Desa</a>
      <a href="{{ url('/') }}#kontak"         onclick="closeMobileNav()" class="py-2 px-3 rounded-lg hover:bg-primary-50 hover:text-primary-700">Kontak</a>
      <div class="flex gap-2 pt-3 mt-1 border-t border-gray-100 dark:border-gray-700">
        <a href="{{ route('login') }}"    class="flex-1 py-2.5 text-sm font-semibold text-center text-primary-700 border border-primary-300 rounded-xl">Masuk</a>
        <a href="{{ route('register') }}" class="flex-1 py-2.5 text-sm font-semibold text-center text-gray-900 bg-emas-400 rounded-xl">Daftar</a>
      </div>
    </div>
  </div>
</nav>

{{-- ══════════ CONTENT ══════════ --}}
@yield('content')

{{-- ══════════ FOOTER ══════════ --}}
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
          <li><a href="{{ url('/') }}"            class="hover:text-white transition-colors">Beranda</a></li>
          <li><a href="{{ url('/') }}#peraturan"  class="hover:text-white transition-colors">Peraturan Desa</a></li>
          <li><a href="{{ url('/') }}#statistik"  class="hover:text-white transition-colors">Statistik</a></li>
          <li><a href="{{ url('/') }}#tentang"    class="hover:text-white transition-colors">Tentang Desa</a></li>
          <li><a href="{{ url('/tentang-program') }}" class="hover:text-white transition-colors">Tentang Program</a></li>
          <li><a href="{{ url('/panduan') }}"         class="hover:text-white transition-colors">Panduan</a></li>
          <li><a href="{{ route('login') }}"          class="hover:text-white transition-colors">Masuk</a></li>
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

<script>
  // Mobile nav
  var _mobileNavOpen = false;
  function toggleMobileNav() {
    _mobileNavOpen = !_mobileNavOpen;
    var menu  = document.getElementById('navMobileMenu');
    var ham   = document.getElementById('navHamIcon');
    var close = document.getElementById('navCloseIcon');
    if (_mobileNavOpen) { menu.style.display='block'; ham.style.display='none'; close.style.display='block'; }
    else                { menu.style.display='none';  ham.style.display='block'; close.style.display='none'; }
  }
  function closeMobileNav() {
    _mobileNavOpen = false;
    document.getElementById('navMobileMenu').style.display = 'none';
    document.getElementById('navHamIcon').style.display    = 'block';
    document.getElementById('navCloseIcon').style.display  = 'none';
  }

  // AOS
  (function() {
    var obs = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.aos').forEach(function(el) { obs.observe(el); });
  })();
</script>
@yield('scripts')
</body>
</html>
