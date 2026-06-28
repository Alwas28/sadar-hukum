<x-admin-layout title="Generate Sambutan">
<div class="p-4 sm:p-6 max-w-2xl"
     x-data="{
       loading: false,
       error: '',
       generate() {
         this.error = '';
         const form = document.getElementById('form-sambutan');
         const data = new FormData(form);
         if (!data.get('judul') || !data.get('acara')) {
           this.error = 'Judul dan jenis acara wajib diisi.';
           return;
         }
         this.loading = true;
         fetch('{{ route('admin.sambutan.generate') }}', {
           method: 'POST',
           headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
           body: data,
         })
         .then(r => r.json().then(d => ({ ok: r.ok, d })))
         .then(({ ok, d }) => {
           if (!ok) { this.error = d.message || 'Terjadi kesalahan.'; this.loading = false; return; }
           window.location.href = d.redirect;
         })
         .catch(() => { this.error = 'Koneksi gagal. Periksa jaringan.'; this.loading = false; });
       }
     }">

  {{-- Header --}}
  <div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.sambutan.index') }}"
       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-100 transition-colors flex-shrink-0">
      <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h1 class="font-display text-xl font-bold text-gray-800">Generate Sambutan</h1>
      <p class="text-sm text-gray-500">Buat naskah sambutan Kepala Desa dengan AI</p>
    </div>
  </div>

  @if(! $aiReady)
    <div class="mb-5 flex items-start gap-3 px-4 py-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm">
      <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
      </svg>
      <span>Konfigurasi AI belum lengkap.
        <a href="{{ route('admin.pengaturan.index') }}" class="font-semibold underline">Atur di Pengaturan</a>
        terlebih dahulu.
      </span>
    </div>
  @endif

  <div x-show="error" x-text="error"
       class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm"></div>

  <form id="form-sambutan" @submit.prevent="generate" class="space-y-5">
    @csrf

    {{-- Jenis Acara & Judul --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
      <h3 class="text-sm font-bold text-gray-700 border-b border-gray-100 pb-2.5">Detail Acara</h3>

      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jenis Acara <span class="text-red-500">*</span></label>
        <select name="acara"
                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 transition-all bg-white">
          <option value="">-- Pilih Jenis Acara --</option>
          @foreach(\App\Models\Sambutan::acaraOptions() as $a)
            <option value="{{ $a }}">{{ $a }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul Sambutan <span class="text-red-500">*</span></label>
        <input type="text" name="judul" placeholder='Contoh: "Sambutan Kepala Desa pada HUT RI ke-80"'
               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all"/>
      </div>

      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
          Catatan / Poin Penting
          <span class="font-normal text-gray-400 ml-1">(opsional)</span>
        </label>
        <textarea name="catatan" rows="3"
                  placeholder="Tambahkan poin yang ingin disampaikan, tema khusus, atau instruksi tambahan untuk AI..."
                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-langit-400 focus:ring-2 focus:ring-langit-100 transition-all resize-none"></textarea>
      </div>
    </div>

    {{-- Tombol Generate --}}
    <button type="submit" :disabled="loading || {{ $aiReady ? 'false' : 'true' }}"
            class="w-full flex items-center justify-center gap-3 px-6 py-3.5 rounded-xl text-sm font-bold text-white transition-all
                   bg-hijau-700 hover:bg-hijau-800 hover:shadow-lg disabled:opacity-60 disabled:cursor-not-allowed">
      <template x-if="!loading">
        <span class="flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
          Generate Sambutan dengan AI
        </span>
      </template>
      <template x-if="loading">
        <span class="flex items-center gap-2">
          <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
          </svg>
          AI sedang menyusun sambutan...
        </span>
      </template>
    </button>

    <p class="text-center text-xs text-gray-400">Proses biasanya memakan waktu 10–30 detik</p>

  </form>
</div>
</x-admin-layout>
