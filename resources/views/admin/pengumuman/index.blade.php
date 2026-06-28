<x-admin-layout title="Pengumuman Desa">

<div class="p-4 sm:p-6 space-y-5">

  @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
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
      <div class="w-10 h-10 rounded-xl bg-hijau-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-display text-2xl font-bold text-gray-800">Pengumuman Desa</h1>
        <p class="text-sm text-gray-500">Kelola pengumuman resmi yang tampil di halaman publik</p>
      </div>
    </div>
    <a href="{{ route('admin.pengumuman.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Tambah Pengumuman
    </a>
  </div>

  {{-- Filter --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
      <div class="relative flex-1">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
        </svg>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul pengumuman..."
               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all"/>
      </div>
      <select name="kategori" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 bg-white transition-all">
        <option value="">Semua Kategori</option>
        @foreach(['penting' => 'Penting', 'info' => 'Info', 'kegiatan' => 'Kegiatan', 'umum' => 'Umum'] as $val => $label)
          <option value="{{ $val }}" @selected(request('kategori') === $val)>{{ $label }}</option>
        @endforeach
      </select>
      <button type="submit" class="px-4 py-2 bg-hijau-600 hover:bg-hijau-700 text-white text-sm font-semibold rounded-xl transition-colors">Filter</button>
      @if(request()->hasAny(['q','kategori']))
        <a href="{{ route('admin.pengumuman.index') }}" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium rounded-xl transition-colors">Reset</a>
      @endif
    </form>
  </div>

  {{-- Stats strip --}}
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    @php
      $total     = \App\Models\Pengumuman::where('tipe','pengumuman')->count();
      $publik    = \App\Models\Pengumuman::where('tipe','pengumuman')->where('is_published',true)->count();
      $draft     = $total - $publik;
      $bulanIni  = \App\Models\Pengumuman::where('tipe','pengumuman')->whereMonth('tanggal_publikasi', now()->month)->count();
    @endphp
    @foreach([['label'=>'Total','val'=>$total,'color'=>'gray'],['label'=>'Publik','val'=>$publik,'color'=>'hijau'],['label'=>'Draft','val'=>$draft,'color'=>'amber'],['label'=>'Bulan Ini','val'=>$bulanIni,'color'=>'langit']] as $s)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-{{ $s['color'] === 'gray' ? 'gray-700' : $s['color'].'-700' }}">{{ $s['val'] }}</div>
      <div class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</div>
    </div>
    @endforeach
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-gray-50 border-b border-gray-100">
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Pengumuman</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Kategori</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Tanggal</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($items as $item)
          <tr class="hover:bg-gray-50 transition-colors group">
            <td class="px-5 py-3.5">
              <div class="flex items-center gap-3">
                @if($item->gambar)
                  <img src="{{ Storage::url($item->gambar) }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0 hidden sm:block"/>
                @else
                  <div class="w-10 h-10 rounded-lg bg-hijau-100 flex-shrink-0 hidden sm:flex items-center justify-center">
                    <svg class="w-5 h-5 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                  </div>
                @endif
                <div class="min-w-0">
                  <p class="font-semibold text-gray-800 text-sm truncate max-w-xs">{{ $item->judul }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">{{ $item->user->name }}</p>
                </div>
              </div>
            </td>
            <td class="px-3 py-3.5 hidden sm:table-cell">
              @php $kColor = match($item->kategori) { 'penting' => 'red', 'info' => 'amber', 'kegiatan' => 'blue', default => 'gray' }; @endphp
              <span class="badge bg-{{ $kColor }}-100 text-{{ $kColor }}-700">{{ ucfirst($item->kategori) }}</span>
            </td>
            <td class="px-3 py-3.5 text-xs text-gray-500 hidden lg:table-cell whitespace-nowrap">
              {{ $item->tanggal_publikasi->format('d M Y') }}
            </td>
            <td class="px-3 py-3.5">
              <form method="POST" action="{{ route('admin.pengumuman.toggle', $item) }}">
                @csrf @method('PATCH')
                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full border transition-all
                  {{ $item->is_published ? 'bg-hijau-100 text-hijau-700 border-hijau-200 hover:bg-hijau-200' : 'bg-gray-100 text-gray-500 border-gray-200 hover:bg-gray-200' }}">
                  <span class="w-1.5 h-1.5 rounded-full {{ $item->is_published ? 'bg-hijau-500' : 'bg-gray-400' }}"></span>
                  {{ $item->is_published ? 'Publik' : 'Draft' }}
                </button>
              </form>
            </td>
            <td class="px-5 py-3.5 text-right">
              <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="{{ route('admin.pengumuman.edit', $item) }}"
                   class="p-1.5 text-gray-400 hover:text-hijau-700 hover:bg-hijau-50 rounded-lg transition-all" title="Edit">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.pengumuman.destroy', $item) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-5 py-16 text-center">
              <svg class="w-14 h-14 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
              </svg>
              <p class="text-gray-400 font-medium text-sm">Belum ada pengumuman</p>
              <a href="{{ route('admin.pengumuman.create') }}" class="mt-3 inline-flex items-center gap-1.5 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">+ Tambah sekarang</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($items->hasPages())
      <div class="px-5 py-4 border-t border-gray-100">{{ $items->links() }}</div>
    @endif
  </div>

</div>
</x-admin-layout>
