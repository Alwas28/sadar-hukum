<x-admin-layout title="Buat Perdes Baru">

@push('styles')
<style>
  @keyframes ai-spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
  .ai-spin { animation: ai-spin 0.9s linear infinite; display: block; }
</style>
@endpush

<div class="p-4 sm:p-6">
  <div class="max-w-3xl mx-auto space-y-5"
       x-data="{
         aiReady: {{ $aiReady ? 'true' : 'false' }},
         jenis: 'perdes',
         judul: '',
         catatan: '',
         loading: false,
         errorMsg: '',
         async generate() {
           if (!this.aiReady || this.loading) { return; }
           if (!this.judul.trim()) { this.errorMsg = 'Judul/topik wajib diisi.'; return; }
           this.loading = true;
           this.errorMsg = '';
           try {
             const res = await fetch('{{ route('admin.perdes.generate') }}', {
               method: 'POST',
               headers: {
                 'Content-Type': 'application/json',
                 'Accept': 'application/json',
                 'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
               },
               body: JSON.stringify({ jenis: this.jenis, judul: this.judul, catatan: this.catatan }),
             });
             const data = await res.json();
             if (!res.ok) {
               this.errorMsg = data.message || 'Gagal membuat draf.';
               this.loading = false;
               return;
             }
             window.location.href = data.redirect;
           } catch (e) {
             this.errorMsg = 'Tidak dapat menghubungi server. Periksa koneksi Anda.';
             this.loading = false;
           }
         },
       }">

    {{-- Loading overlay: blocks all interaction while AI generates the draft --}}
    <div x-show="loading" style="display:none;background:rgba(255,255,255,0.93);z-index:9999;position:fixed;top:0;left:0;right:0;bottom:0;"
         class="flex items-center justify-center">
      <div style="display:flex;flex-direction:column;align-items:center;gap:20px;padding:40px 48px;background:#fff;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.12);border:1px solid #f3f4f6;">
        {{-- Spinner --}}
        <div style="position:relative;width:56px;height:56px;">
          <svg style="position:absolute;top:0;left:0;width:56px;height:56px;color:#d1fae5;" fill="none" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
          </svg>
          <svg class="ai-spin" style="position:absolute;top:0;left:0;width:56px;height:56px;color:#16a34a;" fill="none" viewBox="0 0 24 24">
            <path fill="currentColor" opacity="0.85" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
          </svg>
        </div>
        {{-- Text --}}
        <div style="text-align:center;">
          <p style="font-size:15px;font-weight:700;color:#1f2937;margin:0 0 6px;">AI sedang membuat draf...</p>
          <p style="font-size:13px;color:#6b7280;margin:0;">Mohon tunggu, jangan tutup atau muat ulang halaman ini.</p>
        </div>
      </div>
    </div>

    {{-- Header --}}
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.perdes.index') }}"
         class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </a>
      <div>
        <div class="flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emas-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-emas-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h1 class="font-display text-2xl font-bold text-gray-800">Buat Perdes Baru</h1>
          <span class="px-1.5 py-0.5 text-xs bg-emas-500 text-hijau-900 rounded-md font-bold">AI</span>
        </div>
        <p class="text-sm text-gray-500 mt-0.5 ml-9">Buat draf regulasi desa otomatis dengan bantuan AI</p>
      </div>
    </div>

    @unless($aiReady)
      <div class="flex items-start gap-3 px-4 py-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-8.18 14.18A1 1 0 003 19.18h18a1 1 0 00.89-1.14L13.71 3.86a1 1 0 00-1.42 0z"/>
        </svg>
        <div>
          Konfigurasi AI belum lengkap. Atur penyedia, model, dan API key terlebih dahulu di
          <a href="{{ route('admin.pengaturan.index') }}" class="font-semibold underline">halaman Pengaturan</a>.
        </div>
      </div>
    @endunless

    <div class="grid gap-5">

      {{-- Jenis --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Regulasi <span class="text-red-500">*</span></label>
        <div class="grid grid-cols-3 gap-2 sm:gap-3">
          @php
          $jenisOptions = [
            'perdes' => [
              'label' => 'Peraturan Desa',
              'desc' => 'Mengikat warga desa secara umum',
              'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            ],

            'perkades' => [
              'label' => 'Peraturan Kepala Desa',
              'desc' => 'Petunjuk pelaksanaan teknis',
              'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
            ],
            'sk_kades' => [
              'label' => 'SK Kepala Desa',
              'desc' => 'Keputusan administratif tertentu',
              'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            ],
          ];
          @endphp
          @foreach($jenisOptions as $val => $opt)
          <label class="cursor-pointer">
            <input type="radio" name="jenis" value="{{ $val }}" x-model="jenis" :disabled="loading" class="sr-only peer"/>
            <div class="flex flex-col items-center gap-1.5 sm:gap-2 p-2 sm:p-4 text-center rounded-xl border-2 border-gray-200
                        peer-checked:border-hijau-500 peer-checked:bg-hijau-50 hover:border-gray-300 transition-all h-full">
              <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-hijau-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-hijau-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $opt['icon'] }}"/>
                </svg>
              </div>
              <span class="text-[11px] sm:text-xs font-semibold text-gray-700 leading-tight">{{ $opt['label'] }}</span>
              <span class="hidden sm:block text-[11px] text-gray-400 leading-tight">{{ $opt['desc'] }}</span>
            </div>
          </label>
          @endforeach
        </div>
      </div>

      {{-- Judul & catatan --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul / Topik <span class="text-red-500">*</span></label>
          <input type="text" x-model="judul" placeholder="Contoh: Pengelolaan Sampah Rumah Tangga di Tingkat Desa"
                 :disabled="loading"
                 class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all disabled:bg-gray-50"/>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Catatan / Instruksi Tambahan <span class="font-normal text-gray-400">(opsional)</span>
          </label>
          <textarea x-model="catatan" rows="3" :disabled="loading"
                    placeholder="Contoh: sertakan sanksi denda, masa berlaku 5 tahun, mengacu pada Perda kabupaten terkait..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-hijau-400 focus:ring-2 focus:ring-hijau-100 transition-all resize-none disabled:bg-gray-50"></textarea>
        </div>

        <p x-show="errorMsg" x-text="errorMsg" class="text-xs text-red-500" style="display:none"></p>

        <div class="flex justify-end">
          <button type="button" @click="generate()" :disabled="loading || !aiReady"
                  class="inline-flex items-center gap-2 px-6 py-2.5 bg-hijau-700 hover:bg-hijau-800 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-xl transition-all hover:shadow-md">
            <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" style="display:none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span x-text="loading ? 'Membuat draf...' : 'Generate dengan AI'"></span>
          </button>
        </div>
      </div>

    </div>

  </div>
</div>

</x-admin-layout>
