<x-admin-layout title="Edit Pengumuman">

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
      <a href="{{ route('admin.pengumuman.index') }}"
         class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </a>
      <div>
        <div class="flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-hijau-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-hijau-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
          </div>
          <h1 class="font-display text-2xl font-bold text-gray-800">Edit Pengumuman</h1>
        </div>
        <p class="text-sm text-gray-500 mt-0.5 ml-9 truncate max-w-sm">{{ $pengumuman->judul }}</p>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.pengumuman.update', $pengumuman) }}" enctype="multipart/form-data" id="pengumuman-form"
          x-data="{
            preview: {{ $pengumuman->gambar ? json_encode(Storage::url($pengumuman->gambar)) : 'null' }},
            handleFile(e) { const f = e.target.files[0]; if (f) this.preview = URL.createObjectURL(f); }
          }">
      @csrf
      @method('PATCH')
      <input type="hidden" name="tipe" value="pengumuman"/>

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
                            peer-checked:border-hijau-500 peer-checked:bg-hijau-50 peer-checked:text-hijau-700
                            hover:border-gray-300 transition-all">{{ $label }}</div>
              </label>
              @endforeach
            </div>
            @error('kategori')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Publikasi <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal_publikasi"
                   value="{{ old('tanggal_publikasi', $pengumuman->tanggal_publikasi->format('Y-m-d')) }}"
                   class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all
                          {{ $errors->has('tanggal_publikasi') ? 'border-red-400' : 'border-gray-200' }}"/>
            @error('tanggal_publikasi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
        </div>

        {{-- Judul --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
          <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}"
                 placeholder="Tulis judul pengumuman..."
                 class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all
                        {{ $errors->has('judul') ? 'border-red-400' : 'border-gray-200' }}"/>
          @error('judul')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Isi Pengumuman (Quill) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Isi Pengumuman <span class="text-red-500">*</span></label>
          <div id="quill-editor" class="{{ $errors->has('isi') ? 'ring-2 ring-red-300 rounded-b-xl' : '' }}"></div>
          <input type="hidden" name="isi" id="isi-input"/>
          @error('isi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Upload Gambar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <label class="block text-sm font-semibold text-gray-700 mb-3">
            Foto Pendukung <span class="font-normal text-gray-400">(JPG, PNG, WebP · maks 2MB · kosongkan untuk tetap pakai foto lama)</span>
          </label>
          <div class="relative">
            <input type="file" name="gambar" accept="image/*" @change="handleFile($event)"
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"/>
            <div class="border-2 border-dashed rounded-xl transition-all"
                 :class="preview ? 'border-hijau-300 bg-hijau-50 p-2' : 'border-gray-200 bg-gray-50 p-8 text-center hover:border-hijau-300 hover:bg-hijau-50'">
              <template x-if="preview">
                <div class="relative">
                  <img :src="preview" class="w-full max-h-52 object-cover rounded-lg"/>
                  <div class="absolute inset-0 bg-black/40 rounded-lg flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                    <p class="text-white text-xs font-semibold">Klik untuk ganti</p>
                  </div>
                </div>
              </template>
              <template x-if="!preview">
                <div>
                  <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <p class="text-sm text-gray-500">Klik atau seret gambar ke sini</p>
                </div>
              </template>
            </div>
          </div>
          @error('gambar')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Status & Submit --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <label class="flex items-start gap-3 cursor-pointer">
            <div class="relative mt-0.5">
              <input type="hidden" name="is_published" value="0"/>
              <input type="checkbox" name="is_published" value="1" class="sr-only peer"
                     {{ old('is_published', $pengumuman->is_published) ? 'checked' : '' }}/>
              <div class="w-10 h-6 bg-gray-200 peer-checked:bg-hijau-500 rounded-full transition-colors"></div>
              <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
            </div>
            <div>
              <p class="text-sm font-semibold text-gray-800">Publikasikan</p>
              <p class="text-xs text-gray-400">Status saat ini:
                <span class="{{ $pengumuman->is_published ? 'text-hijau-600' : 'text-gray-400' }} font-medium">
                  {{ $pengumuman->is_published ? 'Publik' : 'Draft' }}
                </span>
              </p>
            </div>
          </label>
          <div class="flex gap-3 flex-shrink-0">
            <a href="{{ route('admin.pengumuman.index') }}"
               class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">Batal</a>
            <button type="submit"
                    class="px-5 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
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
    placeholder: 'Tulis isi lengkap pengumuman di sini...',
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

  document.getElementById('pengumuman-form').addEventListener('submit', function () {
    document.getElementById('isi-input').value = quill.root.innerHTML;
  });
</script>
@endpush

</x-admin-layout>
