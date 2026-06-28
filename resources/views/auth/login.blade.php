@php
use App\Models\Setting;
$themeColor = Setting::get('theme_color', 'hijau');
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
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Masuk – SADAR HUKUM Desa Tontonunu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            display: ['Playfair Display', 'serif'],
            body:    ['Plus Jakarta Sans', 'sans-serif'],
          },
          colors: {
            p: {!! json_encode($p) !!},
            emas: { 300: '#fde68a', 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706' }
          },
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
    .brand-bg {
      background-color: var(--p-700);
      background-image:
        radial-gradient(circle at 20% 30%, rgba(251,191,36,0.12) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .input-field {
      width:100%; padding:0.625rem 0.75rem 0.625rem 2.5rem;
      font-size:0.875rem; border-radius:0.75rem; background:white;
      border:1px solid #e5e7eb; transition:all 0.2s ease;
    }
    .input-field:focus {
      outline:none; border-color:var(--p-500);
      box-shadow:0 0 0 3px color-mix(in srgb, var(--p-500) 15%, transparent);
    }
    .input-field.error { border-color:#f87171; background:#fef2f2; }
    .btn-primary {
      width:100%; display:flex; align-items:center; justify-content:center; gap:0.5rem;
      padding:0.75rem 1rem; background:var(--p-700); color:white;
      font-weight:600; font-size:0.875rem; border-radius:0.75rem;
      transition:all 0.2s ease; border:none; cursor:pointer;
    }
    .btn-primary:hover { background:var(--p-800); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
    .btn-primary:active { transform:scale(0.98); }
    .link-p { color:var(--p-700); font-weight:600; transition:color 0.15s; }
    .link-p:hover { color:var(--p-900); }
    .status-info { background:var(--p-50); border:1px solid var(--p-200); color:var(--p-700); }
    .check-accent { accent-color:var(--p-600); }
  </style>
</head>
<body class="min-h-screen flex">

  <!-- ── Kiri: Branding ── -->
  <div class="hidden lg:flex lg:w-1/2 brand-bg flex-col justify-between p-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-80 h-80 bg-emas-400/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/3 blur-3xl pointer-events-none"></div>

    <!-- Logo -->
    <div class="relative z-10 flex items-center gap-3">
      <img src="{{ asset('logo.jpeg') }}" alt="Logo Desa Tontonunu" class="w-12 h-12 rounded-xl object-cover shadow-md bg-white"/>
      <div>
        <div class="font-display text-white font-bold text-lg leading-tight">SADAR HUKUM</div>
        <div class="text-xs leading-tight" style="color:var(--p-200)">Desa Tontonunu</div>
      </div>
    </div>

    <!-- Tagline -->
    <div class="relative z-10">
      <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emas-400/20 border border-emas-400/40 rounded-full text-emas-300 text-xs font-semibold mb-6">
        <span class="w-2 h-2 bg-emas-400 rounded-full animate-pulse"></span>
        Sistem Informasi Resmi Desa
      </div>
      <h1 class="font-display text-4xl xl:text-5xl font-black text-white leading-tight mb-4">
        Portal Manajemen<br/>
        <span class="text-emas-400">Peraturan Desa</span>
      </h1>
      <p class="text-sm leading-relaxed max-w-sm" style="color:var(--p-200)">
        Kelola peraturan desa secara digital dengan dukungan kecerdasan buatan. Transparansi, efisiensi, dan akuntabilitas dalam satu platform.
      </p>
    </div>

    <!-- Stats -->
    <div class="relative z-10 grid grid-cols-3 gap-4">
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-xl p-4 text-center">
        <div class="text-2xl font-display font-black text-emas-400">24</div>
        <div class="text-xs mt-0.5" style="color:var(--p-200)">Perdes Aktif</div>
      </div>
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-xl p-4 text-center">
        <div class="text-2xl font-display font-black text-emas-400">4</div>
        <div class="text-xs mt-0.5" style="color:var(--p-200)">Aktor Sistem</div>
      </div>
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-xl p-4 text-center">
        <div class="text-2xl font-display font-black text-emas-400">AI</div>
        <div class="text-xs mt-0.5" style="color:var(--p-200)">Powered</div>
      </div>
    </div>
  </div>

  <!-- ── Kanan: Form Login ── -->
  <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-gray-50">
    <div class="w-full max-w-md">

      <!-- Logo mobile -->
      <div class="flex lg:hidden items-center gap-3 mb-8">
        <img src="{{ asset('logo.jpeg') }}" alt="Logo Desa Tontonunu" class="w-10 h-10 rounded-xl object-cover shadow-sm"/>
        <div>
          <div class="font-display font-bold text-base leading-tight" style="color:var(--p-700)">SADAR HUKUM</div>
          <div class="text-xs text-gray-500">Desa Tontonunu</div>
        </div>
      </div>

      <!-- Header -->
      <div class="mb-8">
        <h2 class="font-display text-3xl font-bold text-gray-800 mb-1">Selamat Datang</h2>
        <p class="text-gray-500 text-sm">Masuk ke panel administrasi desa</p>
      </div>

      @if (session('status'))
        <div class="mb-4 px-4 py-3 status-info text-sm rounded-xl">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
              required autofocus autocomplete="username" placeholder="admin@gmail.com"
              class="input-field {{ $errors->has('email') ? 'error' : '' }}"/>
          </div>
          @error('email')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <input id="password" type="password" name="password"
              required autocomplete="current-password" placeholder="••••••••"
              class="input-field {{ $errors->has('password') ? 'error' : '' }}"/>
          </div>
          @error('password')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <!-- Remember me -->
        <div class="flex items-center">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" id="remember_me" class="w-4 h-4 rounded border-gray-300 check-accent"/>
            <span class="text-sm text-gray-600">Ingat saya</span>
          </label>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
          </svg>
          Masuk ke Sistem
        </button>
      </form>

      <!-- Footer -->
      <div class="mt-8 pt-6 border-t border-gray-100 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-sm link-p">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Kembali ke Portal Publik
        </a>
      </div>

      <p class="mt-6 text-center text-xs text-gray-400">
        © {{ date('Y') }} Pemerintah Desa Tontonunu · Kabupaten Bombana
      </p>
    </div>
  </div>

</body>
</html>
