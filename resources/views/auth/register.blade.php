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
  <title>Daftar Akun Warga – SADAR HUKUM Desa Tontonunu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
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
    .info-box { background:var(--p-50); border:1px solid var(--p-200); color:var(--p-800); }
    .step-badge { background:var(--p-100); color:var(--p-700); }
    .step-no   { background:var(--p-700); color:white; }
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
        <span class="w-2 h-2 bg-emas-400 rounded-full"></span>
        Pendaftaran Akun Warga
      </div>
      <h1 class="font-display text-4xl xl:text-5xl font-black text-white leading-tight mb-4">
        Bergabung &amp;<br/>
        <span class="text-emas-400">Berpartisipasi</span>
      </h1>
      <p class="text-sm leading-relaxed max-w-sm" style="color:var(--p-200)">
        Warga Desa Tontonunu yang terdaftar di data kependudukan dapat memiliki akun untuk berpartisipasi dalam pembentukan peraturan desa.
      </p>
    </div>

    <div class="relative z-10">
      <p class="text-xs font-semibold uppercase tracking-wider mb-4" style="color:var(--p-300)">Tahapan Pendaftaran</p>
      <div class="space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-emas-400 text-gray-900 flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
          <div>
            <p class="text-white text-sm font-semibold">Verifikasi Identitas</p>
            <p class="text-xs" style="color:var(--p-300)">Masukkan NIK dan tanggal lahir</p>
          </div>
        </div>
        <div class="ml-4 border-l h-4" style="border-color:var(--p-600)"></div>
        <div class="flex items-center gap-3 opacity-50">
          <div class="w-8 h-8 rounded-full bg-white/20 border border-white/30 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
          <div>
            <p class="text-white text-sm font-semibold">Buat Akses Login</p>
            <p class="text-xs" style="color:var(--p-300)">Email dan password</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── Kanan: Form Verifikasi ── -->
  <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-gray-50">
    <div class="w-full max-w-md">

      <div class="lg:hidden flex items-center gap-2 mb-6">
        <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="w-8 h-8 rounded-lg object-cover"/>
        <span class="font-display font-bold" style="color:var(--p-800)">SADAR HUKUM</span>
      </div>

      <div class="mb-8">
        <div class="flex items-center gap-2 mb-3">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 step-badge rounded-full text-xs font-bold">
            <span class="w-5 h-5 step-no rounded-full flex items-center justify-center text-xs font-bold">1</span>
            Tahap 1 dari 2
          </span>
        </div>
        <h2 class="font-display text-2xl font-bold text-gray-900">Verifikasi Identitas</h2>
        <p class="text-sm text-gray-500 mt-1.5">Masukkan NIK dan tanggal lahir sesuai data kependudukan Desa Tontonunu.</p>
      </div>

      @if($errors->any())
        <div class="mb-5 flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
          <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
          <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
        </div>
      @endif

      <form method="POST" action="{{ route('register.verifikasi') }}" class="space-y-5">
        @csrf

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">NIK <span class="text-red-500">*</span></label>
          <input type="text" name="nik" value="{{ old('nik') }}"
                 inputmode="numeric" maxlength="16" placeholder="16 digit NIK" autofocus
                 class="input-field font-mono tracking-widest {{ $errors->has('nik') ? 'error' : '' }}"/>
          <p class="mt-1 text-xs text-gray-400">Sesuai KTP atau Kartu Keluarga Anda.</p>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
          <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                 max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                 class="input-field {{ $errors->has('tanggal_lahir') ? 'error' : '' }}"/>
          <p class="mt-1 text-xs text-gray-400">Sesuai tanggal lahir di data kependudukan desa.</p>
        </div>

        <div class="flex items-start gap-3 px-4 py-3 info-box rounded-xl text-xs">
          <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color:var(--p-600)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <p>Hanya warga yang terdaftar di data kependudukan Desa Tontonunu yang dapat mendaftar. Jika NIK tidak ditemukan, hubungi Kantor Desa.</p>
        </div>

        <button type="submit" class="btn-primary">
          Verifikasi Identitas
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </form>

      <p class="mt-6 text-center text-sm text-gray-500">
        Sudah punya akun? <a href="{{ route('login') }}" class="link-p">Masuk di sini</a>
      </p>
    </div>
  </div>

</body>
</html>
