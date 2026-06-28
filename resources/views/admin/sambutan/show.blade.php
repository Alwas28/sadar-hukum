<x-admin-layout title="Detail Sambutan">

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet"/>
<style>
  .ql-toolbar { border-radius: 0.75rem 0.75rem 0 0 !important; border-color: #e5e7eb !important; background: #f9fafb; }
  .ql-container { border-radius: 0 0 0.75rem 0.75rem !important; border-color: #e5e7eb !important; font-size: 0.9rem; min-height: 380px; }
  .ql-editor { min-height: 380px; line-height: 1.8; }
  .ql-editor h3 { font-size: 1rem; font-weight: 700; margin: 1em 0 0.4em; text-align: center; }
  .ql-editor p  { margin: 0.5em 0; text-align: justify; }

  @media print {
    body * { visibility: hidden; }
    #print-area, #print-area * { visibility: visible; }
    #print-area { position: fixed; top: 0; left: 0; width: 100%; padding: 2cm; font-family: 'Times New Roman', serif; }
    #print-area h3 { text-align: center; font-size: 13pt; font-weight: bold; margin: 0.8em 0 0.3em; }
    #print-area p  { text-align: justify; font-size: 12pt; line-height: 1.8; margin: 0.4em 0; }
  }
</style>
@endpush

<div class="p-4 sm:p-6 space-y-5 max-w-4xl">

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
  <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
    <div class="flex items-start gap-3">
      <a href="{{ route('admin.sambutan.index') }}"
         class="mt-1 w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-100 transition-colors flex-shrink-0">
        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </a>
      <div>
        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-700 border border-primary-200 mb-1.5">
          {{ $sambutan->acara }}
        </span>
        <h1 class="font-display text-xl font-bold text-gray-800 leading-snug">{{ $sambutan->judul }}</h1>
        <p class="text-xs text-gray-400 mt-1">
          Dibuat {{ $sambutan->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
          oleh {{ $sambutan->user?->name ?? 'Sistem' }}
        </p>
      </div>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0">
      <button onclick="window.print()"
              class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-100 text-sm font-semibold rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Cetak
      </button>
      <form method="POST" action="{{ route('admin.sambutan.destroy', $sambutan) }}"
            onsubmit="return confirm('Hapus sambutan ini secara permanen?')">
        @csrf @method('DELETE')
        <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 border border-red-200 text-red-600 hover:bg-red-50 text-sm font-semibold rounded-xl transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
          Hapus
        </button>
      </form>
    </div>
  </div>

  {{-- Editor --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
    <div class="flex items-center justify-between mb-3">
      <h3 class="text-sm font-bold text-gray-700">Naskah Sambutan</h3>
      <span class="text-xs text-gray-400">Edit langsung, lalu simpan</span>
    </div>

    <div id="editor-sambutan"></div>

    <form method="POST" action="{{ route('admin.sambutan.update', $sambutan) }}" id="form-save">
      @csrf @method('PATCH')
      <input type="hidden" name="isi" id="isi-input"/>
    </form>

    <div class="mt-4 flex justify-end">
      <button onclick="saveContent()"
              class="inline-flex items-center gap-2 px-6 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Simpan Perubahan
      </button>
    </div>
  </div>
</div>

{{-- Area cetak tersembunyi --}}
<div id="print-area" style="display:none;">
  <h3 style="text-align:center; font-size:14pt; margin-bottom:24pt;">{{ strtoupper($sambutan->judul) }}</h3>
  <div id="print-content"></div>
  <p style="margin-top:40pt; text-align:right;">
    {{ Setting::get('desa_nama', 'Tontonunu') }}, {{ now()->locale('id')->isoFormat('D MMMM Y') }}<br><br>
    <strong>{{ Setting::get('kepala_desa_nama', 'Kepala Desa') }}</strong>
  </p>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
  const quill = new Quill('#editor-sambutan', {
    theme: 'snow',
    modules: {
      toolbar: [
        ['bold', 'italic', 'underline'],
        [{ header: [2, 3, false] }],
        [{ align: [] }],
        ['clean'],
      ]
    }
  });

  quill.clipboard.dangerouslyPasteHTML(0, {!! json_encode($sambutan->isi) !!});

  function saveContent() {
    document.getElementById('isi-input').value = quill.root.innerHTML;
    document.getElementById('form-save').submit();
  }

  window.addEventListener('beforeprint', () => {
    document.getElementById('print-area').style.display = 'block';
    document.getElementById('print-content').innerHTML = quill.root.innerHTML;
  });
  window.addEventListener('afterprint', () => {
    document.getElementById('print-area').style.display = 'none';
  });
</script>
@endpush

</x-admin-layout>
