<x-admin-layout title="Dashboard">

<div class="p-4 sm:p-6 space-y-6">

  {{-- ── Hero Welcome ── --}}
  <div class="relative overflow-hidden rounded-2xl bg-hijau-800 text-white px-6 py-8">
    <div class="absolute inset-0 opacity-10"
         style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fbbf24' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4z'/%3E%3C/g%3E%3C/svg%3E\");"></div>
    <div class="absolute top-0 right-0 w-64 h-64 bg-langit-500/20 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
    <div class="absolute bottom-0 left-1/2 w-48 h-48 bg-emas-400/15 rounded-full translate-y-1/2 blur-3xl"></div>

    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="w-14 h-14 rounded-2xl object-cover shadow-md flex-shrink-0 bg-white"/>
        <div>
          <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emas-400/20 border border-emas-400/30 rounded-full text-emas-300 text-xs font-semibold mb-2">
            <span class="w-1.5 h-1.5 bg-emas-400 rounded-full animate-pulse"></span>
            Sistem Aktif
          </div>
          <h1 class="font-display text-2xl font-bold leading-tight">
            Selamat Datang, <span class="text-emas-400">{{ Auth::user()->name }}</span>
          </h1>
          <p class="text-hijau-200 text-sm mt-0.5">
            Portal Admin SADAR HUKUM &middot; {{ now()->locale('id')->translatedFormat('l, d F Y') }}
          </p>
        </div>
      </div>
      <a href="{{ route('admin.perdes.create') }}"
         class="self-start sm:self-center inline-flex items-center gap-2 px-5 py-2.5 bg-emas-500 hover:bg-emas-400 text-hijau-900 font-bold text-sm rounded-xl transition-all hover:shadow-lg flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Buat Perdes Baru
      </a>
    </div>
  </div>

  {{-- ── Stat Cards ── --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

    {{-- Total Regulasi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-hijau-100 flex items-center justify-center">
          <svg class="w-5 h-5 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-hijau-100 text-hijau-700">Total</span>
      </div>
      <div class="font-display text-3xl font-black text-hijau-700">{{ $counts['total'] }}</div>
      <div class="text-sm text-gray-500 mt-0.5">Total Regulasi Desa</div>
      <div class="mt-3 flex items-center gap-1 text-xs text-hijau-600 font-medium">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ $counts['selesai'] }} selesai &middot; {{ $counts['draft'] }} draft
      </div>
    </div>

    {{-- Selesai --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
          <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
          </svg>
        </div>
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Selesai</span>
      </div>
      <div class="font-display text-3xl font-black text-emerald-700">{{ $counts['selesai'] }}</div>
      <div class="text-sm text-gray-500 mt-0.5">Regulasi Selesai</div>
      <div class="mt-3 flex items-center gap-1 text-xs text-emerald-600 font-medium">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        {{ $counts['tahun_ini'] }} dibuat tahun {{ now()->year }}
      </div>
    </div>

    {{-- Draft --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
          <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
        </div>
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Draft</span>
      </div>
      <div class="font-display text-3xl font-black text-amber-700">{{ $counts['draft'] }}</div>
      <div class="text-sm text-gray-500 mt-0.5">Sedang Dikerjakan</div>
      <div class="mt-3 flex items-center gap-1 text-xs text-amber-600 font-medium">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Perlu dilengkapi
      </div>
    </div>

    {{-- Pengumuman --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-langit-100 flex items-center justify-center">
          <svg class="w-5 h-5 text-langit-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
          </svg>
        </div>
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-langit-100 text-langit-700">Publik</span>
      </div>
      <div class="font-display text-3xl font-black text-langit-700">{{ $counts['pengumuman'] }}</div>
      <div class="text-sm text-gray-500 mt-0.5">Pengumuman Aktif</div>
      <div class="mt-3 flex items-center gap-1 text-xs text-langit-600 font-medium">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        {{ $counts['berita'] }} berita diterbitkan
      </div>
    </div>

  </div>

  {{-- ── Konten Bawah ── --}}
  <div class="grid lg:grid-cols-3 gap-6">

    {{-- Tabel Regulasi Terbaru --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <div>
          <h3 class="font-semibold text-gray-800">Regulasi Terbaru</h3>
          <p class="text-xs text-gray-400 mt-0.5">5 regulasi yang baru dibuat atau diperbarui</p>
        </div>
        <a href="{{ route('admin.perdes.index') }}"
           class="text-xs font-semibold text-hijau-600 hover:text-hijau-800 transition-colors">Lihat semua →</a>
      </div>

      @if($latestPerdes->isEmpty())
        <div class="px-5 py-12 text-center">
          <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          <p class="text-sm text-gray-400">Belum ada regulasi tersimpan.</p>
          <a href="{{ route('admin.perdes.create') }}"
             class="mt-2 inline-flex items-center gap-1 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">
            + Buat Regulasi Pertama
          </a>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Jenis</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              @foreach($latestPerdes as $item)
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3.5">
                  <div class="font-semibold text-gray-800 text-xs truncate max-w-xs">{{ $item->judul }}</div>
                  <div class="text-gray-400 text-xs mt-0.5">{{ $item->created_at->locale('id')->diffForHumans() }}</div>
                </td>
                <td class="px-3 py-3.5 hidden sm:table-cell">
                  <span class="text-xs text-gray-600 bg-gray-100 px-2 py-0.5 rounded-lg whitespace-nowrap">
                    {{ \App\Models\Perdes::jenisLabel($item->jenis) }}
                  </span>
                </td>
                <td class="px-3 py-3.5">
                  @if($item->status === 'selesai')
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-hijau-100 text-hijau-700 border border-hijau-200">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                      Selesai
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                      Draft
                    </span>
                  @endif
                </td>
                <td class="px-5 py-3.5 text-right">
                  <a href="{{ route('admin.perdes.show', $item) }}"
                     class="text-xs text-hijau-700 hover:text-hijau-900 font-semibold transition-colors">
                    {{ $item->status === 'draft' ? 'Edit' : 'Lihat' }} →
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    {{-- Panel Kanan --}}
    <div class="space-y-5">

      {{-- Aksi Cepat --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="space-y-2">

          <a href="{{ route('admin.perdes.create') }}"
             class="flex items-center gap-3 p-3 rounded-xl hover:bg-hijau-50 border border-transparent hover:border-hijau-100 transition-all group">
            <div class="w-9 h-9 rounded-xl bg-hijau-100 group-hover:bg-hijau-200 flex items-center justify-center transition-colors flex-shrink-0">
              <svg class="w-5 h-5 text-hijau-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div>
              <div class="text-sm font-semibold text-gray-800">Buat Regulasi Baru</div>
              <div class="text-xs text-gray-400">Generate dengan AI</div>
            </div>
          </a>

          <a href="{{ route('admin.perdes.index') }}"
             class="flex items-center gap-3 p-3 rounded-xl hover:bg-langit-50 border border-transparent hover:border-langit-100 transition-all group">
            <div class="w-9 h-9 rounded-xl bg-langit-100 group-hover:bg-langit-200 flex items-center justify-center transition-colors flex-shrink-0">
              <svg class="w-5 h-5 text-langit-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <div>
              <div class="text-sm font-semibold text-gray-800">Semua Regulasi</div>
              <div class="text-xs text-gray-400">{{ $counts['total'] }} regulasi tersimpan</div>
            </div>
          </a>

          <a href="{{ route('admin.pengumuman.index') }}"
             class="flex items-center gap-3 p-3 rounded-xl hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all group">
            <div class="w-9 h-9 rounded-xl bg-amber-100 group-hover:bg-amber-200 flex items-center justify-center transition-colors flex-shrink-0">
              <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
              </svg>
            </div>
            <div>
              <div class="text-sm font-semibold text-gray-800">Pengumuman</div>
              <div class="text-xs text-gray-400">{{ $counts['pengumuman'] }} aktif dipublikasikan</div>
            </div>
          </a>

          <a href="{{ route('admin.pengaturan.index') }}"
             class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-all group">
            <div class="w-9 h-9 rounded-xl bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center transition-colors flex-shrink-0">
              <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
            <div>
              <div class="text-sm font-semibold text-gray-800">Pengaturan</div>
              <div class="text-xs text-gray-400">AI, PDF, dan tampilan</div>
            </div>
          </a>

        </div>
      </div>

      {{-- Aktivitas Terbaru --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>

        @if($activities->isEmpty())
          <p class="text-sm text-gray-400 text-center py-4">Belum ada aktivitas.</p>
        @else
          <div class="space-y-4">
            @foreach($activities as $act)
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center mt-0.5
                {{ $act->status === 'selesai' ? 'bg-hijau-100' : 'bg-amber-100' }}">
                @if($act->status === 'selesai')
                  <svg class="w-3.5 h-3.5 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                @else
                  <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                @endif
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-700 leading-snug line-clamp-2">{{ $act->judul }}</p>
                <p class="text-xs text-gray-400 mt-0.5">
                  {{ \App\Models\Perdes::jenisLabel($act->jenis) }} &middot;
                  {{ $act->updated_at->locale('id')->diffForHumans() }}
                </p>
              </div>
            </div>
            @endforeach
          </div>
        @endif
      </div>

    </div>
  </div>

</div>

</x-admin-layout>
