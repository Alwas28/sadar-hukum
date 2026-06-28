<x-admin-layout :title="$idm ? 'Edit Data IDM' : 'Input Data IDM'">

@php
  $isEdit = (bool) $idm;
  $action = $isEdit ? route('admin.idm.update', $idm) : route('admin.idm.store');
@endphp

<div class="p-4 sm:p-6 max-w-2xl"
     x-data="{
       iks: '{{ old('skor_iks', $idm?->skor_iks ?? '') }}',
       ike: '{{ old('skor_ike', $idm?->skor_ike ?? '') }}',
       ikl: '{{ old('skor_ikl', $idm?->skor_ikl ?? '') }}',
       get idm() {
         let v = (parseFloat(this.iks || 0) + parseFloat(this.ike || 0) + parseFloat(this.ikl || 0)) / 3;
         return isNaN(v) ? '0.0000' : v.toFixed(4);
       },
       get statusOtomatis() {
         let s = parseFloat(this.idm);
         if (s < 0.491) return 'Sangat Tertinggal';
         if (s < 0.599) return 'Tertinggal';
         if (s < 0.707) return 'Berkembang';
         if (s < 0.815) return 'Maju';
         return 'Mandiri';
       }
     }">

  {{-- Header --}}
  <div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.idm.index') }}"
       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-100 transition-colors flex-shrink-0">
      <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h1 class="font-display text-xl font-bold text-gray-800">
        {{ $isEdit ? 'Edit Data IDM' : 'Input Data IDM' }}
      </h1>
      <p class="text-sm text-gray-500">Indeks Desa Membangun</p>
    </div>
  </div>

  @if($errors->any())
    <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
      <p class="font-semibold mb-1">Terdapat kesalahan input:</p>
      <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ $action }}">
    @csrf
    @if($isEdit) @method('PATCH') @endif

    <div class="space-y-5">

      {{-- Tahun & Status --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <h3 class="text-sm font-bold text-gray-700 border-b border-gray-100 pb-2.5">Informasi Umum</h3>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tahun <span class="text-red-500">*</span></label>
            <input type="number" name="tahun" value="{{ old('tahun', $idm?->tahun ?? date('Y')) }}"
                   min="2000" max="{{ date('Y') + 1 }}"
                   class="w-full px-3 py-2 text-sm border @error('tahun') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono"/>
            @error('tahun')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status IDM <span class="text-red-500">*</span></label>
            <select name="status"
                    class="w-full px-3 py-2 text-sm border @error('status') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
              <option value="">-- Pilih --</option>
              @foreach(\App\Models\Idm::statusOptions() as $s)
                <option value="{{ $s }}" @selected(old('status', $idm?->status) === $s)>{{ $s }}</option>
              @endforeach
            </select>
            @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            <p class="mt-1 text-xs text-gray-400">
              Otomatis dari skor: <span class="font-semibold text-gray-600" x-text="statusOtomatis"></span>
            </p>
          </div>
        </div>
      </div>

      {{-- Skor --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-2.5">
          <h3 class="text-sm font-bold text-gray-700">Skor Indeks</h3>
          <div class="text-right">
            <div class="text-xs text-gray-400">Skor IDM (rata-rata)</div>
            <div class="text-lg font-display font-black text-gray-800" x-text="idm"></div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
              IKS <span class="text-red-500">*</span>
              <span class="font-normal text-gray-400">— Ketahanan Sosial</span>
            </label>
            <input type="number" name="skor_iks" x-model="iks"
                   min="0" max="1" step="0.0001"
                   placeholder="0.0000"
                   class="w-full px-3 py-2 text-sm border @error('skor_iks') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono"/>
            @error('skor_iks')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
              IKE <span class="text-red-500">*</span>
              <span class="font-normal text-gray-400">— Ketahanan Ekonomi</span>
            </label>
            <input type="number" name="skor_ike" x-model="ike"
                   min="0" max="1" step="0.0001"
                   placeholder="0.0000"
                   class="w-full px-3 py-2 text-sm border @error('skor_ike') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono"/>
            @error('skor_ike')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
              IKL <span class="text-red-500">*</span>
              <span class="font-normal text-gray-400">— Ketahanan Lingkungan</span>
            </label>
            <input type="number" name="skor_ikl" x-model="ikl"
                   min="0" max="1" step="0.0001"
                   placeholder="0.0000"
                   class="w-full px-3 py-2 text-sm border @error('skor_ikl') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all font-mono"/>
            @error('skor_ikl')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>
        </div>

        {{-- hidden skor_idm auto-computed --}}
        <input type="hidden" name="skor_idm" :value="idm"/>

        {{-- Progress bar visual --}}
        <div class="pt-1">
          <div class="flex justify-between text-xs text-gray-400 mb-1">
            <span>0</span>
            <span class="text-gray-600 font-semibold" x-text="'Skor IDM: ' + idm"></span>
            <span>1</span>
          </div>
          <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-3 rounded-full transition-all duration-300"
                 :style="'width: ' + (Math.min(parseFloat(idm), 1) * 100) + '%'"
                 :class="{
                   'bg-red-400':    parseFloat(idm) < 0.491,
                   'bg-orange-400': parseFloat(idm) >= 0.491 && parseFloat(idm) < 0.599,
                   'bg-yellow-400': parseFloat(idm) >= 0.599 && parseFloat(idm) < 0.707,
                   'bg-langit-400': parseFloat(idm) >= 0.707 && parseFloat(idm) < 0.815,
                   'bg-hijau-500':  parseFloat(idm) >= 0.815,
                 }"></div>
          </div>
          <div class="flex justify-between text-xs text-gray-400 mt-1">
            <span>Sangat Tertinggal</span>
            <span>Tertinggal</span>
            <span>Berkembang</span>
            <span>Maju</span>
            <span>Mandiri</span>
          </div>
        </div>
      </div>

      {{-- Keterangan --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Keterangan / Catatan</label>
        <textarea name="keterangan" rows="3" placeholder="Catatan tambahan, prioritas program, dll (opsional)"
                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none">{{ old('keterangan', $idm?->keterangan) }}</textarea>
      </div>

      {{-- Actions --}}
      <div class="flex items-center justify-between pt-1">
        <a href="{{ route('admin.idm.index') }}"
           class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl transition-colors">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-hijau-700 hover:bg-hijau-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data IDM' }}
        </button>
      </div>

    </div>
  </form>
</div>
</x-admin-layout>
