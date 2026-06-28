<x-admin-layout title="Sambutan Kepala Desa">
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
      <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-display text-2xl font-bold text-gray-800">Sambutan Kepala Desa</h1>
        <p class="text-sm text-gray-500">Riwayat generate sambutan dengan AI</p>
      </div>
    </div>
    <a href="{{ route('admin.sambutan.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      Generate Sambutan
      <span class="ml-1 px-1.5 py-0.5 text-xs bg-emas-500 text-hijau-900 rounded-md font-bold">AI</span>
    </a>
  </div>

  {{-- Grid riwayat --}}
  @if($sambutans->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-20 text-center">
      <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
      </svg>
      <p class="text-gray-400 font-medium">Belum ada sambutan yang di-generate</p>
      <a href="{{ route('admin.sambutan.create') }}"
         class="mt-4 inline-flex items-center gap-1.5 text-sm text-hijau-600 hover:text-hijau-800 font-semibold">
        + Generate Sambutan Pertama
      </a>
    </div>
  @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($sambutans as $s)
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col">
        <div class="p-5 flex-1">
          <div class="flex items-start justify-between gap-2 mb-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-700 border border-primary-200 leading-tight">
              {{ $s->acara }}
            </span>
            <span class="text-xs text-gray-400 flex-shrink-0">{{ $s->created_at->locale('id')->diffForHumans() }}</span>
          </div>
          <h3 class="font-semibold text-gray-800 text-sm leading-snug mb-2 line-clamp-2">{{ $s->judul }}</h3>
          <div class="text-xs text-gray-400 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            {{ $s->user?->name ?? 'Sistem' }}
          </div>
        </div>
        <div class="px-5 pb-4 pt-0 flex items-center gap-2 border-t border-gray-50 mt-1 pt-3">
          <a href="{{ route('admin.sambutan.show', $s) }}"
             class="flex-1 text-center px-3 py-2 text-xs font-semibold text-hijau-700 bg-hijau-50 hover:bg-hijau-100 rounded-lg transition-colors">
            Lihat &amp; Edit
          </a>
          <form method="POST" action="{{ route('admin.sambutan.destroy', $s) }}"
                onsubmit="return confirm('Hapus sambutan ini?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="px-3 py-2 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
      @endforeach
    </div>

    @if($sambutans->hasPages())
      <div>{{ $sambutans->links() }}</div>
    @endif
  @endif

</div>
</x-admin-layout>
