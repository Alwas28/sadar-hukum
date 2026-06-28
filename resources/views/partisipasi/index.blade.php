<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Partisipasi Warga — {{ config('app.name') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen antialiased">

  {{-- Nav --}}
  <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-10">
    <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
      <a href="{{ url('/') }}" class="flex items-center gap-2.5 text-hijau-800 font-display font-bold text-base">
        <svg class="w-6 h-6 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
        </svg>
        Partisipasi Warga
      </a>
      <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-800 transition-colors">← Kembali ke Beranda</a>
    </div>
  </nav>

  <div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="text-center mb-10">
      <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-hijau-100 text-hijau-700 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
        <span class="w-2 h-2 bg-hijau-500 rounded-full animate-pulse"></span>
        Terbuka untuk Aspirasi
      </div>
      <h1 class="font-display text-3xl font-black text-gray-900 mb-3">Suara Warga untuk Desa</h1>
      <p class="text-gray-500 max-w-lg mx-auto text-sm leading-relaxed">
        Rancangan peraturan desa di bawah ini sedang dalam tahap pembahasan.
        Sampaikan pendapat Anda — setuju, menolak, atau usulkan perbaikan.
      </p>
    </div>

    @if($draftPerdes->isEmpty())
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="text-gray-500 font-medium">Tidak ada rancangan peraturan yang sedang dibuka untuk aspirasi saat ini.</p>
      </div>
    @else
      <div class="space-y-4">
        @foreach($draftPerdes as $p)
        <a href="{{ route('partisipasi.show', $p) }}"
           class="flex items-center gap-5 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-hijau-200 transition-all p-5 group">
          <div class="w-12 h-12 rounded-xl bg-hijau-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-1">
              <span class="text-xs font-semibold text-hijau-600 bg-hijau-50 px-2 py-0.5 rounded-md">
                {{ \App\Models\Perdes::jenisLabel($p->jenis) }}
              </span>
              <span class="text-xs text-gray-400">{{ $p->created_at->locale('id')->isoFormat('D MMM Y') }}</span>
            </div>
            <p class="font-semibold text-gray-800 text-sm group-hover:text-hijau-700 transition-colors truncate">{{ $p->judul }}</p>
            <p class="text-xs text-gray-400 mt-0.5">
              {{ $p->votes_count }} suara masuk
            </p>
          </div>
          <svg class="w-5 h-5 text-gray-300 group-hover:text-hijau-400 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        @endforeach
      </div>
    @endif

  </div>

</body>
</html>
