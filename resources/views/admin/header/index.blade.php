<x-admin-layout title="Header Homepage">
<div class="p-4 sm:p-6 space-y-6">

  {{-- Page header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-xl font-display font-bold text-gray-900">Header Homepage</h1>
      <p class="text-sm text-gray-500 mt-0.5">Pilih dan atur tampilan header halaman utama website.</p>
    </div>
    <a href="{{ url('/') }}" target="_blank"
       class="inline-flex items-center gap-2 text-sm font-semibold text-langit-600 hover:text-langit-800 bg-langit-50 hover:bg-langit-100 px-3 py-2 rounded-xl transition-colors border border-langit-200">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
      </svg>
      Lihat Website
    </a>
  </div>

  @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-hijau-50 border border-hijau-200 rounded-xl text-sm text-hijau-800 font-medium">
      <svg class="w-5 h-5 text-hijau-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      {{ session('success') }}
    </div>
  @endif

  {{-- ═══ PILIH TIPE HEADER ═══ --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <h2 class="text-sm font-bold text-gray-700 mb-4">Pilih Tipe Header</h2>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

      {{-- Default (Batik) --}}
      <div class="relative rounded-2xl border-2 overflow-hidden transition-all
                  {{ $headerType === 'default' ? 'border-hijau-500 ring-2 ring-hijau-200' : 'border-gray-200' }}">
        @if($headerType === 'default')
          <div class="absolute top-2 right-2 z-10">
            <span class="inline-flex items-center gap-1 text-xs font-bold bg-hijau-600 text-white px-2 py-0.5 rounded-full">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
              Aktif
            </span>
          </div>
        @endif
        <div class="h-28 bg-gradient-to-br from-hijau-700 via-hijau-800 to-hijau-900 flex items-center justify-center">
          <svg class="w-10 h-10 text-emas-400/60" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
        </div>
        <div class="p-3">
          <p class="text-xs font-bold text-gray-800">Batik (Default)</p>
          <p class="text-xs text-gray-400 mt-0.5 leading-snug">Background hijau berpola, tanpa media.</p>
          @if($headerType !== 'default')
            <form method="POST" action="{{ route('admin.header.aktifkan') }}" class="mt-2">
              @csrf
              <input type="hidden" name="type" value="default"/>
              <button class="w-full text-xs font-semibold py-1.5 rounded-lg border border-hijau-300 text-hijau-700 hover:bg-hijau-50 transition-colors">
                Aktifkan
              </button>
            </form>
          @endif
        </div>
      </div>

      {{-- Gambar --}}
      <div class="relative rounded-2xl border-2 overflow-hidden transition-all
                  {{ $headerType === 'image' ? 'border-hijau-500 ring-2 ring-hijau-200' : 'border-gray-200' }}">
        @if($headerType === 'image')
          <div class="absolute top-2 right-2 z-10">
            <span class="inline-flex items-center gap-1 text-xs font-bold bg-hijau-600 text-white px-2 py-0.5 rounded-full">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
              Aktif
            </span>
          </div>
        @endif
        <div class="h-28 bg-gray-200 overflow-hidden relative">
          @if($headerImage)
            <img src="{{ asset('storage/'.$headerImage) }}" class="w-full h-full object-cover"/>
            <div class="absolute inset-0 bg-hijau-900/50"></div>
          @else
            <div class="w-full h-full flex items-center justify-center">
              <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
          @endif
        </div>
        <div class="p-3">
          <p class="text-xs font-bold text-gray-800">Gambar</p>
          <p class="text-xs text-gray-400 mt-0.5 leading-snug">Satu foto sebagai latar belakang.</p>
          @if($headerType !== 'image')
            <form method="POST" action="{{ route('admin.header.aktifkan') }}" class="mt-2">
              @csrf
              <input type="hidden" name="type" value="image"/>
              <button class="w-full text-xs font-semibold py-1.5 rounded-lg border border-hijau-300 text-hijau-700 hover:bg-hijau-50 transition-colors">
                Aktifkan
              </button>
            </form>
          @endif
        </div>
      </div>

      {{-- Slideshow --}}
      <div class="relative rounded-2xl border-2 overflow-hidden transition-all
                  {{ $headerType === 'slideshow' ? 'border-hijau-500 ring-2 ring-hijau-200' : 'border-gray-200' }}">
        @if($headerType === 'slideshow')
          <div class="absolute top-2 right-2 z-10">
            <span class="inline-flex items-center gap-1 text-xs font-bold bg-hijau-600 text-white px-2 py-0.5 rounded-full">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
              Aktif
            </span>
          </div>
        @endif
        <div class="h-28 bg-gray-200 overflow-hidden relative">
          @if(count($headerSlides))
            <img src="{{ asset('storage/'.$headerSlides[0]) }}" class="w-full h-full object-cover"/>
            <div class="absolute inset-0 bg-hijau-900/50 flex items-center justify-center">
              <span class="text-white text-xs font-bold bg-black/30 px-2 py-1 rounded-full">{{ count($headerSlides) }} slide</span>
            </div>
          @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-1">
              <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
              </svg>
              <span class="text-xs text-gray-400">Belum ada slide</span>
            </div>
          @endif
        </div>
        <div class="p-3">
          <p class="text-xs font-bold text-gray-800">Slideshow</p>
          <p class="text-xs text-gray-400 mt-0.5 leading-snug">Beberapa foto berganti otomatis.</p>
          @if($headerType !== 'slideshow')
            <form method="POST" action="{{ route('admin.header.aktifkan') }}" class="mt-2">
              @csrf
              <input type="hidden" name="type" value="slideshow"/>
              <button class="w-full text-xs font-semibold py-1.5 rounded-lg border border-hijau-300 text-hijau-700 hover:bg-hijau-50 transition-colors">
                Aktifkan
              </button>
            </form>
          @endif
        </div>
      </div>

      {{-- Video --}}
      <div class="relative rounded-2xl border-2 overflow-hidden transition-all
                  {{ $headerType === 'video' ? 'border-hijau-500 ring-2 ring-hijau-200' : 'border-gray-200' }}">
        @if($headerType === 'video')
          <div class="absolute top-2 right-2 z-10">
            <span class="inline-flex items-center gap-1 text-xs font-bold bg-hijau-600 text-white px-2 py-0.5 rounded-full">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
              Aktif
            </span>
          </div>
        @endif
        <div class="h-28 bg-gray-200 overflow-hidden relative">
          @if($headerPoster)
            <img src="{{ asset('storage/'.$headerPoster) }}" class="w-full h-full object-cover"/>
            <div class="absolute inset-0 bg-hijau-900/50 flex items-center justify-center">
              <svg class="w-10 h-10 text-white/80" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
          @elseif($headerVideo)
            <div class="w-full h-full flex flex-col items-center justify-center gap-1 bg-gray-800">
              <svg class="w-10 h-10 text-white/50" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
              <span class="text-xs text-white/50">Video terupload</span>
            </div>
          @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-1">
              <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.697v6.606a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
              </svg>
              <span class="text-xs text-gray-400">Belum ada video</span>
            </div>
          @endif
        </div>
        <div class="p-3">
          <p class="text-xs font-bold text-gray-800">Video Background</p>
          <p class="text-xs text-gray-400 mt-0.5 leading-snug">Video loop sebagai latar belakang.</p>
          @if($headerType !== 'video')
            <form method="POST" action="{{ route('admin.header.aktifkan') }}" class="mt-2">
              @csrf
              <input type="hidden" name="type" value="video"/>
              <button class="w-full text-xs font-semibold py-1.5 rounded-lg border border-hijau-300 text-hijau-700 hover:bg-hijau-50 transition-colors">
                Aktifkan
              </button>
            </form>
          @endif
        </div>
      </div>

    </div>
  </div>

  {{-- ═══ PENGATURAN GAMBAR ═══ --}}
  <div class="bg-white rounded-2xl border {{ $headerType === 'image' ? 'border-hijau-300' : 'border-gray-100' }} shadow-sm overflow-hidden">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 {{ $headerType === 'image' ? 'bg-hijau-50' : '' }}">
      <div class="w-8 h-8 rounded-lg {{ $headerType === 'image' ? 'bg-hijau-200' : 'bg-gray-100' }} flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 {{ $headerType === 'image' ? 'text-hijau-700' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
      </div>
      <div>
        <h3 class="text-sm font-bold text-gray-700">Pengaturan Gambar</h3>
        <p class="text-xs text-gray-400">Format: JPG, PNG, WebP. Maks 5 MB. Disarankan landscape 1920×1080.</p>
      </div>
    </div>

    <div class="p-5">
      @if($headerImage)
        <div class="mb-5 relative rounded-xl overflow-hidden group" x-data>
          <img src="{{ asset('storage/'.$headerImage) }}" class="w-full h-48 object-cover"/>
          <div class="absolute inset-0 bg-hijau-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
          </div>
          <form method="POST" action="{{ route('admin.header.hapus-image') }}"
                onsubmit="return confirm('Hapus gambar header?')"
                class="absolute top-2 right-2">
            @csrf @method('DELETE')
            <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors shadow">
              Hapus Gambar
            </button>
          </form>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.header.simpan-image') }}"
            enctype="multipart/form-data" x-data="{ preview: null }">
        @csrf
        <div class="border-2 border-dashed border-gray-200 hover:border-hijau-300 rounded-xl p-6 text-center transition-colors cursor-pointer"
             @click="$refs.imgInput.click()">
          <template x-if="preview">
            <img :src="preview" class="mx-auto max-h-40 object-contain rounded-lg mb-3"/>
          </template>
          <template x-if="!preview">
            <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
          </template>
          <p class="text-sm text-gray-500" x-text="preview ? 'Klik untuk ganti gambar' : 'Klik untuk pilih gambar'"></p>
          <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP · Maks 5 MB</p>
          <input type="file" name="gambar" accept="image/*" class="sr-only" x-ref="imgInput"
                 @change="preview = URL.createObjectURL($event.target.files[0])"/>
        </div>
        @error('gambar')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror

        <button type="submit"
                class="mt-4 w-full py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-bold rounded-xl transition-colors">
          Simpan Gambar
        </button>
      </form>
    </div>
  </div>

  {{-- ═══ PENGATURAN SLIDESHOW ═══ --}}
  <div class="bg-white rounded-2xl border {{ $headerType === 'slideshow' ? 'border-hijau-300' : 'border-gray-100' }} shadow-sm overflow-hidden">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 {{ $headerType === 'slideshow' ? 'bg-hijau-50' : '' }}">
      <div class="w-8 h-8 rounded-lg {{ $headerType === 'slideshow' ? 'bg-hijau-200' : 'bg-gray-100' }} flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 {{ $headerType === 'slideshow' ? 'text-hijau-700' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
        </svg>
      </div>
      <div>
        <h3 class="text-sm font-bold text-gray-700">Pengaturan Slideshow</h3>
        <p class="text-xs text-gray-400">Tambah beberapa gambar — akan berganti otomatis setiap 5 detik.</p>
      </div>
    </div>

    <div class="p-5">
      {{-- Grid slide yang ada --}}
      @if(count($headerSlides))
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-5">
          @foreach($headerSlides as $i => $slide)
            <div class="relative group rounded-xl overflow-hidden aspect-video bg-gray-100">
              <img src="{{ asset('storage/'.$slide) }}" class="w-full h-full object-cover"/>
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <form method="POST" action="{{ route('admin.header.remove-slide') }}"
                      onsubmit="return confirm('Hapus slide ini?')">
                  @csrf @method('DELETE')
                  <input type="hidden" name="path" value="{{ $slide }}"/>
                  <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">
                    Hapus
                  </button>
                </form>
              </div>
              <div class="absolute bottom-1 left-1.5 text-xs text-white/80 font-mono">#{{ $i + 1 }}</div>
            </div>
          @endforeach
        </div>
      @else
        <div class="mb-4 flex items-center gap-2 text-xs text-gray-400 bg-gray-50 rounded-xl px-4 py-3">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Belum ada slide. Tambahkan minimal 2 gambar untuk slideshow.
        </div>
      @endif

      {{-- Upload slide baru --}}
      <form method="POST" action="{{ route('admin.header.add-slide') }}"
            enctype="multipart/form-data" x-data="{ preview: null }">
        @csrf
        <p class="text-xs font-semibold text-gray-600 mb-2">Tambah Slide Baru</p>
        <div class="border-2 border-dashed border-gray-200 hover:border-hijau-300 rounded-xl p-5 text-center transition-colors cursor-pointer"
             @click="$refs.slideInput.click()">
          <template x-if="preview">
            <img :src="preview" class="mx-auto max-h-32 object-contain rounded-lg mb-2"/>
          </template>
          <template x-if="!preview">
            <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
          </template>
          <p class="text-xs text-gray-500" x-text="preview ? 'Klik untuk ganti pilihan' : 'Klik untuk pilih gambar slide'"></p>
          <input type="file" name="gambar" accept="image/*" class="sr-only" x-ref="slideInput"
                 @change="preview = URL.createObjectURL($event.target.files[0])"/>
        </div>
        @error('gambar')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

        <button type="submit"
                class="mt-3 w-full py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-bold rounded-xl transition-colors">
          + Tambah Slide
        </button>
      </form>
    </div>
  </div>

  {{-- ═══ PENGATURAN VIDEO ═══ --}}
  <div class="bg-white rounded-2xl border {{ $headerType === 'video' ? 'border-hijau-300' : 'border-gray-100' }} shadow-sm overflow-hidden">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 {{ $headerType === 'video' ? 'bg-hijau-50' : '' }}">
      <div class="w-8 h-8 rounded-lg {{ $headerType === 'video' ? 'bg-hijau-200' : 'bg-gray-100' }} flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 {{ $headerType === 'video' ? 'text-hijau-700' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.697v6.606a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
        </svg>
      </div>
      <div>
        <h3 class="text-sm font-bold text-gray-700">Pengaturan Video Background</h3>
        <p class="text-xs text-gray-400">Format MP4/WebM · Maks 100 MB. Disarankan tanpa suara, landscape.</p>
      </div>
    </div>

    <div class="p-5 space-y-5">
      <form method="POST" action="{{ route('admin.header.simpan-video') }}"
            enctype="multipart/form-data" x-data="{ previewVideo: null, previewPoster: null }">
        @csrf

        {{-- Video --}}
        <div>
          <p class="text-xs font-semibold text-gray-600 mb-2">File Video</p>
          @if($headerVideo)
            <div class="mb-3 rounded-xl overflow-hidden bg-gray-900 relative group">
              <video class="w-full max-h-48 object-contain" controls muted>
                <source src="{{ asset('storage/'.$headerVideo) }}"/>
              </video>
              <form method="POST" action="{{ route('admin.header.hapus-video') }}"
                    onsubmit="return confirm('Hapus video?')"
                    class="absolute top-2 right-2">
                @csrf @method('DELETE')
                <input type="hidden" name="target" value="video"/>
                <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg">Hapus</button>
              </form>
            </div>
          @endif

          <div class="border-2 border-dashed border-gray-200 hover:border-hijau-300 rounded-xl p-5 text-center transition-colors cursor-pointer"
               @click="$refs.videoInput.click()">
            <template x-if="previewVideo">
              <p class="text-sm text-hijau-600 font-semibold mb-1" x-text="'Video dipilih: ' + previewVideo"></p>
            </template>
            <template x-if="!previewVideo">
              <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.697v6.606a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
              </svg>
            </template>
            <p class="text-xs text-gray-500">MP4, WebM · Maks 100 MB</p>
            <input type="file" name="video" accept="video/mp4,video/webm" class="sr-only" x-ref="videoInput"
                   @change="previewVideo = $event.target.files[0]?.name"/>
          </div>
          @error('video')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        {{-- Poster --}}
        <div>
          <p class="text-xs font-semibold text-gray-600 mb-2">
            Gambar Poster
            <span class="font-normal text-gray-400">(tampil sebelum video dimuat)</span>
          </p>
          @if($headerPoster)
            <div class="mb-3 relative group rounded-xl overflow-hidden">
              <img src="{{ asset('storage/'.$headerPoster) }}" class="w-full h-36 object-cover"/>
              <form method="POST" action="{{ route('admin.header.hapus-video') }}"
                    onsubmit="return confirm('Hapus poster?')"
                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                @csrf @method('DELETE')
                <input type="hidden" name="target" value="poster"/>
                <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg">Hapus</button>
              </form>
            </div>
          @endif

          <div class="border-2 border-dashed border-gray-200 hover:border-hijau-300 rounded-xl p-5 text-center transition-colors cursor-pointer"
               @click="$refs.posterInput.click()">
            <template x-if="previewPoster">
              <img :src="previewPoster" class="mx-auto max-h-24 object-contain rounded-lg mb-2"/>
            </template>
            <template x-if="!previewPoster">
              <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </template>
            <p class="text-xs text-gray-500">JPG, PNG, WebP · Maks 5 MB</p>
            <input type="file" name="poster" accept="image/*" class="sr-only" x-ref="posterInput"
                   @change="previewPoster = URL.createObjectURL($event.target.files[0])"/>
          </div>
          @error('poster')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="w-full py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-bold rounded-xl transition-colors">
          Simpan Pengaturan Video
        </button>
      </form>
    </div>
  </div>

</div>
</x-admin-layout>
