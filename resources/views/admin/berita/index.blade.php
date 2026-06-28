<x-admin-layout title="Berita Desa">

<div class="p-4 sm:p-6 space-y-5">

  @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="flex items-center gap-3 px-4 py-3 bg-langit-50 border border-langit-200 text-langit-800 rounded-xl text-sm">
      <svg class="w-4 h-4 text-langit-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      {{ session('success') }}
    </div>
  @endif

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-langit-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-langit-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-display text-2xl font-bold text-gray-800">Berita Desa</h1>
        <p class="text-sm text-gray-500">Kelola artikel berita yang tampil di portal publik</p>
      </div>
    </div>
    <a href="{{ route('admin.berita.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-langit-600 hover:bg-langit-700 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Tulis Berita
    </a>
  </div>

  {{-- Filter --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
      <div class="relative flex-1">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
        </svg>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita..."
               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
      </div>
      <select name="kategori" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 bg-white transition-all">
        <option value="">Semua Kategori</option>
        @foreach(['penting' => 'Penting', 'info' => 'Info', 'kegiatan' => 'Kegiatan', 'umum' => 'Umum'] as $val => $label)
          <option value="{{ $val }}" @selected(request('kategori') === $val)>{{ $label }}</option>
        @endforeach
      </select>
      <button type="submit" class="px-4 py-2 bg-langit-600 hover:bg-langit-700 text-white text-sm font-semibold rounded-xl transition-colors">Filter</button>
      @if(request()->hasAny(['q','kategori']))
        <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium rounded-xl transition-colors">Reset</a>
      @endif
    </form>
  </div>

  {{-- Stats strip --}}
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    @php
      $total    = \App\Models\Pengumuman::where('tipe','berita')->count();
      $publik   = \App\Models\Pengumuman::where('tipe','berita')->where('is_published',true)->count();
      $draft    = $total - $publik;
      $bulanIni = \App\Models\Pengumuman::where('tipe','berita')->whereMonth('tanggal_publikasi', now()->month)->count();
    @endphp
    @foreach([['label'=>'Total Berita','val'=>$total,'color'=>'langit'],['label'=>'Publik','val'=>$publik,'color'=>'hijau'],['label'=>'Draft','val'=>$draft,'color'=>'amber'],['label'=>'Bulan Ini','val'=>$bulanIni,'color'=>'langit']] as $s)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-{{ $s['color'] }}-700">{{ $s['val'] }}</div>
      <div class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</div>
    </div>
    @endforeach
  </div>

  {{-- Cards Grid (tampilan majalah) --}}
  @if($items->isNotEmpty())
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($items as $item)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
      {{-- Gambar --}}
      @if($item->gambar)
        <div class="relative h-40 overflow-hidden">
          <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
          {{-- Status badge --}}
          <div class="absolute top-2 right-2">
            <form method="POST" action="{{ route('admin.berita.toggle', $item) }}">
              @csrf @method('PATCH')
              <button type="submit" class="text-xs font-semibold px-2 py-0.5 rounded-full border
                {{ $item->is_published ? 'bg-hijau-600 text-white border-hijau-700' : 'bg-white/90 text-gray-600 border-gray-200' }}">
                {{ $item->is_published ? 'Publik' : 'Draft' }}
              </button>
            </form>
          </div>
        </div>
      @else
        <div class="h-32 bg-gradient-to-br from-langit-100 to-langit-200 flex items-center justify-center relative">
          <svg class="w-12 h-12 text-langit-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
          </svg>
          <div class="absolute top-2 right-2">
            <form method="POST" action="{{ route('admin.berita.toggle', $item) }}">
              @csrf @method('PATCH')
              <button type="submit" class="text-xs font-semibold px-2 py-0.5 rounded-full border
                {{ $item->is_published ? 'bg-hijau-600 text-white border-hijau-700' : 'bg-white/90 text-gray-600 border-gray-200' }}">
                {{ $item->is_published ? 'Publik' : 'Draft' }}
              </button>
            </form>
          </div>
        </div>
      @endif

      {{-- Content --}}
      <div class="p-4">
        <div class="flex items-center gap-2 mb-2">
          @php $kColor = match($item->kategori) { 'penting' => 'red', 'info' => 'amber', 'kegiatan' => 'blue', default => 'gray' }; @endphp
          <span class="badge bg-{{ $kColor }}-100 text-{{ $kColor }}-700">{{ ucfirst($item->kategori) }}</span>
          <span class="text-xs text-gray-400">{{ $item->tanggal_publikasi->format('d M Y') }}</span>
        </div>
        <h3 class="font-semibold text-gray-800 text-sm leading-snug mb-1 line-clamp-2">{{ $item->judul }}</h3>
        @if($item->ringkasan)
          <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $item->ringkasan }}</p>
        @endif
      </div>

      {{-- Actions --}}
      <div class="px-4 pb-4 flex items-center justify-between">
        <span class="text-xs text-gray-400">{{ $item->user->name }}</span>
        <div class="flex items-center gap-1">
          <a href="{{ route('admin.berita.edit', $item) }}"
             class="p-1.5 text-gray-400 hover:text-langit-700 hover:bg-langit-50 rounded-lg transition-all" title="Edit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          </a>
          <form method="POST" action="{{ route('admin.berita.destroy', $item) }}" onsubmit="return confirm('Hapus berita ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  @if($items->hasPages())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4">
      {{ $items->links() }}
    </div>
  @endif

  @else
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm py-20 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
    </svg>
    <p class="text-gray-400 font-medium text-sm">Belum ada berita</p>
    <a href="{{ route('admin.berita.create') }}" class="mt-3 inline-flex items-center gap-1.5 text-sm text-langit-600 hover:text-langit-800 font-semibold">
      + Tulis berita pertama
    </a>
  </div>
  @endif

</div>
</x-admin-layout>
