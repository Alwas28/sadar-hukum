<x-admin-layout title="Status IDM">

@php
$colorMap = [
    'Sangat Tertinggal' => ['bg' => 'bg-red-100',    'text' => 'text-red-700',    'border' => 'border-red-200',    'dot' => 'bg-red-500'],
    'Tertinggal'        => ['bg' => 'bg-orange-100',  'text' => 'text-orange-700', 'border' => 'border-orange-200', 'dot' => 'bg-orange-500'],
    'Berkembang'        => ['bg' => 'bg-yellow-100',  'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'dot' => 'bg-yellow-500'],
    'Maju'              => ['bg' => 'bg-langit-100',  'text' => 'text-langit-700', 'border' => 'border-langit-200', 'dot' => 'bg-langit-500'],
    'Mandiri'           => ['bg' => 'bg-hijau-100',   'text' => 'text-hijau-700',  'border' => 'border-hijau-200',  'dot' => 'bg-hijau-500'],
];
@endphp

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
      <div class="w-10 h-10 rounded-xl bg-emas-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-emas-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-display text-2xl font-bold text-gray-800">Status IDM</h1>
        <p class="text-sm text-gray-500">Indeks Desa Membangun — rekap per tahun</p>
      </div>
    </div>
    <a href="{{ route('admin.idm.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Input Data IDM
    </a>
  </div>

  {{-- Card IDM Terakhir --}}
  @if($latest)
  @php $c = $colorMap[$latest->status] ?? $colorMap['Berkembang']; @endphp
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
      <div>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">IDM Terkini</p>
        <p class="text-lg font-bold text-gray-800 mt-0.5">Tahun {{ $latest->tahun }}</p>
      </div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-bold {{ $c['bg'] }} {{ $c['text'] }} border {{ $c['border'] }}">
        <span class="w-2 h-2 rounded-full {{ $c['dot'] }}"></span>
        {{ $latest->status }}
      </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
      <div class="text-center p-4 bg-gray-50 rounded-xl">
        <div class="text-2xl font-display font-black text-gray-800">{{ number_format($latest->skor_idm, 4) }}</div>
        <div class="text-xs text-gray-500 font-semibold mt-1">Skor IDM</div>
      </div>
      <div class="text-center p-4 bg-gray-50 rounded-xl">
        <div class="text-2xl font-display font-black text-langit-700">{{ number_format($latest->skor_iks, 4) }}</div>
        <div class="text-xs text-gray-500 font-semibold mt-1">IKS <span class="block text-gray-400 font-normal">Ketahanan Sosial</span></div>
      </div>
      <div class="text-center p-4 bg-gray-50 rounded-xl">
        <div class="text-2xl font-display font-black text-emas-600">{{ number_format($latest->skor_ike, 4) }}</div>
        <div class="text-xs text-gray-500 font-semibold mt-1">IKE <span class="block text-gray-400 font-normal">Ketahanan Ekonomi</span></div>
      </div>
      <div class="text-center p-4 bg-gray-50 rounded-xl">
        <div class="text-2xl font-display font-black text-hijau-700">{{ number_format($latest->skor_ikl, 4) }}</div>
        <div class="text-xs text-gray-500 font-semibold mt-1">IKL <span class="block text-gray-400 font-normal">Ketahanan Lingkungan</span></div>
      </div>
    </div>

    @if($latest->keterangan)
      <p class="mt-4 text-sm text-gray-500 italic border-t border-gray-100 pt-4">{{ $latest->keterangan }}</p>
    @endif
  </div>
  @endif

  {{-- Tabel Riwayat --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
      <h3 class="text-sm font-bold text-gray-700">Riwayat Data IDM</h3>
    </div>

    @if($records->isEmpty())
      <div class="px-5 py-16 text-center">
        <svg class="w-14 h-14 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <p class="text-gray-400 font-medium text-sm">Belum ada data IDM</p>
        <a href="{{ route('admin.idm.create') }}"
           class="mt-3 inline-flex items-center gap-1.5 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">
          + Input Data IDM Pertama
        </a>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tahun</th>
              <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
              <th class="text-right px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Skor IDM</th>
              <th class="text-right px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">IKS</th>
              <th class="text-right px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">IKE</th>
              <th class="text-right px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">IKL</th>
              <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            @foreach($records as $r)
            @php $c = $colorMap[$r->status] ?? $colorMap['Berkembang']; @endphp
            <tr class="hover:bg-gray-50 transition-colors {{ $r->id === $latest?->id ? 'bg-hijau-50/40' : '' }}">
              <td class="px-5 py-3.5">
                <span class="font-bold text-gray-800">{{ $r->tahun }}</span>
                @if($r->id === $latest?->id)
                  <span class="ml-2 text-xs font-semibold text-hijau-600 bg-hijau-100 px-1.5 py-0.5 rounded-md">Terkini</span>
                @endif
              </td>
              <td class="px-3 py-3.5">
                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full {{ $c['bg'] }} {{ $c['text'] }} border {{ $c['border'] }}">
                  <span class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }}"></span>
                  {{ $r->status }}
                </span>
              </td>
              <td class="px-3 py-3.5 text-right font-mono text-sm font-semibold text-gray-700">{{ number_format($r->skor_idm, 4) }}</td>
              <td class="px-3 py-3.5 text-right font-mono text-xs text-gray-500 hidden sm:table-cell">{{ number_format($r->skor_iks, 4) }}</td>
              <td class="px-3 py-3.5 text-right font-mono text-xs text-gray-500 hidden sm:table-cell">{{ number_format($r->skor_ike, 4) }}</td>
              <td class="px-3 py-3.5 text-right font-mono text-xs text-gray-500 hidden sm:table-cell">{{ number_format($r->skor_ikl, 4) }}</td>
              <td class="px-5 py-3.5 text-right">
                <div class="flex items-center justify-end gap-1">
                  <a href="{{ route('admin.idm.edit', $r) }}"
                     class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-hijau-700 bg-hijau-50 hover:bg-hijau-100 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                  </a>
                  <form method="POST" action="{{ route('admin.idm.destroy', $r) }}"
                        onsubmit="return confirm('Hapus data IDM tahun {{ $r->tahun }}?')">
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
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

</div>
</x-admin-layout>
