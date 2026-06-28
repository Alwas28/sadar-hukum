<x-admin-layout title="Detail Perdes">

@if($perdes->status === 'draft')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet"/>
<style>
  .ql-container { font-size: 0.875rem; border-radius: 0 0 0.75rem 0.75rem !important; }
  .ql-toolbar { border-radius: 0.75rem 0.75rem 0 0 !important; background: #f9fafb; }
  .ql-container.ql-snow, .ql-toolbar.ql-snow { border-color: #e5e7eb; }
  .ql-editor { min-height: 320px; line-height: 1.75; }
</style>
@endpush
@else
@push('styles')
<style>
  .perdes-isi h2 { text-align: center; font-size: 1.05rem; font-weight: 700; text-transform: uppercase; color: #1f2937; margin: 1.25em 0 0.3em; }
  .perdes-isi h3 { text-align: center; font-size: 0.95rem; font-weight: 700; color: #1f2937; margin: 0.9em 0 0.6em; }
  .perdes-isi p { margin: 0.6em 0; line-height: 1.7; text-align: justify; }
  .perdes-isi p + ol, .perdes-isi p + ul { margin-top: 2px; }
  .perdes-isi ol, .perdes-isi ul { margin: 2px 0 0.75em; padding-left: 1.75em; }
  .perdes-isi ol[type="a"] { list-style-type: lower-alpha; }
  .perdes-isi ol[type="1"] { list-style-type: decimal; }
  .perdes-isi ol li, .perdes-isi ul li { margin-bottom: 0.4em; text-align: justify; }
  .perdes-isi blockquote { border-left: 3px solid #d1d5db; padding-left: 1em; color: #6b7280; margin: 0.75em 0; }
</style>
@endpush
@endif

<div class="p-4 sm:p-6">
  <div class="max-w-3xl mx-auto space-y-5">

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
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.perdes.index') }}"
         class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </a>
      <div class="min-w-0 flex-1">
        <div class="flex items-center gap-2">
          <span class="badge badge-langit">{{ \App\Models\Perdes::jenisLabel($perdes->jenis) }}</span>
          <span class="badge {{ $perdes->status === 'selesai' ? 'badge-berlaku' : 'badge-draft' }}">
            {{ $perdes->status === 'selesai' ? 'Selesai' : 'Draft' }}
          </span>
        </div>
        @if($perdes->status === 'draft')
          <p class="text-xs text-gray-400 mt-1">Disimpan oleh {{ $perdes->user->name }} · {{ $perdes->created_at->format('d M Y, H:i') }} · masih dapat disunting</p>
        @else
          <h1 class="font-display text-xl font-bold text-gray-800 mt-1 truncate">{{ $perdes->judul }}</h1>
          <p class="text-xs text-gray-400 mt-0.5">Disimpan oleh {{ $perdes->user->name }} · {{ $perdes->created_at->format('d M Y, H:i') }}</p>
        @endif
      </div>
      <div class="flex items-center gap-2 flex-shrink-0">
        <form method="POST" action="{{ route('admin.perdes.toggle', $perdes) }}">
          @csrf @method('PATCH')
          <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 border text-sm font-semibold rounded-xl transition-colors
            {{ $perdes->status === 'selesai' ? 'border-gray-200 text-gray-600 hover:bg-gray-50' : 'border-hijau-200 text-hijau-700 bg-hijau-50 hover:bg-hijau-100' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $perdes->status === 'selesai' ? 'Kembalikan ke Draft' : 'Tandai Selesai' }}
          </button>
        </form>
        <a href="{{ route('admin.perdes.pdf', $perdes) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 9V7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v0"/>
          </svg>
          Unduh PDF
        </a>
      </div>
    </div>

    @if($perdes->status === 'draft')
      {{-- Mode edit: peraturan masih draft, isi & judul dapat disunting --}}
      <form method="POST" action="{{ route('admin.perdes.update', $perdes) }}" id="perdes-edit-form" class="space-y-5">
        @csrf @method('PATCH')

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul</label>
          <input type="text" name="judul" value="{{ old('judul', $perdes->judul) }}"
                 class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all"/>
          @error('judul')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Isi Peraturan</label>
          <div id="quill-edit"></div>
          <input type="hidden" name="isi" id="isi-input"/>
          @error('isi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end">
          <button type="submit"
                  class="inline-flex items-center gap-2 px-6 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan Perubahan
          </button>
        </div>
      </form>
    @else
      {{-- Mode baca: peraturan sudah selesai, tidak dapat diedit --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 perdes-isi text-sm text-gray-700">
        {!! $perdes->isi !!}
      </div>
    @endif

    {{-- ═══ PANEL SUARA WARGA (hanya untuk draft) ═══ --}}
    @if($perdes->status === 'draft' && $voteSummary !== null)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-lg bg-langit-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-langit-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-gray-700">Suara Warga</h3>
            <p class="text-xs text-gray-400">{{ $voteSummary['total'] }} suara masuk</p>
          </div>
        </div>
        <a href="{{ route('partisipasi.show', $perdes) }}" target="_blank"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-langit-600 hover:text-langit-800 bg-langit-50 hover:bg-langit-100 px-3 py-1.5 rounded-lg transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
          Buka Halaman Voting
        </a>
      </div>

      @if($voteSummary['total'] === 0)
        <div class="px-5 py-10 text-center">
          <p class="text-sm text-gray-400">Belum ada suara yang masuk.</p>
          <p class="text-xs text-gray-400 mt-1">Bagikan tautan halaman voting kepada warga.</p>
        </div>
      @else
        {{-- Summary Bar --}}
        <div class="px-5 py-4 grid grid-cols-3 gap-4 border-b border-gray-100">
          <div class="text-center p-3 bg-hijau-50 rounded-xl border border-hijau-100">
            <div class="text-2xl font-display font-black text-hijau-700">{{ $voteSummary['setuju'] }}</div>
            <div class="text-xs text-hijau-600 font-semibold mt-0.5">Setuju</div>
            <div class="text-xs text-hijau-500">{{ $voteSummary['pct_setuju'] }}%</div>
          </div>
          <div class="text-center p-3 bg-red-50 rounded-xl border border-red-100">
            <div class="text-2xl font-display font-black text-red-600">{{ $voteSummary['menolak'] }}</div>
            <div class="text-xs text-red-600 font-semibold mt-0.5">Menolak</div>
            <div class="text-xs text-red-500">{{ $voteSummary['pct_menolak'] }}%</div>
          </div>
          <div class="text-center p-3 bg-amber-50 rounded-xl border border-amber-100">
            <div class="text-2xl font-display font-black text-amber-600">{{ $voteSummary['perbaikan'] }}</div>
            <div class="text-xs text-amber-700 font-semibold mt-0.5">Perbaikan</div>
            <div class="text-xs text-amber-500">{{ $voteSummary['pct_perbaikan'] }}%</div>
          </div>
        </div>

        {{-- Progress bar --}}
        <div class="px-5 py-3 border-b border-gray-100">
          <div class="flex h-3 rounded-full overflow-hidden gap-0.5">
            @if($voteSummary['pct_setuju'] > 0)
              <div class="bg-hijau-500 transition-all" style="width:{{ $voteSummary['pct_setuju'] }}%"></div>
            @endif
            @if($voteSummary['pct_menolak'] > 0)
              <div class="bg-red-400 transition-all" style="width:{{ $voteSummary['pct_menolak'] }}%"></div>
            @endif
            @if($voteSummary['pct_perbaikan'] > 0)
              <div class="bg-amber-400 transition-all" style="width:{{ $voteSummary['pct_perbaikan'] }}%"></div>
            @endif
          </div>
          <div class="flex text-xs text-gray-400 mt-1.5 gap-4">
            <span class="flex items-center gap-1"><span class="w-2 h-2 bg-hijau-500 rounded-full"></span> Setuju</span>
            <span class="flex items-center gap-1"><span class="w-2 h-2 bg-red-400 rounded-full"></span> Menolak</span>
            <span class="flex items-center gap-1"><span class="w-2 h-2 bg-amber-400 rounded-full"></span> Perbaikan</span>
          </div>
        </div>

        {{-- Tabel daftar suara --}}
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50">
                <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama / NIK</th>
                <th class="text-left px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Suara</th>
                <th class="text-left px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Catatan</th>
                <th class="text-right px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Waktu</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              @foreach($voteList as $v)
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3">
                  <p class="font-semibold text-gray-800 text-xs">{{ $v->nama }}</p>
                  <p class="text-xs text-gray-400 font-mono">{{ $v->nikCensored() }}</p>
                </td>
                <td class="px-3 py-3">
                  @php
                    $badgeClass = match($v->suara) {
                        'setuju'  => 'bg-hijau-100 text-hijau-700 border-hijau-200',
                        'menolak' => 'bg-red-100 text-red-700 border-red-200',
                        default   => 'bg-amber-100 text-amber-700 border-amber-200',
                    };
                  @endphp
                  <span class="inline-flex items-center text-xs font-semibold px-2.5 py-0.5 rounded-full border {{ $badgeClass }}">
                    {{ \App\Models\PerdesVote::suaraLabel($v->suara) }}
                  </span>
                </td>
                <td class="px-3 py-3 hidden md:table-cell text-xs text-gray-500 max-w-xs">
                  <span class="line-clamp-2">{{ $v->alasan ?? '—' }}</span>
                </td>
                <td class="px-5 py-3 text-right text-xs text-gray-400 whitespace-nowrap">
                  {{ $v->created_at->locale('id')->isoFormat('D MMM, HH:mm') }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if($voteList->hasPages())
          <div class="px-5 py-3 border-t border-gray-100">{{ $voteList->links() }}</div>
        @endif
      @endif
    </div>
    @endif

    <div class="flex justify-end">
      <form method="POST" action="{{ route('admin.perdes.destroy', $perdes) }}" onsubmit="return confirm('Hapus draf ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-xl transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          Hapus Draf
        </button>
      </form>
    </div>

  </div>
</div>

@if($perdes->status === 'draft')
@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
  const quillEdit = new Quill('#quill-edit', {
    theme: 'snow',
    modules: {
      toolbar: [
        [{ header: [2, 3, false] }],
        ['bold', 'italic', 'underline'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['blockquote', 'link'],
        ['clean']
      ]
    }
  });

  // dangerouslyPasteHTML correctly converts HTML → Quill Delta format
  // (root.innerHTML bypass causes content loss on Quill normalization)
  quillEdit.clipboard.dangerouslyPasteHTML(0, {!! json_encode(old('isi', $perdes->isi)) !!});

  document.getElementById('perdes-edit-form').addEventListener('submit', function () {
    document.getElementById('isi-input').value = quillEdit.root.innerHTML;
  });
</script>
@endpush
@endif

</x-admin-layout>
