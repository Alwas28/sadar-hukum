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
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buat Akun – SADAR HUKUM Desa Tontonunu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { display: ['Playfair Display','serif'], body: ['Plus Jakarta Sans','sans-serif'] },
          colors: {
            p: {!! json_encode($p) !!},
            emas: { 300:'#fde68a', 400:'#fbbf24', 500:'#f59e0b', 600:'#d97706' }
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
    .brand-bg {
      background-color: var(--p-700);
      background-image:
        radial-gradient(circle at 20% 30%, rgba(251,191,36,0.12) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .input-field {
      width:100%; padding:0.75rem 1rem; font-size:0.875rem;
      border-radius:0.75rem; background:white; border:1px solid #e5e7eb; transition:all 0.2s;
    }
    .input-field.has-icon { padding-right:2.75rem; }
    .input-field:focus { outline:none; border-color:var(--p-500); box-shadow:0 0 0 3px color-mix(in srgb, var(--p-500) 15%, transparent); }
    .input-field.error { border-color:#f87171; background:#fef2f2; }
    .btn-primary {
      width:100%; display:flex; align-items:center; justify-content:center; gap:0.5rem;
      padding:0.75rem; background:var(--p-700); color:white; font-weight:700;
      font-size:0.875rem; border-radius:0.75rem; border:none; cursor:pointer; transition:all 0.2s;
    }
    .btn-primary:hover { background:var(--p-800); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
    .link-p { color:var(--p-700); font-weight:600; }
    .link-p:hover { color:var(--p-900); }
    .step-badge { background:var(--p-100); color:var(--p-700); }
    .step-no   { background:var(--p-700); color:white; }
    .identity-card { background:var(--p-50); border:1px solid var(--p-200); }
    .identity-avatar { background:var(--p-700); }
    .identity-check  { color:var(--p-600); }
    .step-done { background:var(--p-700); border-color:var(--p-400); }
  </style>
</head>
<body class="min-h-screen flex">

  <!-- ── Kiri: Branding ── -->
  <div class="hidden lg:flex lg:w-1/2 brand-bg flex-col justify-between p-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-80 h-80 bg-emas-400/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/3 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex items-center gap-3">
      <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="w-12 h-12 rounded-xl object-cover shadow-md bg-white"/>
      <div>
        <div class="font-display text-white font-bold text-lg leading-tight">SADAR HUKUM</div>
        <div class="text-xs leading-tight" style="color:var(--p-200)">Desa Tontonunu</div>
      </div>
    </div>

    <div class="relative z-10">
      <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emas-400/20 border border-emas-400/40 rounded-full text-emas-300 text-xs font-semibold mb-6">
        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        Identitas Terverifikasi
      </div>
      <h1 class="font-display text-4xl xl:text-5xl font-black text-white leading-tight mb-4">
        Selamat,<br/>
        <span class="text-emas-400">{{ $penduduk->nama }}</span>
      </h1>
      <p class="text-sm leading-relaxed max-w-sm" style="color:var(--p-200)">
        Identitas Anda berhasil diverifikasi. Sekarang buat email dan password untuk mengakses portal warga.
      </p>
    </div>

    <div class="relative z-10">
      <p class="text-xs font-semibold uppercase tracking-wider mb-4" style="color:var(--p-300)">Tahapan Pendaftaran</p>
      <div class="space-y-3">
        <div class="flex items-center gap-3 opacity-60">
          <div class="w-8 h-8 rounded-full step-done border-2 text-white flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <p class="text-white text-sm font-semibold line-through">Verifikasi Identitas</p>
            <p class="text-xs" style="color:var(--p-300)">Selesai</p>
          </div>
        </div>
        <div class="ml-4 border-l h-4" style="border-color:var(--p-600)"></div>
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-emas-400 text-gray-900 flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
          <div>
            <p class="text-white text-sm font-semibold">Buat Akses Login</p>
            <p class="text-xs" style="color:var(--p-300)">Email dan password</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── Kanan: Form Buat Akun ── -->
  <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-gray-50">
    <div class="w-full max-w-md">

      <div class="lg:hidden flex items-center gap-2 mb-6">
        <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="w-8 h-8 rounded-lg object-cover"/>
        <span class="font-display font-bold" style="color:var(--p-800)">SADAR HUKUM</span>
      </div>

      <div class="mb-8">
        <div class="flex items-center gap-2 mb-3">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 step-badge rounded-full text-xs font-bold">
            <span class="w-5 h-5 step-no rounded-full flex items-center justify-center text-xs font-bold">2</span>
            Tahap 2 dari 2
          </span>
        </div>
        <h2 class="font-display text-2xl font-bold text-gray-900">Buat Akses Login</h2>
        <p class="text-sm text-gray-500 mt-1.5">Lengkapi email dan buat password untuk masuk ke portal warga.</p>
      </div>

      @if($errors->any())
        <div class="mb-5 flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
          <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
          <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
        </div>
      @endif

      {{-- Kartu info penduduk --}}
      <div class="mb-6 flex items-center gap-3 px-4 py-3 identity-card rounded-xl">
        <div class="w-10 h-10 rounded-full identity-avatar text-white flex items-center justify-center text-base font-bold flex-shrink-0">
          {{ strtoupper(substr($penduduk->nama, 0, 1)) }}
        </div>
        <div class="min-w-0">
          <p class="text-sm font-bold text-gray-800 truncate">{{ $penduduk->nama }}</p>
          <p class="text-xs text-gray-500 font-mono">{{ substr($penduduk->nik, 0, 4) }}••••••••{{ substr($penduduk->nik, -4) }}</p>
        </div>
        <div class="ml-auto flex-shrink-0">
          <svg class="w-5 h-5 identity-check" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
        </div>
      </div>

      <form method="POST" action="{{ route('register.simpan') }}" class="space-y-5">
        @csrf

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
          <input type="email" name="email" value="{{ old('email') }}"
                 placeholder="contoh@email.com" autofocus
                 class="input-field {{ $errors->has('email') ? 'error' : '' }}"/>
          @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          <p class="mt-1 text-xs text-gray-400">Email ini akan digunakan untuk login.</p>
        </div>

        <div x-data="{ show: false }">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <input :type="show ? 'text' : 'password'" name="password"
                   placeholder="Min. 8 karakter, huruf & angka"
                   class="input-field has-icon {{ $errors->has('password') ? 'error' : '' }}"/>
            <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <svg x-show="show" class="w-5 h-5" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>
          @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div x-data="{ show: false }">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <input :type="show ? 'text' : 'password'" name="password_confirmation"
                   placeholder="Ulangi password"
                   class="input-field has-icon border-gray-200 bg-white"/>
            <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <svg x-show="show" class="w-5 h-5" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-primary">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Buat Akun & Masuk
        </button>
      </form>

      <p class="mt-6 text-center text-sm text-gray-500">
        Bukan akun Anda? <a href="{{ route('register') }}" class="link-p">Ulangi verifikasi</a>
      </p>
    </div>
  </div>

</body>
</html>
