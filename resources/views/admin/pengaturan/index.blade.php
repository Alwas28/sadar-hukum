<x-admin-layout title="Pengaturan">

<div class="p-4 sm:p-6 space-y-6 max-w-3xl mx-auto">

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

  {{-- Page header --}}
  <div class="flex items-center gap-3">
    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
      </svg>
    </div>
    <div>
      <h1 class="font-display text-2xl font-bold text-gray-800">Pengaturan</h1>
      <p class="text-sm text-gray-500">Konfigurasi tampilan portal dan layanan AI</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.pengaturan.update') }}"
        x-data="{
          provider: '{{ $s->get('ai_provider', 'openai') }}',
          showKey: false,
          templateTab: 'perdes',
          models: {
            openai:    ['gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo', 'gpt-3.5-turbo'],
            anthropic: ['claude-opus-4-7', 'claude-sonnet-4-6', 'claude-haiku-4-5'],
            google:    ['gemini-2.0-flash', 'gemini-1.5-pro', 'gemini-1.5-flash']
          }
        }">
    @csrf

    {{-- ══════════ SECTION 0: INFORMASI DESA ══════════ --}}
    <div class="space-y-4 pt-2">
      <div class="flex items-center gap-2 mb-1">
        <div class="w-1 h-5 rounded-full bg-hijau-500"></div>
        <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Informasi Wilayah</h2>
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <p class="text-xs text-gray-400">Digunakan sebagai kop surat dokumen PDF dan diisikan otomatis pada draf regulasi yang dibuat AI.</p>
        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Desa</label>
            <input type="text" name="desa_nama" value="{{ old('desa_nama', $s->get('desa_nama')) }}" placeholder="Tontonunu"
                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all"/>
            @error('desa_nama')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kecamatan</label>
            <input type="text" name="desa_kecamatan" value="{{ old('desa_kecamatan', $s->get('desa_kecamatan')) }}" placeholder="Nama Kecamatan"
                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all"/>
            @error('desa_kecamatan')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kabupaten/Kota</label>
            <input type="text" name="desa_kabupaten" value="{{ old('desa_kabupaten', $s->get('desa_kabupaten')) }}" placeholder="Nama Kabupaten/Kota"
                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all"/>
            @error('desa_kabupaten')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Provinsi</label>
            <input type="text" name="desa_provinsi" value="{{ old('desa_provinsi', $s->get('desa_provinsi')) }}" placeholder="Nama Provinsi"
                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all"/>
            @error('desa_provinsi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>
    </div>

    {{-- ══════════ SECTION 1: TAMPILAN ══════════ --}}
    <div class="space-y-4">
      <div class="flex items-center gap-2 mb-1">
        <div class="w-1 h-5 rounded-full bg-langit-500"></div>
        <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Tampilan Website</h2>
      </div>

      {{-- Mode --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <label class="block text-sm font-semibold text-gray-700 mb-3">Mode Tampilan</label>
        <div class="grid grid-cols-2 gap-3">

          {{-- Light card --}}
          <label class="cursor-pointer group">
            <input type="radio" name="theme_mode" value="light"
                   {{ ($s->get('theme_mode','light') === 'light') ? 'checked' : '' }} class="sr-only peer"/>
            <div class="rounded-xl border-2 border-gray-200 peer-checked:border-langit-500 peer-checked:ring-2 peer-checked:ring-langit-100 overflow-hidden transition-all">
              {{-- Preview --}}
              <div class="bg-white p-3 space-y-1.5">
                <div class="h-2 w-16 bg-gray-200 rounded-full"></div>
                <div class="h-1.5 w-24 bg-gray-100 rounded-full"></div>
                <div class="mt-2 grid grid-cols-3 gap-1">
                  <div class="h-8 bg-gray-100 rounded-lg"></div>
                  <div class="h-8 bg-gray-100 rounded-lg"></div>
                  <div class="h-8 bg-gray-100 rounded-lg"></div>
                </div>
              </div>
              <div class="px-3 py-2 bg-gray-50 border-t border-gray-100 flex items-center gap-2">
                <div class="w-3 h-3 rounded-full border-2 border-gray-300 peer-checked:border-langit-500 flex items-center justify-center">
                  <div class="w-1.5 h-1.5 rounded-full bg-langit-500 opacity-0 peer-checked:opacity-100"></div>
                </div>
                <span class="text-xs font-semibold text-gray-700">Light</span>
                <svg class="w-3.5 h-3.5 ml-auto text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.592-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.592z"/>
                </svg>
              </div>
            </div>
          </label>

          {{-- Dark card --}}
          <label class="cursor-pointer group">
            <input type="radio" name="theme_mode" value="dark"
                   {{ ($s->get('theme_mode','light') === 'dark') ? 'checked' : '' }} class="sr-only peer"/>
            <div class="rounded-xl border-2 border-gray-200 peer-checked:border-langit-500 peer-checked:ring-2 peer-checked:ring-langit-100 overflow-hidden transition-all">
              <div class="bg-gray-900 p-3 space-y-1.5">
                <div class="h-2 w-16 bg-gray-700 rounded-full"></div>
                <div class="h-1.5 w-24 bg-gray-800 rounded-full"></div>
                <div class="mt-2 grid grid-cols-3 gap-1">
                  <div class="h-8 bg-gray-800 rounded-lg"></div>
                  <div class="h-8 bg-gray-800 rounded-lg"></div>
                  <div class="h-8 bg-gray-800 rounded-lg"></div>
                </div>
              </div>
              <div class="px-3 py-2 bg-gray-800 border-t border-gray-700 flex items-center gap-2">
                <div class="w-3 h-3 rounded-full border-2 border-gray-500 flex items-center justify-center">
                  <div class="w-1.5 h-1.5 rounded-full bg-langit-400"></div>
                </div>
                <span class="text-xs font-semibold text-gray-300">Dark</span>
                <svg class="w-3.5 h-3.5 ml-auto text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
          </label>

        </div>
        @error('theme_mode')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>

      {{-- Warna Utama --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Warna Utama Portal</label>
        <p class="text-xs text-gray-400 mb-4">Warna aksen yang digunakan pada tombol, link, dan elemen interaktif</p>
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
          @php
          $colors = [
            'hijau'  => ['label' => 'Hijau',   'hex' => '#15803d', 'ring' => '#16a34a'],
            'langit' => ['label' => 'Langit',  'hex' => '#0284c7', 'ring' => '#0ea5e9'],
            'biru'   => ['label' => 'Biru',    'hex' => '#2563eb', 'ring' => '#3b82f6'],
            'ungu'   => ['label' => 'Ungu',    'hex' => '#7c3aed', 'ring' => '#8b5cf6'],
            'merah'  => ['label' => 'Merah',   'hex' => '#dc2626', 'ring' => '#ef4444'],
            'emas'   => ['label' => 'Emas',    'hex' => '#d97706', 'ring' => '#f59e0b'],
          ];
          $activeColor = $s->get('theme_color', 'hijau');
          @endphp
          @foreach($colors as $key => $c)
          @php $isActive = $activeColor === $key; @endphp
          <label class="cursor-pointer">
            <input type="radio" name="theme_color" value="{{ $key }}"
                   {{ $isActive ? 'checked' : '' }} class="sr-only peer"/>
            <div class="flex flex-col items-center gap-2 p-2 rounded-xl border-2 transition-all
                        {{ $isActive ? 'border-gray-300 bg-gray-50' : 'border-transparent hover:bg-gray-50' }}
                        peer-checked:border-gray-300 peer-checked:bg-gray-50">
              <div class="w-9 h-9 rounded-full transition-all"
                   style="background-color: {{ $c['hex'] }};
                          box-shadow: 0 1px 3px rgba(0,0,0,0.2);
                          {{ $isActive ? 'outline: 3px solid '.$c['ring'].'; outline-offset: 3px;' : '' }}">
              </div>
              <span class="text-xs font-semibold {{ $isActive ? 'text-gray-800' : 'text-gray-500' }}">{{ $c['label'] }}</span>
            </div>
          </label>
          @endforeach
        </div>
        @error('theme_color')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
      </div>
    </div>

    {{-- ══════════ SECTION 2: AI ══════════ --}}
    <div class="space-y-4 pt-2">
      <div class="flex items-center gap-2 mb-1">
        <div class="w-1 h-5 rounded-full bg-emas-500"></div>
        <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Konfigurasi AI</h2>
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-5">

        {{-- Provider --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-3">Penyedia AI</label>
          <div class="grid grid-cols-3 gap-3">
            @php
            $providers = [
              'openai'    => ['name' => 'OpenAI',    'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z', 'color' => '#10a37f'],
              'anthropic' => ['name' => 'Anthropic', 'icon' => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5', 'color' => '#d97706'],
              'google'    => ['name' => 'Google',    'icon' => 'M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z', 'color' => '#4285f4'],
            ];
            @endphp
            @foreach($providers as $key => $p)
            <label class="cursor-pointer" @click="provider = '{{ $key }}'">
              <input type="radio" name="ai_provider" value="{{ $key }}"
                     {{ ($s->get('ai_provider','openai') === $key) ? 'checked' : '' }}
                     x-model="provider" class="sr-only peer"/>
              <div class="flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-200
                          peer-checked:border-langit-400 peer-checked:bg-langit-50 hover:border-gray-300 transition-all">
                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                     style="background-color: {{ $p['color'] }}20">
                  <svg class="w-4 h-4" fill="none" stroke="{{ $p['color'] }}" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $p['icon'] }}"/>
                  </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">{{ $p['name'] }}</span>
              </div>
            </label>
            @endforeach
          </div>
          @error('ai_provider')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Model --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Model</label>
          <select name="ai_model"
                  class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all bg-white">
            <template x-for="model in (models[provider] || [])" :key="model">
              <option :value="model" :selected="model === '{{ $s->get('ai_model','') }}'" x-text="model"></option>
            </template>
          </select>
          @error('ai_model')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- API Key --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            API Key
            <span class="font-normal text-gray-400 ml-1">(disimpan terenkripsi)</span>
          </label>
          <div class="relative" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" name="ai_api_key"
                   value="{{ $s->get('ai_api_key') ? str_repeat('•', 32) : '' }}"
                   placeholder="Masukkan API key..."
                   class="w-full pl-4 pr-12 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono tracking-wider
                          {{ $errors->has('ai_api_key') ? 'border-red-400' : '' }}"/>
            <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
              <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>
          @if($s->get('ai_api_key'))
            <p class="mt-1.5 text-xs text-hijau-600 flex items-center gap-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
              </svg>
              API key sudah tersimpan · kosongkan jika tidak ingin mengubah
            </p>
          @endif
          @error('ai_api_key')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Template Prompt per jenis regulasi --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Template Prompt Regulasi
            <span class="font-normal text-gray-400 ml-1">(dapat diedit, masing-masing jenis regulasi punya template sendiri)</span>
          </label>

          <div class="flex items-center gap-2 mb-3">
            @foreach(['perdes' => 'Peraturan Desa', 'perkades' => 'Peraturan Kepala Desa', 'sk_kades' => 'SK Kepala Desa'] as $val => $label)
              <button type="button" @click="templateTab = '{{ $val }}'"
                      class="px-3 py-1.5 text-xs font-semibold rounded-full border transition-colors"
                      :class="templateTab === '{{ $val }}' ? 'bg-langit-600 text-white border-langit-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'">
                {{ $label }}
              </button>
            @endforeach
          </div>

          @foreach(['perdes', 'perkades', 'sk_kades'] as $jenis)
            <div x-show="templateTab === '{{ $jenis }}'" style="display:none">
              <textarea name="ai_prompt_template_{{ $jenis }}" rows="8"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono leading-relaxed
                               {{ $errors->has("ai_prompt_template_{$jenis}") ? 'border-red-400' : '' }}">{{ old("ai_prompt_template_{$jenis}", $s->get("ai_prompt_template_{$jenis}") ?: \App\Models\Perdes::defaultPromptTemplate($jenis)) }}</textarea>
              @error("ai_prompt_template_{$jenis}")<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
          @endforeach

          <p class="mt-1.5 text-xs text-gray-400">Struktur ini disisipkan ke prompt AI sesuai jenis regulasi yang dipilih di halaman Buat Perdes Baru.</p>
        </div>

        {{-- Info box --}}
        <div class="bg-gray-50 rounded-xl p-4 flex gap-3">
          <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <div class="text-xs text-gray-500 space-y-1">
            <p>API key digunakan oleh fitur <strong class="text-gray-700">Buat Perdes Baru</strong> untuk membuat draf regulasi desa secara otomatis.</p>
            <p>Pastikan akun API Anda memiliki kuota yang cukup sebelum menggunakan fitur generasi AI.</p>
          </div>
        </div>

      </div>
    </div>

    {{-- ══════════ SECTION 3: TAMPILAN PDF ══════════ --}}
    <div class="space-y-4 pt-2">
      <div class="flex items-center gap-2 mb-1">
        <div class="w-1 h-5 rounded-full bg-red-400"></div>
        <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Tampilan PDF</h2>
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-5">
        <p class="text-xs text-gray-400">Pengaturan ini diterapkan pada setiap dokumen PDF yang diunduh dari sistem.</p>

        {{-- Font & Ukuran --}}
        <div class="grid sm:grid-cols-3 gap-4">
          <div class="sm:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Huruf (Font)</label>
            <select name="pdf_font_family"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all bg-white">
              @foreach(['Arial' => 'Arial (Default)', 'Times New Roman' => 'Times New Roman', 'Courier New' => 'Courier New', 'DejaVu Sans' => 'DejaVu Sans (Built-in)'] as $val => $label)
                <option value="{{ $val }}" {{ $s->get('pdf_font_family', 'Arial') === $val ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
            @error('pdf_font_family')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ukuran Huruf</label>
            <select name="pdf_font_size"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all bg-white">
              @foreach([10 => '10 pt', 11 => '11 pt', 12 => '12 pt (Default)', 14 => '14 pt'] as $val => $label)
                <option value="{{ $val }}" {{ (int)$s->get('pdf_font_size', 12) === $val ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
            @error('pdf_font_size')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
        </div>

        {{-- Spasi antar baris --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Spasi Antar Baris</label>
          <div class="grid grid-cols-4 gap-2">
            @foreach(['1.0' => 'Single', '1.15' => '1.15', '1.5' => '1.5 (Default)', '2.0' => 'Double'] as $val => $label)
              <label class="cursor-pointer">
                <input type="radio" name="pdf_line_spacing" value="{{ $val }}"
                       class="sr-only peer"
                       {{ $s->get('pdf_line_spacing', '1.5') === $val ? 'checked' : '' }}/>
                <div class="text-center py-2 px-1 text-xs font-semibold rounded-xl border-2 border-gray-200
                            peer-checked:border-hijau-500 peer-checked:bg-hijau-50 peer-checked:text-hijau-700
                            hover:border-gray-300 transition-all">
                  {{ $label }}
                </div>
              </label>
            @endforeach
          </div>
          @error('pdf_line_spacing')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Margin --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Margin Halaman <span class="font-normal text-gray-400">(dalam cm)</span></label>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach(['top' => 'Atas', 'left' => 'Kiri', 'right' => 'Kanan', 'bottom' => 'Bawah'] as $side => $sideLabel)
              @php $default = $side === 'top' ? 4 : 3; @endphp
              <div>
                <label class="block text-xs text-gray-500 mb-1">{{ $sideLabel }}</label>
                <div class="relative">
                  <input type="number" name="pdf_margin_{{ $side }}" step="0.5" min="1" max="6"
                         value="{{ old('pdf_margin_'.$side, $s->get('pdf_margin_'.$side, $default)) }}"
                         class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all pr-10"/>
                  <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">cm</span>
                </div>
                @error('pdf_margin_'.$side)<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
              </div>
            @endforeach
          </div>
        </div>

        {{-- Preview hint --}}
        <div class="bg-gray-50 rounded-xl p-3 flex gap-2.5">
          <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <p class="text-xs text-gray-500">Font <strong>Arial</strong>, <strong>Times New Roman</strong>, dan <strong>Courier New</strong> menggunakan font sistem Windows. Font <strong>DejaVu Sans</strong> tersedia di semua platform.</p>
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
        Simpan Pengaturan
      </button>
    </div>

  </form>
</div>

</x-admin-layout>
