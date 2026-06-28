<x-admin-layout title="Data Penduduk">

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
      <div class="w-10 h-10 rounded-xl bg-langit-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-langit-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-display text-2xl font-bold text-gray-800">Data Penduduk</h1>
        <p class="text-sm text-gray-500">Kelola data kependudukan Desa Tontonunu</p>
      </div>
    </div>
    <a href="{{ route('admin.penduduk.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Tambah Penduduk
    </a>
  </div>

  {{-- Stat Cards --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-gray-700">{{ number_format($stats['total']) }}</div>
      <div class="text-xs text-gray-500 mt-0.5">Total Penduduk</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-langit-700">{{ number_format($stats['laki']) }}</div>
      <div class="text-xs text-gray-500 mt-0.5">Laki-laki</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-pink-600">{{ number_format($stats['perempuan']) }}</div>
      <div class="text-xs text-gray-500 mt-0.5">Perempuan</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-hijau-700">{{ number_format($stats['aktif']) }}</div>
      <div class="text-xs text-gray-500 mt-0.5">Status Aktif</div>
    </div>
  </div>

  {{-- Filter & Search --}}
  <form method="GET" action="{{ route('admin.penduduk.index') }}"
        class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex flex-wrap items-end gap-3">
    <div class="flex-1 min-w-48">
      <label class="block text-xs font-semibold text-gray-500 mb-1">Cari Nama / NIK</label>
      <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
        </svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIK..."
               class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
      </div>
    </div>
    <div>
      <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis Kelamin</label>
      <select name="jenis_kelamin" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
        <option value="">Semua</option>
        <option value="L" @selected(request('jenis_kelamin') === 'L')>Laki-laki</option>
        <option value="P" @selected(request('jenis_kelamin') === 'P')>Perempuan</option>
      </select>
    </div>
    <div>
      <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
      <select name="aktif" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
        <option value="">Semua</option>
        <option value="1" @selected(request('aktif') === '1')>Aktif</option>
        <option value="0" @selected(request('aktif') === '0')>Tidak Aktif</option>
      </select>
    </div>
    <button type="submit"
            class="px-4 py-2 bg-langit-600 hover:bg-langit-700 text-white text-sm font-semibold rounded-xl transition-colors">
      Cari
    </button>
    @if(request()->hasAny(['search','jenis_kelamin','aktif']))
      <a href="{{ route('admin.penduduk.index') }}"
         class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">
        Reset
      </a>
    @endif
  </form>

  {{-- Tabel --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-gray-50 border-b border-gray-100">
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama / NIK</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">TTL</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Alamat</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Agama</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($penduduk as $p)
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-5 py-3.5">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold
                  {{ $p->jenis_kelamin === 'L' ? 'bg-langit-100 text-langit-700' : 'bg-pink-100 text-pink-700' }}">
                  {{ strtoupper(substr($p->nama, 0, 1)) }}
                </div>
                <div class="min-w-0">
                  <p class="font-semibold text-gray-800 text-sm truncate">{{ $p->nama }}</p>
                  <p class="text-xs text-gray-400 font-mono">{{ $p->nik }}</p>
                </div>
              </div>
            </td>
            <td class="px-3 py-3.5 hidden md:table-cell text-xs text-gray-600">
              {{ $p->tempat_lahir }}, {{ $p->tanggal_lahir->locale('id')->isoFormat('D MMM Y') }}<br/>
              <span class="text-gray-400">{{ $p->umur() }} tahun · {{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </td>
            <td class="px-3 py-3.5 hidden lg:table-cell text-xs text-gray-600 max-w-xs">
              <span class="line-clamp-2">{{ $p->alamat }}{{ $p->rt ? ' RT '.$p->rt : '' }}{{ $p->rw ? '/RW '.$p->rw : '' }}</span>
            </td>
            <td class="px-3 py-3.5 hidden sm:table-cell text-xs text-gray-600">
              {{ $p->agama }}<br/>
              <span class="text-gray-400">{{ $p->status_perkawinan }}</span>
            </td>
            <td class="px-3 py-3.5">
              @if($p->aktif)
                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-hijau-100 text-hijau-700 border border-hijau-200">
                  <span class="w-1.5 h-1.5 bg-hijau-500 rounded-full"></span> Aktif
                </span>
              @else
                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                  <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Tidak Aktif
                </span>
              @endif
            </td>
            <td class="px-5 py-3.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <a href="{{ route('admin.penduduk.edit', $p) }}"
                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-hijau-700 bg-hijau-50 hover:bg-hijau-100 transition-all">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  Edit
                </a>
                <form method="POST" action="{{ route('admin.penduduk.destroy', $p) }}"
                      onsubmit="return confirm('Hapus data {{ $p->nama }}?')">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-5 py-16 text-center">
              <svg class="w-14 h-14 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              <p class="text-gray-400 font-medium text-sm">Belum ada data penduduk</p>
              <a href="{{ route('admin.penduduk.create') }}"
                 class="mt-3 inline-flex items-center gap-1.5 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">
                + Tambah Penduduk Pertama
              </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($penduduk->hasPages())
      <div class="px-5 py-4 border-t border-gray-100">{{ $penduduk->links() }}</div>
    @endif
  </div>

</div>
</x-admin-layout>
