<x-admin-layout :title="$penduduk ? 'Edit Data Penduduk' : 'Tambah Penduduk'">

@php
  $isEdit  = (bool) $penduduk;
  $action  = $isEdit ? route('admin.penduduk.update', $penduduk) : route('admin.penduduk.store');
  $method  = $isEdit ? 'PATCH' : 'POST';
@endphp

<div class="p-4 sm:p-6 max-w-4xl">

  {{-- Header --}}
  <div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.penduduk.index') }}"
       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-100 transition-colors flex-shrink-0">
      <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h1 class="font-display text-xl font-bold text-gray-800">
        {{ $isEdit ? 'Edit Data Penduduk' : 'Tambah Penduduk Baru' }}
      </h1>
      <p class="text-sm text-gray-500">{{ $isEdit ? 'Perbarui informasi data penduduk' : 'Isi data kependudukan dengan lengkap' }}</p>
    </div>
  </div>

  @if($errors->any())
    <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
      <p class="font-semibold mb-1">Terdapat kesalahan input:</p>
      <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ $action }}">
    @csrf
    @method($method)

    <div class="space-y-5">

      {{-- Identitas Diri --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <h3 class="text-sm font-bold text-gray-700 border-b border-gray-100 pb-2.5">Identitas Diri</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">NIK <span class="text-red-500">*</span></label>
            <input type="text" name="nik" value="{{ old('nik', $penduduk?->nik) }}"
                   maxlength="16" placeholder="16 digit NIK"
                   class="w-full px-3 py-2 text-sm border @error('nik') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono tracking-wider"/>
            @error('nik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $penduduk?->nama) }}"
                   placeholder="Nama sesuai KTP"
                   class="w-full px-3 py-2 text-sm border @error('nama') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
            <select name="jenis_kelamin"
                    class="w-full px-3 py-2 text-sm border @error('jenis_kelamin') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
              <option value="">-- Pilih --</option>
              <option value="L" @selected(old('jenis_kelamin', $penduduk?->jenis_kelamin) === 'L')>Laki-laki</option>
              <option value="P" @selected(old('jenis_kelamin', $penduduk?->jenis_kelamin) === 'P')>Perempuan</option>
            </select>
            @error('jenis_kelamin')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Agama <span class="text-red-500">*</span></label>
            <select name="agama"
                    class="w-full px-3 py-2 text-sm border @error('agama') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
              <option value="">-- Pilih --</option>
              @foreach(\App\Models\Penduduk::agamaOptions() as $agama)
                <option value="{{ $agama }}" @selected(old('agama', $penduduk?->agama) === $agama)>{{ $agama }}</option>
              @endforeach
            </select>
            @error('agama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk?->tempat_lahir) }}"
                   placeholder="Kota/Kabupaten"
                   class="w-full px-3 py-2 text-sm border @error('tempat_lahir') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
            @error('tempat_lahir')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal_lahir"
                   value="{{ old('tanggal_lahir', $penduduk?->tanggal_lahir?->format('Y-m-d')) }}"
                   max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                   class="w-full px-3 py-2 text-sm border @error('tanggal_lahir') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white"/>
            @error('tanggal_lahir')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Alamat --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <h3 class="text-sm font-bold text-gray-700 border-b border-gray-100 pb-2.5">Alamat</h3>

        <div>
          <label class="block text-xs font-semibold text-gray-600 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
          <textarea name="alamat" rows="2" placeholder="Nama jalan / dusun / kampung"
                    class="w-full px-3 py-2 text-sm border @error('alamat') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none">{{ old('alamat', $penduduk?->alamat) }}</textarea>
          @error('alamat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">RT</label>
            <input type="text" name="rt" value="{{ old('rt', $penduduk?->rt) }}"
                   maxlength="5" placeholder="Misal: 001"
                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">RW</label>
            <input type="text" name="rw" value="{{ old('rw', $penduduk?->rw) }}"
                   maxlength="5" placeholder="Misal: 001"
                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
          </div>
        </div>
      </div>

      {{-- Status & Pekerjaan --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <h3 class="text-sm font-bold text-gray-700 border-b border-gray-100 pb-2.5">Status &amp; Pekerjaan</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status Perkawinan <span class="text-red-500">*</span></label>
            <select name="status_perkawinan"
                    class="w-full px-3 py-2 text-sm border @error('status_perkawinan') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
              <option value="">-- Pilih --</option>
              @foreach(\App\Models\Penduduk::statusPerkawinanOptions() as $sp)
                <option value="{{ $sp }}" @selected(old('status_perkawinan', $penduduk?->status_perkawinan) === $sp)>{{ $sp }}</option>
              @endforeach
            </select>
            @error('status_perkawinan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pendidikan Terakhir</label>
            <select name="pendidikan"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
              <option value="">-- Pilih --</option>
              @foreach(\App\Models\Penduduk::pendidikanOptions() as $pd)
                <option value="{{ $pd }}" @selected(old('pendidikan', $penduduk?->pendidikan) === $pd)>{{ $pd }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pekerjaan</label>
            <select name="pekerjaan"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
              <option value="">-- Pilih Pekerjaan --</option>
              @foreach(\App\Models\Penduduk::pekerjaanOptions() as $pj)
                <option value="{{ $pj }}" @selected(old('pekerjaan', $penduduk?->pekerjaan) === $pj)>{{ $pj }}</option>
              @endforeach
            </select>
          </div>

          <div x-data="{ aktif: {{ old('aktif', $penduduk?->aktif ?? true) ? 'true' : 'false' }} }">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status Data</label>
            <div class="flex items-center gap-3 mt-2.5">
              <input type="hidden" name="aktif" :value="aktif ? '1' : '0'"/>
              <button type="button" @click="aktif = !aktif"
                      :class="aktif ? 'bg-hijau-600' : 'bg-gray-300'"
                      class="relative inline-flex h-5 w-10 flex-shrink-0 rounded-full transition-colors duration-200">
                <span :class="aktif ? 'translate-x-5' : 'translate-x-0.5'"
                      class="inline-block mt-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></span>
              </button>
              <span class="text-sm font-medium"
                    :class="aktif ? 'text-hijau-700' : 'text-gray-400'"
                    x-text="aktif ? 'Aktif' : 'Tidak Aktif'"></span>
            </div>
          </div>
        </div>
      </div>

      {{-- Actions --}}
      <div class="flex items-center justify-between pt-1">
        <a href="{{ route('admin.penduduk.index') }}"
           class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Penduduk' }}
        </button>
      </div>

    </div>
  </form>
</div>
</x-admin-layout>
