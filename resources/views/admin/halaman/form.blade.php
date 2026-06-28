<x-admin-layout :title="$halaman ? 'Edit Halaman' : 'Tambah Halaman'">

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet"/>
<style>
  .ql-toolbar  { border-radius: 0.75rem 0.75rem 0 0 !important; border-color: #e5e7eb !important; background: #f9fafb; }
  .ql-container{ border-radius: 0 0 0.75rem 0.75rem !important; border-color: #e5e7eb !important; font-size: 0.875rem; }
  .ql-editor   { min-height: 320px; line-height: 1.75; }
  .ql-editor.ql-blank::before { color: #9ca3af; font-style: normal; }
</style>
@endpush

@php
  $isEdit = (bool) $halaman;
  $action = $isEdit ? route('admin.halaman.update', $halaman) : route('admin.halaman.store');
@endphp

<div class="p-4 sm:p-6">
<div class="max-w-3xl mx-auto space-y-5"
     x-data="{
       preview: '{{ $halaman?->foto ? asset('storage/'.$halaman->foto) : '' }}',
       handleFile(e) {
         const f = e.target.files[0];
         if (f) this.preview = URL.createObjectURL(f);
       },
       slugify(v) {
         return v.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-').replace(/-+/g,'-');
       },
       judul: '{{ old('judul', $halaman?->judul) }}',
       slug: '{{ old('slug', $halaman?->slug) }}',
       slugEdited: {{ (old('slug') || $halaman?->slug) ? 'true' : 'false' }},
       updateSlug() { if (!this.slugEdited) this.slug = this.slugify(this.judul); }
     }">

  {{-- Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.halaman.index') }}"
       class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center">
          <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-gray-800">
          {{ $isEdit ? 'Edit Halaman' : 'Tambah Halaman' }}
        </h1>
      </div>
      <p class="text-sm text-gray-500 mt-0.5 ml-9">{{ $isEdit ? 'Perbarui konten halaman' : 'Buat seksi/halaman baru untuk homepage' }}</p>
    </div>
  </div>

  @if($errors->any())
    <div class="px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
      <p class="font-semibold mb-1">Terdapat kesalahan input:</p>
      <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="halaman-form">
    @csrf
    @if($isEdit) @method('PATCH') @endif

    <div class="space-y-5">

      {{-- Judul, Slug, Urutan --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <h3 class="text-sm font-bold text-gray-700 border-b border-gray-100 pb-2.5">Informasi Halaman</h3>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Halaman <span class="text-red-500">*</span></label>
          <input type="text" name="judul" x-model="judul" @input="updateSlug()"
                 placeholder="Contoh: Visi Misi Desa, Potensi Desa, Program Unggulan..."
                 class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all
                        @error('judul') border-red-400 @else border-gray-200 @enderror"/>
          @error('judul')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
          <div class="sm:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
              Slug <span class="font-normal text-gray-400">(anchor URL · otomatis dari judul)</span>
            </label>
            <div class="flex rounded-xl overflow-hidden border @error('slug') border-red-400 @else border-gray-200 @enderror focus-within:border-langit-400 focus-within:ring-2 focus-within:ring-langit-100 transition-all">
              <span class="px-3 py-2.5 bg-gray-50 text-xs text-gray-400 border-r border-gray-200 whitespace-nowrap flex items-center">#</span>
              <input type="text" name="slug" x-model="slug"
                     @input="slugEdited = true" @blur="slug = slugify(slug)"
                     placeholder="slug-halaman"
                     class="flex-1 px-3 py-2.5 text-sm bg-white focus:outline-none font-mono"/>
            </div>
            @error('slug')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
              Urutan <span class="font-normal text-gray-400">(tampil di home)</span>
            </label>
            <input type="number" name="urutan" value="{{ old('urutan', $halaman?->urutan ?? 0) }}"
                   min="0" max="999"
                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono"/>
            <p class="mt-1 text-xs text-gray-400">0 = paling atas</p>
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Ringkasan <span class="font-normal text-gray-400">(opsional · tampil sebagai intro di homepage)</span>
          </label>
          <textarea name="ringkasan" rows="2"
                    placeholder="Deskripsi singkat yang muncul di bawah judul halaman..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none">{{ old('ringkasan', $halaman?->ringkasan) }}</textarea>
        </div>
      </div>

      {{-- Upload Foto --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <label class="block text-sm font-semibold text-gray-700 mb-3">
          Foto / Gambar Ilustrasi
          <span class="font-normal text-gray-400">(opsional · JPG, PNG, WebP · maks 3MB)</span>
        </label>

        {{-- Preview foto existing + hapus --}}
        @if($halaman?->foto)
          <div x-data="{ removed: false }">
            <div x-show="!removed" class="mb-3 relative inline-block">
              <img src="{{ asset('storage/'.$halaman->foto) }}" alt="Foto"
                   class="h-36 rounded-xl object-cover border border-gray-100 shadow-sm"/>
              <button type="button"
                      @click="if(confirm('Hapus foto ini?')) {
                        removed = true;
                        let f = document.createElement('form');
                        f.method = 'POST';
                        f.action = '{{ route('admin.halaman.hapus-foto', $halaman) }}';
                        f.innerHTML = '<input name=\'_token\' value=\'{{ csrf_token() }}\'><input name=\'_method\' value=\'DELETE\'>';
                        document.body.appendChild(f);
                        f.submit();
                      }"
                      class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-xs shadow">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
            <p x-show="!removed" class="text-xs text-gray-400 mb-3">Upload foto baru untuk mengganti foto di atas.</p>
          </div>
        @endif

        <div class="relative">
          <input type="file" name="foto" accept="image/*" @change="handleFile($event)"
                 class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"/>
          <div class="border-2 border-dashed rounded-xl transition-all"
               :class="preview && preview !== '{{ $halaman?->foto ? asset('storage/'.$halaman->foto) : '' }}'
                       ? 'border-violet-300 bg-violet-50 p-2'
                       : 'border-gray-200 bg-gray-50 p-8 text-center hover:border-violet-300 hover:bg-violet-50'">
            <template x-if="preview && preview !== '{{ $halaman?->foto ? asset('storage/'.$halaman->foto) : '' }}'">
              <div class="relative">
                <img :src="preview" class="w-full max-h-56 object-cover rounded-lg"/>
                <div class="absolute inset-0 bg-black/40 rounded-lg flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                  <p class="text-white text-xs font-semibold">Klik untuk ganti foto</p>
                </div>
              </div>
            </template>
            <template x-if="!preview || preview === '{{ $halaman?->foto ? asset('storage/'.$halaman->foto) : '' }}'">
              <div>
                <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm text-gray-500">Klik atau seret foto ke sini</p>
                <p class="text-xs text-gray-400 mt-1">Foto akan tampil sebagai ilustrasi halaman di homepage</p>
              </div>
            </template>
          </div>
        </div>
        @error('foto')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>

      {{-- Isi Halaman (Quill) --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
          Isi / Konten Halaman <span class="text-red-500">*</span>
        </label>
        <div id="quill-halaman" class="@error('isi') ring-2 ring-red-300 rounded-b-xl @enderror"></div>
        <input type="hidden" name="isi" id="isi-input"/>
        @error('isi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>

      {{-- Status & Submit --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div x-data="{ pub: {{ old('is_published', $halaman?->is_published ?? false) ? 'true' : 'false' }} }">
          <div class="flex items-center gap-3">
            <input type="hidden" name="is_published" :value="pub ? '1' : '0'"/>
            <button type="button" @click="pub = !pub"
                    :class="pub ? 'bg-hijau-600' : 'bg-gray-300'"
                    class="relative inline-flex h-6 w-11 rounded-full transition-colors flex-shrink-0">
              <span :class="pub ? 'translate-x-5' : 'translate-x-0.5'"
                    class="inline-block mt-1 w-4 h-4 bg-white rounded-full shadow transition-transform"></span>
            </button>
            <div>
              <p class="text-sm font-semibold text-gray-800"
                 :class="pub ? 'text-hijau-800' : 'text-gray-800'"
                 x-text="pub ? 'Terbitkan langsung' : 'Simpan sebagai draft'"></p>
              <p class="text-xs text-gray-400">Halaman terbit akan muncul di homepage</p>
            </div>
          </div>
        </div>
        <div class="flex gap-3 flex-shrink-0">
          <a href="{{ route('admin.halaman.index') }}"
             class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">
            Batal
          </a>
          <button type="submit"
                  class="px-6 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Halaman' }}
          </button>
        </div>
      </div>

    </div>
  </form>
</div>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
  const quill = new Quill('#quill-halaman', {
    theme: 'snow',
    placeholder: 'Tulis isi konten halaman di sini...',
    modules: {
      toolbar: [
        [{ header: [2, 3, false] }],
        ['bold', 'italic', 'underline'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        [{ align: [] }],
        ['blockquote', 'link', 'image'],
        ['clean'],
      ]
    }
  });

  @if(old('isi') || $halaman?->isi)
    quill.clipboard.dangerouslyPasteHTML(0, {!! json_encode(old('isi', $halaman?->isi)) !!});
  @endif

  document.getElementById('halaman-form').addEventListener('submit', function () {
    document.getElementById('isi-input').value = quill.root.innerHTML;
  });
</script>
@endpush

</x-admin-layout>
