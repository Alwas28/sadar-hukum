<x-admin-layout title="Halaman">
<div class="p-4 sm:p-6 space-y-5">

  @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="flex items-center gap-3 px-4 py-3 bg-hijau-50 border border-hijau-200 text-hijau-800 rounded-xl text-sm">
      <svg class="w-4 h-4 text-hijau-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      {{ session('success') }}
    </div>
  @endif

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-display text-2xl font-bold text-gray-800">Halaman</h1>
        <p class="text-sm text-gray-500">Kelola halaman/seksi yang tampil di homepage</p>
      </div>
    </div>
    <a href="{{ route('admin.halaman.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Tambah Halaman
    </a>
  </div>

  {{-- Grid Kartu --}}
  @if($halamans->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-20 text-center">
      <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
      </svg>
      <p class="text-gray-400 font-medium">Belum ada halaman</p>
      <a href="{{ route('admin.halaman.create') }}"
         class="mt-4 inline-flex items-center gap-1.5 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">
        + Tambah Halaman Pertama
      </a>
    </div>
  @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($halamans as $h)
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col overflow-hidden">

        {{-- Foto --}}
        @if($h->foto)
          <div class="h-40 overflow-hidden bg-gray-100 flex-shrink-0">
            <img src="{{ asset('storage/'.$h->foto) }}" alt="{{ $h->judul }}"
                 class="w-full h-full object-cover"/>
          </div>
        @else
          <div class="h-28 bg-gradient-to-br from-violet-50 to-violet-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-10 h-10 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
        @endif

        <div class="p-4 flex-1 flex flex-col">
          <div class="flex items-start justify-between gap-2 mb-2">
            <h3 class="font-semibold text-gray-800 text-sm leading-snug line-clamp-2 flex-1">{{ $h->judul }}</h3>
            <span class="text-xs font-mono text-gray-400 flex-shrink-0 bg-gray-50 px-1.5 py-0.5 rounded-md border border-gray-100">#{{ $h->urutan }}</span>
          </div>

          @if($h->ringkasan)
            <p class="text-xs text-gray-500 line-clamp-2 mb-3 flex-1">{{ $h->ringkasan }}</p>
          @else
            <div class="flex-1"></div>
          @endif

          {{-- Status + slug --}}
          <div class="flex items-center gap-2 mb-3">
            @if($h->is_published)
              <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-hijau-100 text-hijau-700 border border-hijau-200">
                <span class="w-1.5 h-1.5 bg-hijau-500 rounded-full"></span> Terbit
              </span>
            @else
              <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Draft
              </span>
            @endif
            <span class="text-xs text-gray-400 font-mono truncate">#{{ $h->slug }}</span>
          </div>

          {{-- Actions --}}
          <div class="flex items-center gap-1.5 pt-3 border-t border-gray-50">
            <a href="{{ route('admin.halaman.edit', $h) }}"
               class="flex-1 text-center px-3 py-1.5 text-xs font-semibold text-hijau-700 bg-hijau-50 hover:bg-hijau-100 rounded-lg transition-colors">
              Edit
            </a>

            <form method="POST" action="{{ route('admin.halaman.toggle', $h) }}">
              @csrf @method('PATCH')
              <button type="submit"
                      class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors
                             {{ $h->is_published ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-langit-700 bg-langit-50 hover:bg-langit-100' }}">
                {{ $h->is_published ? 'Sembunyikan' : 'Terbitkan' }}
              </button>
            </form>

            <form method="POST" action="{{ route('admin.halaman.destroy', $h) }}"
                  onsubmit="return confirm('Hapus halaman {{ $h->judul }}?')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="px-2.5 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    @if($halamans->hasPages())
      <div>{{ $halamans->links() }}</div>
    @endif
  @endif

</div>
</x-admin-layout>
