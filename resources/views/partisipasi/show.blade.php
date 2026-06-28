<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $perdes->judul }} — Partisipasi Warga</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    .perdes-isi h2 { text-align:center; font-size:1rem; font-weight:700; text-transform:uppercase; color:#1f2937; margin:1.2em 0 0.3em; }
    .perdes-isi h3 { text-align:center; font-size:0.9rem; font-weight:700; color:#374151; margin:0.9em 0 0.5em; }
    .perdes-isi p  { margin:0.5em 0; line-height:1.75; text-align:justify; font-size:0.875rem; color:#374151; }
    .perdes-isi ol, .perdes-isi ul { margin:2px 0 0.7em; padding-left:1.75em; font-size:0.875rem; }
    .perdes-isi li { margin-bottom:0.35em; text-align:justify; color:#374151; }
    .perdes-isi ol[type="a"] { list-style-type:lower-alpha; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen antialiased" x-data>

  {{-- Nav --}}
  <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-10">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
      <a href="{{ route('partisipasi.index') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition-colors font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Daftar Aspirasi
      </a>
      <span class="text-xs font-semibold text-hijau-700 bg-hijau-100 px-2.5 py-1 rounded-full border border-hijau-200">
        Terbuka untuk Aspirasi
      </span>
    </div>
  </nav>

  <div class="max-w-5xl mx-auto px-4 py-8 space-y-6">

    {{-- Alert sudah vote --}}
    @if($sudahVote)
    <div class="flex items-start gap-3 px-5 py-4 rounded-2xl border
      @if($sudahVote === 'setuju') bg-hijau-50 border-hijau-200 text-hijau-800
      @elseif($sudahVote === 'menolak') bg-red-50 border-red-200 text-red-800
      @else bg-amber-50 border-amber-200 text-amber-800 @endif">
      <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <div>
        <p class="font-bold text-sm">Terima kasih, {{ $penduduk->nama }}!</p>
        <p class="text-sm mt-0.5">Suara Anda (<strong>{{ \App\Models\PerdesVote::suaraLabel($sudahVote) }}</strong>) telah berhasil dicatat.</p>
      </div>
    </div>
    @endif

    <div class="grid lg:grid-cols-5 gap-6">

      {{-- Kiri: Konten Perdes --}}
      <div class="lg:col-span-3 space-y-4">

        {{-- Info Perdes --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <div class="flex items-center gap-2 mb-3">
            <span class="text-xs font-semibold bg-hijau-100 text-hijau-700 px-2.5 py-1 rounded-full">
              {{ \App\Models\Perdes::jenisLabel($perdes->jenis) }}
            </span>
            <span class="text-xs text-gray-400">{{ $perdes->created_at->locale('id')->isoFormat('D MMMM Y') }}</span>
          </div>
          <h1 class="font-display text-xl font-bold text-gray-900 leading-snug">{{ $perdes->judul }}</h1>
        </div>

        {{-- Isi --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-gray-700">Isi Rancangan Peraturan</h2>
            <span class="text-xs text-gray-400">Baca sebelum memberikan suara</span>
          </div>
          <div class="perdes-isi max-h-[520px] overflow-y-auto pr-1 scrollbar-thin">
            {!! $perdes->isi !!}
          </div>
        </div>

        {{-- Hasil Voting --}}
        @if($summary['total'] > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-gray-700">Hasil Suara Sementara</h2>
            <span class="text-xs font-semibold text-gray-500">{{ $summary['total'] }} suara</span>
          </div>

          <div class="space-y-3">
            {{-- Setuju --}}
            <div>
              <div class="flex justify-between text-xs font-semibold mb-1">
                <span class="text-hijau-700 flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                  Setuju
                </span>
                <span class="text-hijau-700">{{ $summary['setuju'] }} ({{ $summary['pct_setuju'] }}%)</span>
              </div>
              <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-2.5 bg-hijau-500 rounded-full transition-all" style="width:{{ $summary['pct_setuju'] }}%"></div>
              </div>
            </div>
            {{-- Menolak --}}
            <div>
              <div class="flex justify-between text-xs font-semibold mb-1">
                <span class="text-red-600 flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                  Menolak
                </span>
                <span class="text-red-600">{{ $summary['menolak'] }} ({{ $summary['pct_menolak'] }}%)</span>
              </div>
              <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-2.5 bg-red-400 rounded-full transition-all" style="width:{{ $summary['pct_menolak'] }}%"></div>
              </div>
            </div>
            {{-- Perbaikan --}}
            <div>
              <div class="flex justify-between text-xs font-semibold mb-1">
                <span class="text-amber-700 flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  Perlu Perbaikan
                </span>
                <span class="text-amber-700">{{ $summary['perbaikan'] }} ({{ $summary['pct_perbaikan'] }}%)</span>
              </div>
              <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-2.5 bg-amber-400 rounded-full transition-all" style="width:{{ $summary['pct_perbaikan'] }}%"></div>
              </div>
            </div>
          </div>

          {{-- Komentar terbaru --}}
          @php $komentars = $votes->whereNotNull('alasan')->whereNotIn('suara', [])->take(5); @endphp
          @if($komentars->isNotEmpty())
            <div class="mt-5 border-t border-gray-100 pt-4 space-y-3">
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Catatan Warga</p>
              @foreach($komentars as $v)
              @if($v->alasan)
              <div class="flex gap-3">
                <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold
                  {{ $v->suara === 'setuju' ? 'bg-hijau-100 text-hijau-700' : ($v->suara === 'menolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                  {{ strtoupper(substr($v->nama, 0, 1)) }}
                </div>
                <div>
                  <p class="text-xs font-semibold text-gray-700">{{ $v->nama }}</p>
                  <p class="text-xs text-gray-500 leading-relaxed mt-0.5">{{ $v->alasan }}</p>
                </div>
              </div>
              @endif
              @endforeach
            </div>
          @endif
        </div>
        @endif

      </div>

      {{-- Kanan: Form Vote --}}
      <div class="lg:col-span-2">
        <div class="sticky top-20">
          @if($sudahVote)
            {{-- Sudah vote --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
              <div class="w-14 h-14 mx-auto rounded-full bg-hijau-100 flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <p class="font-bold text-gray-800 text-sm">Suara Anda Sudah Tercatat</p>
              <p class="text-xs text-gray-500 mt-1 mb-3 leading-relaxed">
                Anda memilih <strong>{{ \App\Models\PerdesVote::suaraLabel($sudahVote) }}</strong> untuk rancangan ini.
              </p>
              <a href="{{ route('partisipasi.index') }}"
                 class="inline-flex items-center gap-1.5 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">
                Lihat Rancangan Lainnya →
              </a>
            </div>
          @else
            {{-- Form vote --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6"
                 x-data="{ pilihan: '{{ old('suara', '') }}' }">

              <h3 class="text-sm font-bold text-gray-800 mb-1">Berikan Suara Anda</h3>
              <p class="text-xs text-gray-500 mb-4">Satu akun warga, satu suara.</p>

              {{-- Info warga yang login --}}
              <div class="flex items-center gap-3 px-3 py-2.5 bg-hijau-50 border border-hijau-200 rounded-xl mb-4">
                <div class="w-8 h-8 rounded-full bg-hijau-700 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                  {{ strtoupper(substr($penduduk->nama, 0, 1)) }}
                </div>
                <div class="min-w-0">
                  <p class="text-xs font-bold text-gray-800 truncate">{{ $penduduk->nama }}</p>
                  <p class="text-xs text-gray-400 font-mono">{{ substr($penduduk->nik, 0, 4) }}••••••••{{ substr($penduduk->nik, -4) }}</p>
                </div>
                <svg class="w-4 h-4 text-hijau-600 flex-shrink-0 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>

              @if($errors->any())
                <div class="mb-4 px-3 py-2.5 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700">
                  @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                </div>
              @endif

              <form method="POST" action="{{ route('partisipasi.vote', $perdes) }}" class="space-y-4">
                @csrf

                {{-- Pilihan Suara dengan Alpine reaktif --}}
                <div>
                  <label class="block text-xs font-semibold text-gray-600 mb-2">Pilihan Suara <span class="text-red-500">*</span></label>

                  <div class="space-y-2">
                    {{-- Setuju --}}
                    <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all"
                           :class="pilihan === 'setuju' ? 'border-hijau-400 bg-hijau-50' : 'border-gray-200 hover:border-hijau-200 hover:bg-hijau-50/40'">
                      <input type="radio" name="suara" value="setuju" x-model="pilihan" class="sr-only"/>
                      <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center transition-colors"
                           :class="pilihan === 'setuju' ? 'bg-hijau-600' : 'bg-hijau-100'">
                        <svg class="w-4 h-4 transition-colors" :class="pilihan === 'setuju' ? 'text-white' : 'text-hijau-600'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-bold" :class="pilihan === 'setuju' ? 'text-hijau-800' : 'text-gray-700'">Setuju</p>
                        <p class="text-xs text-gray-500">Saya mendukung rancangan ini</p>
                      </div>
                    </label>

                    {{-- Menolak --}}
                    <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all"
                           :class="pilihan === 'menolak' ? 'border-red-400 bg-red-50' : 'border-gray-200 hover:border-red-200 hover:bg-red-50/40'">
                      <input type="radio" name="suara" value="menolak" x-model="pilihan" class="sr-only"/>
                      <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center transition-colors"
                           :class="pilihan === 'menolak' ? 'bg-red-500' : 'bg-red-100'">
                        <svg class="w-4 h-4 transition-colors" :class="pilihan === 'menolak' ? 'text-white' : 'text-red-600'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-bold" :class="pilihan === 'menolak' ? 'text-red-800' : 'text-gray-700'">Menolak</p>
                        <p class="text-xs text-gray-500">Saya tidak mendukung rancangan ini</p>
                      </div>
                    </label>

                    {{-- Perlu Perbaikan --}}
                    <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all"
                           :class="pilihan === 'perbaikan' ? 'border-amber-400 bg-amber-50' : 'border-gray-200 hover:border-amber-200 hover:bg-amber-50/40'">
                      <input type="radio" name="suara" value="perbaikan" x-model="pilihan" class="sr-only"/>
                      <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center transition-colors"
                           :class="pilihan === 'perbaikan' ? 'bg-amber-500' : 'bg-amber-100'">
                        <svg class="w-4 h-4 transition-colors" :class="pilihan === 'perbaikan' ? 'text-white' : 'text-amber-600'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-bold" :class="pilihan === 'perbaikan' ? 'text-amber-800' : 'text-gray-700'">Perlu Perbaikan</p>
                        <p class="text-xs text-gray-500">Ada bagian yang perlu diperbaiki</p>
                      </div>
                    </label>
                  </div>
                </div>

                <div>
                  <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Catatan / Alasan
                    <span class="font-normal text-gray-400 ml-1">(opsional)</span>
                  </label>
                  <textarea name="alasan" rows="3"
                            placeholder="Tuliskan catatan, saran, atau alasan Anda..."
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all resize-none">{{ old('alasan') }}</textarea>
                </div>

                <button type="submit"
                        :disabled="!pilihan"
                        :class="pilihan ? 'bg-hijau-700 hover:bg-hijau-800 cursor-pointer' : 'bg-gray-300 cursor-not-allowed'"
                        class="w-full py-3 text-white text-sm font-bold rounded-xl transition-all hover:shadow-md">
                  Kirim Suara Saya
                </button>
              </form>
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>

</body>
</html>
