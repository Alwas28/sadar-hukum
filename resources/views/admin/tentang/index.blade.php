<x-admin-layout title="Tentang Desa">

<div class="p-4 sm:p-6 space-y-6 max-w-4xl mx-auto">

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
  <div class="flex items-center gap-3">
    <div class="w-10 h-10 rounded-xl bg-langit-100 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-langit-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
    </div>
    <div>
      <h1 class="font-display text-2xl font-bold text-gray-800">Tentang Desa</h1>
      <p class="text-sm text-gray-500">Kelola konten profil desa, struktur organisasi, dan informasi kontak</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.tentang.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="space-y-6">

      {{-- ══ SECTION 0: IDENTITAS RESMI ══ --}}
      <div>
        <div class="flex items-center gap-2 mb-3">
          <div class="w-1 h-5 rounded-full bg-emas-500"></div>
          <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Identitas Resmi</h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
             x-data="{ preview: '{{ $s->get('desa_logo') ? Storage::url($s->get('desa_logo')) : '' }}' }">
          <label class="block text-sm font-semibold text-gray-700 mb-1">Logo Desa</label>
          <p class="text-xs text-gray-400 mb-3">Digunakan pada kop surat dokumen PDF dan draf peraturan yang dibuat AI.</p>

          <div class="flex items-center gap-4">
            <div class="relative w-20 h-20 flex-shrink-0" x-show="preview">
              <img :src="preview" class="w-20 h-20 rounded-xl object-contain bg-gray-50 ring-2 ring-emas-200 p-1.5"/>
              @if($s->get('desa_logo'))
              <button type="button"
                      class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow transition-colors"
                      @click="if(!confirm('Hapus logo desa ini?')) return;
                              preview='';
                              let f=document.createElement('form');
                              f.method='POST';
                              f.action='{{ route('admin.tentang.hapus-logo') }}';
                              f.innerHTML='<input name=\'_token\' value=\'{{ csrf_token() }}\'><input name=\'_method\' value=\'DELETE\'>';
                              document.body.appendChild(f);
                              f.submit();">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
              @endif
            </div>

            <div x-show="!preview" class="w-20 h-20 rounded-xl bg-emas-50 flex items-center justify-center flex-shrink-0 ring-2 ring-gray-100">
              <svg class="w-8 h-8 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </div>

            <div class="flex-1">
              <div class="relative">
                <input type="file" name="logo" accept="image/*"
                       @change="const f=$event.target.files[0]; if(f) preview=URL.createObjectURL(f)"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"/>
                <div class="flex items-center gap-2 px-3 py-2 border border-dashed border-gray-300 rounded-xl hover:border-emas-400 hover:bg-emas-50 transition-all text-xs text-gray-500">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <span x-text="preview ? 'Ganti logo...' : 'Upload logo...'"></span>
                </div>
              </div>
              <p class="text-xs text-gray-400 mt-1">PNG, JPG, SVG · maks 2MB · latar transparan dianjurkan</p>
            </div>
          </div>
        </div>
      </div>

      {{-- ══ SECTION 0B: DATA DESA DALAM ANGKA ══ --}}
      <div>
        <div class="flex items-center gap-2 mb-3">
          <div class="w-1 h-5 rounded-full bg-langit-500"></div>
          <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Data Desa Dalam Angka</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <p class="text-xs text-gray-400 mb-4">Angka-angka ini ditampilkan pada bagian "Tontonunu Dalam Angka" di halaman publik.</p>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

            <div class="bg-gray-50 rounded-xl p-4 text-center">
              <div class="text-xs font-semibold text-gray-500 mb-2">Jumlah Penduduk</div>
              <input type="text" name="desa_stat_penduduk"
                     value="{{ $s->get('desa_stat_penduduk', '0') }}"
                     placeholder="Cth: 2.847"
                     class="w-full text-center text-xl font-black text-hijau-700 bg-transparent border-0 border-b-2 border-hijau-200 focus:border-hijau-500 focus:outline-none focus:ring-0 pb-1 transition-colors"/>
              <div class="text-xs text-gray-400 mt-2">jiwa</div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center">
              <div class="text-xs font-semibold text-gray-500 mb-2">Kepala Keluarga</div>
              <input type="text" name="desa_stat_kk"
                     value="{{ $s->get('desa_stat_kk', '0') }}"
                     placeholder="Cth: 724"
                     class="w-full text-center text-xl font-black text-emas-600 bg-transparent border-0 border-b-2 border-emas-200 focus:border-emas-500 focus:outline-none focus:ring-0 pb-1 transition-colors"/>
              <div class="text-xs text-gray-400 mt-2">KK</div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center">
              <div class="text-xs font-semibold text-gray-500 mb-2">Peraturan Aktif</div>
              <input type="text" name="desa_stat_peraturan"
                     value="{{ $s->get('desa_stat_peraturan', '0') }}"
                     placeholder="Cth: 24"
                     class="w-full text-center text-xl font-black text-langit-700 bg-transparent border-0 border-b-2 border-langit-200 focus:border-langit-500 focus:outline-none focus:ring-0 pb-1 transition-colors"/>
              <div class="text-xs text-gray-400 mt-2">regulasi</div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center">
              <div class="text-xs font-semibold text-gray-500 mb-2">Dusun / Wilayah</div>
              <input type="text" name="desa_stat_dusun"
                     value="{{ $s->get('desa_stat_dusun', '0') }}"
                     placeholder="Cth: 6"
                     class="w-full text-center text-xl font-black text-amber-700 bg-transparent border-0 border-b-2 border-amber-200 focus:border-amber-500 focus:outline-none focus:ring-0 pb-1 transition-colors"/>
              <div class="text-xs text-gray-400 mt-2">dusun</div>
            </div>

          </div>
        </div>
      </div>

      {{-- ══ SECTION 1: TENTANG KAMI ══ --}}
      <div>
        <div class="flex items-center gap-2 mb-3">
          <div class="w-1 h-5 rounded-full bg-langit-500"></div>
          <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Tentang Kami</h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Paragraf Pertama</label>
            <textarea name="about_desc1" rows="3"
                      placeholder="Deskripsi singkat tentang desa dan portal SADAR HUKUM..."
                      class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none leading-relaxed">{{ $s->get('about_desc1', 'Desa Tontonunu adalah salah satu desa yang terletak di Kabupaten Bombana, Provinsi Sulawesi Tenggara. Portal SADAR HUKUM hadir sebagai wujud komitmen Pemerintah Desa Tontonunu dalam mewujudkan tata kelola desa yang transparan, akuntabel, dan partisipatif.') }}</textarea>
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Paragraf Kedua</label>
            <textarea name="about_desc2" rows="3"
                      placeholder="Penjelasan tambahan tentang visi atau layanan portal..."
                      class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none leading-relaxed">{{ $s->get('about_desc2', 'Melalui platform ini, seluruh warga dapat mengakses, memahami, dan berpartisipasi dalam proses hukum desa secara mudah dan terbuka. Karena hukum adalah milik semua.') }}</textarea>
          </div>
          <div class="grid grid-cols-2 gap-4 pt-1">
            <div>
              <label class="block text-xs font-semibold text-gray-600 mb-1">Statistik 1 — Nilai</label>
              <input type="text" name="about_stat1_value" value="{{ $s->get('about_stat1_value', '2024') }}"
                     placeholder="2024"
                     class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-600 mb-1">Statistik 1 — Label</label>
              <input type="text" name="about_stat1_label" value="{{ $s->get('about_stat1_label', 'Portal diluncurkan') }}"
                     placeholder="Portal diluncurkan"
                     class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-600 mb-1">Statistik 2 — Nilai</label>
              <input type="text" name="about_stat2_value" value="{{ $s->get('about_stat2_value', '100%') }}"
                     placeholder="100%"
                     class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-600 mb-1">Statistik 2 — Label</label>
              <input type="text" name="about_stat2_label" value="{{ $s->get('about_stat2_label', 'Akses publik gratis') }}"
                     placeholder="Akses publik gratis"
                     class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            </div>
          </div>
        </div>
      </div>

      {{-- ══ SECTION 2: STRUKTUR ORGANISASI ══ --}}
      <div>
        <div class="flex items-center gap-2 mb-3">
          <div class="w-1 h-5 rounded-full bg-hijau-500"></div>
          <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Struktur Organisasi</h2>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          @php
          $positions = \App\Models\StrukturDesa::positions();
          $colors = ['kepala_desa' => 'langit', 'sekretaris' => 'blue', 'bendahara' => 'emas', 'ketua_bpd' => 'purple'];
          $tailwindColors = [
            'kepala_desa' => ['ring' => 'ring-langit-400',  'bg' => 'bg-langit-100',  'text' => 'text-langit-700'],
            'sekretaris'  => ['ring' => 'ring-blue-400',    'bg' => 'bg-blue-100',    'text' => 'text-blue-700'],
            'bendahara'   => ['ring' => 'ring-emas-400',    'bg' => 'bg-emas-300/50', 'text' => 'text-amber-700'],
            'ketua_bpd'   => ['ring' => 'ring-purple-400',  'bg' => 'bg-purple-100',  'text' => 'text-purple-700'],
          ];
          @endphp

          @foreach($positions as $jabatan)
          @php
            $member = $struktur->get($jabatan);
            $label  = \App\Models\StrukturDesa::label($jabatan);
            $init   = \App\Models\StrukturDesa::initials($jabatan);
            $tc     = $tailwindColors[$jabatan];
          @endphp
          <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
               x-data="{ preview: '{{ $member?->foto ? Storage::url($member->foto) : '' }}' }">

            {{-- Label jabatan --}}
            <div class="flex items-center gap-2 mb-4">
              <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $tc['bg'] }} {{ $tc['text'] }}">
                {{ $init }}
              </span>
              <span class="text-sm font-semibold text-gray-700">{{ $label }}</span>
            </div>

            {{-- Foto --}}
            <div class="mb-4">
              <label class="block text-xs font-semibold text-gray-500 mb-2">Foto</label>

              {{-- Current/preview foto --}}
              <div class="relative w-24 h-24 mb-3" x-show="preview">
                <img :src="preview" class="w-24 h-24 rounded-2xl object-cover ring-2 {{ $tc['ring'] }}"/>
                @if($member?->foto)
                <button type="button"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow transition-colors"
                        @click="if(!confirm('Hapus foto ini?')) return;
                                preview='';
                                let f=document.createElement('form');
                                f.method='POST';
                                f.action='{{ route('admin.tentang.hapus-foto', $jabatan) }}';
                                f.innerHTML='<input name=\'_token\' value=\'{{ csrf_token() }}\'><input name=\'_method\' value=\'DELETE\'>';
                                document.body.appendChild(f);
                                f.submit();">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
                @endif
              </div>

              {{-- No foto placeholder --}}
              <div x-show="!preview" class="w-24 h-24 rounded-2xl {{ $tc['bg'] }} flex items-center justify-center mb-3 ring-2 ring-gray-100">
                <span class="text-xl font-bold {{ $tc['text'] }}">{{ $init }}</span>
              </div>

              {{-- Upload dropzone --}}
              <div class="relative">
                <input type="file" name="foto[{{ $jabatan }}]" accept="image/*"
                       @change="const f=$event.target.files[0]; if(f) preview=URL.createObjectURL(f)"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"/>
                <div class="flex items-center gap-2 px-3 py-2 border border-dashed border-gray-300 rounded-xl hover:border-langit-400 hover:bg-langit-50 transition-all text-xs text-gray-500">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <span x-text="preview ? 'Ganti foto...' : 'Upload foto...'"></span>
                </div>
              </div>
              <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP · maks 2MB · rasio 1:1 dianjurkan</p>
            </div>

            {{-- Nama --}}
            <div>
              <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Lengkap</label>
              <input type="text" name="nama[{{ $jabatan }}]"
                     value="{{ $member?->nama }}"
                     placeholder="Nama {{ $label }}..."
                     class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
              @if($jabatan === 'kepala_desa')
                <p class="text-xs text-gray-400 mt-1">Digunakan otomatis pada tanda tangan dokumen PDF dan draf peraturan AI.</p>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- ══ SECTION 3: HUBUNGI KAMI ══ --}}
      <div>
        <div class="flex items-center gap-2 mb-3">
          <div class="w-1 h-5 rounded-full bg-emas-500"></div>
          <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Hubungi Kami</h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <div class="grid sm:grid-cols-2 gap-4">

            <div class="sm:col-span-2">
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Kantor Desa</label>
              <textarea name="contact_address" rows="2"
                        placeholder="Jl. Poros Tontonunu No. 01, Kab. Bombana, Sulawesi Tenggara"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none">{{ $s->get('contact_address', 'Jl. Poros Tontonunu No. 01, Kab. Bombana, Sulawesi Tenggara') }}</textarea>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Telepon</label>
              <input type="text" name="contact_phone" value="{{ $s->get('contact_phone', '+62 401 – XXXXXXX') }}"
                     placeholder="+62 401 – XXXXXXX"
                     class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Operasional</label>
              <input type="text" name="contact_hours" value="{{ $s->get('contact_hours', 'Senin–Jumat, 08.00–15.00') }}"
                     placeholder="Senin–Jumat, 08.00–15.00"
                     class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            </div>

            <div class="sm:col-span-2">
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
              <input type="email" name="contact_email" value="{{ $s->get('contact_email', 'desa.tontonunu@gmail.com') }}"
                     placeholder="desa.tontonunu@gmail.com"
                     class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            </div>

          </div>
        </div>
      </div>

      {{-- Submit --}}
      <div class="flex justify-end gap-3 pb-4">
        <a href="{{ route('dashboard') }}"
           class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Simpan Semua
        </button>
      </div>

    </div>
  </form>
</div>

</x-admin-layout>
