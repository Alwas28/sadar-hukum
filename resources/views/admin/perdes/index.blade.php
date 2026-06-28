<x-admin-layout title="Peraturan Desa">

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
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-display text-2xl font-bold text-gray-800">Peraturan Desa</h1>
        <p class="text-sm text-gray-500">Pantau peraturan yang sudah selesai dan yang masih berupa draf</p>
      </div>
    </div>
    <a href="{{ route('admin.perdes.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Buat Perdes Baru
    </a>
  </div>

  {{-- Stats strip --}}
  <div class="grid grid-cols-3 gap-3">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-gray-700">{{ $counts['total'] }}</div>
      <div class="text-xs text-gray-500 mt-0.5">Total Peraturan</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-hijau-700">{{ $counts['selesai'] }}</div>
      <div class="text-xs text-gray-500 mt-0.5">Selesai</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
      <div class="text-xl font-display font-black text-amber-700">{{ $counts['draft'] }}</div>
      <div class="text-xs text-gray-500 mt-0.5">Draft</div>
    </div>
  </div>

  {{-- Filter tabs --}}
  <div class="flex items-center gap-2">
    @foreach(['' => 'Semua', 'selesai' => 'Selesai', 'draft' => 'Draft'] as $val => $label)
      <a href="{{ route('admin.perdes.index', $val ? ['status' => $val] : []) }}"
         class="px-4 py-1.5 text-xs font-semibold rounded-full border transition-colors
                {{ request('status', '') === $val ? 'bg-hijau-700 text-white border-hijau-700' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-gray-50 border-b border-gray-100">
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Jenis</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Tanggal</th>
            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($perdes as $item)
          <tr class="hover:bg-gray-50 transition-colors group">
            <td class="px-5 py-3.5">
              <div class="min-w-0">
                <p class="font-semibold text-gray-800 text-sm truncate max-w-xs">{{ $item->judul }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $item->user->name }}</p>
              </div>
            </td>
            <td class="px-3 py-3.5 hidden sm:table-cell">
              <span class="badge badge-langit">{{ \App\Models\Perdes::jenisLabel($item->jenis) }}</span>
            </td>
            <td class="px-3 py-3.5 text-xs text-gray-500 hidden lg:table-cell whitespace-nowrap">
              {{ $item->created_at->format('d M Y') }}
            </td>
            <td class="px-3 py-3.5">
              <form method="POST" action="{{ route('admin.perdes.toggle', $item) }}">
                @csrf @method('PATCH')
                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full border transition-all
                  {{ $item->status === 'selesai' ? 'bg-hijau-100 text-hijau-700 border-hijau-200 hover:bg-hijau-200' : 'bg-amber-100 text-amber-700 border-amber-200 hover:bg-amber-200' }}">
                  @if($item->status === 'selesai')
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                  @else
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  @endif
                  {{ $item->status === 'selesai' ? 'Selesai' : 'Draft' }}
                </button>
              </form>
            </td>
            <td class="px-5 py-3.5 text-right">
              <div class="flex items-center justify-end gap-1">
                {{-- Edit / Lihat --}}
                <a href="{{ route('admin.perdes.show', $item) }}"
                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-all
                     {{ $item->status === 'draft' ? 'text-hijau-700 bg-hijau-50 hover:bg-hijau-100' : 'text-gray-500 bg-gray-50 hover:bg-gray-100' }}"
                   title="{{ $item->status === 'draft' ? 'Edit' : 'Lihat' }}">
                  @if($item->status === 'draft')
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                  @else
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat
                  @endif
                </a>
                {{-- PDF --}}
                <a href="{{ route('admin.perdes.pdf', $item) }}"
                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-langit-700 bg-langit-50 hover:bg-langit-100 transition-all"
                   title="Unduh PDF">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 9V7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v0"/></svg>
                  PDF
                </a>
                {{-- Hapus --}}
                <form method="POST" action="{{ route('admin.perdes.destroy', $item) }}" onsubmit="return confirm('Hapus draf ini?')">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition-all"
                          title="Hapus">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-5 py-16 text-center">
              <svg class="w-14 h-14 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <p class="text-gray-400 font-medium text-sm">Belum ada draf regulasi tersimpan</p>
              <a href="{{ route('admin.perdes.create') }}" class="mt-3 inline-flex items-center gap-1.5 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">+ Buat Perdes Baru</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($perdes->hasPages())
      <div class="px-5 py-4 border-t border-gray-100">{{ $perdes->links() }}</div>
    @endif
  </div>

</div>
</x-admin-layout>
