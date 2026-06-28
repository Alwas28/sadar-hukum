<x-admin-layout title="Edit Berita">

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet"/>
<style>
  .ql-container { font-size: 0.875rem; border-radius: 0 0 0.75rem 0.75rem !important; }
  .ql-toolbar { border-radius: 0.75rem 0.75rem 0 0 !important; background: #f9fafb; }
  .ql-container.ql-snow, .ql-toolbar.ql-snow { border-color: #e5e7eb; }
  .ql-editor { min-height: 280px; line-height: 1.75; }
  .ql-editor.ql-blank::before { color: #9ca3af; font-style: normal; }
</style>
@endpush

<div class="p-4 sm:p-6">
  <div class="max-w-3xl mx-auto space-y-5">

    <div class="flex items-center gap-3">
      <a href="{{ route('admin.berita.index') }}"
         class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </a>
      <div>
        <div class="flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-langit-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-langit-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
          </div>
          <h1 class="font-display text-2xl font-bold text-gray-800">Edit Berita</h1>
        </div>
        <p class="text-sm text-gray-500 mt-0.5 ml-9">Perbarui artikel berita di portal publik desa</p>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.berita.update', $pengumuman) }}" enctype="multipart/form-data" id="berita-form"
          x-data="{
            preview: null,
            handleFile(e) { const f = e.target.files[0]; if (f) this.preview = URL.createObjectURL(f); },
            slugify(v) {
              return v.toLowerCase()
                .replace(/[^a-z0-9\s-]/g,'')
                .trim().replace(/\s+/g,'-').replace(/-+/g,'-');
            },
            judul: '{{ old('judul', $pengumuman->judul) }}',
            slug: '{{ old('slug', $pengumuman->slug) }}',
            slugEdited: true,
            updateSlug() { if (!this.slugEdited) this.slug = this.slugify(this.judul); }
          }">
      @csrf
      @method('PATCH')
      <input type="hidden" name="tipe" value="berita"/>

      <div class="grid gap-5">

        {{-- Kategori & Tanggal --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-2 gap-2">
              @foreach(['penting' => 'Penting', 'info' => 'Info', 'kegiatan' => 'Kegiatan', 'umum' => 'Umum'] as $val => $label)
              <label class="relative cursor-pointer">
                <input type="radio" name="kategori" value="{{ $val }}"
                       {{ old('kategori', $pengumuman->kategori) === $val ? 'checked' : '' }} class="peer sr-only"/>
                <div class="text-center py-2 px-2 text-xs font-semibold rounded-xl border-2 border-gray-200
                            peer-checked:border-langit-500 peer-checked:bg-langit-50 peer-checked:text-langit-700
                            hover:border-gray-300 transition-all">{{ $label }}</div>
              </label>
              @endforeach
            </div>
            @error('kategori')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Terbit <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal_publikasi"
                   value="{{ old('tanggal_publikasi', $pengumuman->tanggal_publikasi->format('Y-m-d')) }}"
                   class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all
                          {{ $errors->has('tanggal_publikasi') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('tanggal_publikasi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
        </div>

        {{-- Judul, Slug & Ringkasan --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
            <input type="text" name="judul" x-model="judul" @input="updateSlug()"
                   placeholder="Tulis judul berita yang menarik..."
                   class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all
                          {{ $errors->has('judul') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('judul')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
              Slug <span class="font-normal text-gray-400">(URL berita)</span>
            </label>
            <div class="flex rounded-xl overflow-hidden border {{ $errors->has('slug') ? 'border-red-400' : 'border-gray-200' }} focus-within:border-langit-400 focus-within:ring-2 focus-within:ring-langit-100 transition-all">
              <span class="px-3 py-2.5 bg-gray-50 text-xs text-gray-400 border-r border-gray-200 whitespace-nowrap flex items-center">berita/</span>
              <input type="text" name="slug" x-model="slug" @input="slugEdited = true" @blur="slug = slugify(slug)"
                     class="flex-1 px-3 py-2.5 text-sm bg-white focus:outline-none"/>
            </div>
            @error('slug')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
              Lead / Ringkasan <span class="font-normal text-gray-400">(tampil di kartu berita)</span>
            </label>
            <textarea name="ringkasan" rows="2" placeholder="Paragraf pembuka yang merangkum isi berita..."
                      class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none">{{ old('ringkasan', $pengumuman->ringkasan) }}</textarea>
          </div>
        </div>

        {{-- Upload Foto Utama --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <label class="block text-sm font-semibold text-gray-700 mb-3">
            Foto Utama <span class="font-normal text-gray-400">(JPG, PNG, WebP · maks 2MB · kosongkan untuk tetap pakai foto lama)</span>
          </label>
          @if($pengumuman->gambar)
          <div class="mb-3">
            <p class="text-xs text-gray-400 mb-1.5">Foto saat ini:</p>
            <img src="{{ Storage::url($pengumuman->gambar) }}" class="h-32 rounded-xl object-cover"/>
          </div>
          @endif
          <div class="relative">
            <input type="file" name="gambar" accept="image/*" @change="handleFile($event)"
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"/>
            <div class="border-2 border-dashed rounded-xl transition-all"
                 :class="preview ? 'border-langit-300 bg-langit-50 p-2' : 'border-gray-200 bg-gray-50 p-6 text-center hover:border-langit-300 hover:bg-langit-50'">
              <template x-if="preview">
                <div class="relative">
                  <img :src="preview" class="w-full max-h-64 object-cover rounded-lg"/>
                  <div class="absolute inset-0 bg-black/40 rounded-lg flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                    <p class="text-white text-xs font-semibold">Klik untuk ganti foto</p>
                  </div>
                </div>
              </template>
              <template x-if="!preview">
                <div>
                  <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <p class="text-sm text-gray-500">Klik untuk ganti foto</p>
                </div>
              </template>
            </div>
          </div>
          @error('gambar')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Isi Berita (Quill) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Isi Berita <span class="text-red-500">*</span></label>
          <div id="quill-editor" class="{{ $errors->has('isi') ? 'ring-2 ring-red-300 rounded-b-xl' : '' }}"></div>
          <input type="hidden" name="isi" id="isi-input"/>
          @error('isi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Status & Submit --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <label class="flex items-start gap-3 cursor-pointer">
            <div class="relative mt-0.5">
              <input type="hidden" name="is_published" value="0"/>
              <input type="checkbox" name="is_published" value="1" class="sr-only peer"
                     {{ old('is_published', $pengumuman->is_published) ? 'checked' : '' }}/>
              <div class="w-10 h-6 bg-gray-200 peer-checked:bg-langit-500 rounded-full transition-colors"></div>
              <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
            </div>
            <div>
              <p class="text-sm font-semibold text-gray-800">Terbitkan langsung</p>
              <p class="text-xs text-gray-400">Jika dimatikan, tersimpan sebagai draft</p>
            </div>
          </label>
          <div class="flex gap-3 flex-shrink-0">
            <a href="{{ route('admin.berita.index') }}"
               class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">Batal</a>
            <button type="submit"
                    class="px-5 py-2.5 bg-langit-600 hover:bg-langit-700 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
              Simpan Perubahan
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
  const quill = new Quill('#quill-editor', {
    theme: 'snow',
    placeholder: 'Tulis isi lengkap berita di sini...',
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

  quill.root.innerHTML = {!! json_encode(old('isi', $pengumuman->isi)) !!};

  document.getElementById('berita-form').addEventListener('submit', function () {
    document.getElementById('isi-input').value = quill.root.innerHTML;
  });
</script>
@endpush

</x-admin-layout>
