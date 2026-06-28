{{-- Konten hero — dipakai oleh semua tipe header (default/image/slideshow/video) --}}
@php $isOverlay = in_array($headerType ?? 'default', ['image','slideshow','video']); @endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative
     {{ $isOverlay ? 'pt-20 pb-16 md:pt-24 md:pb-20' : 'py-20 md:py-28' }}"
     style="z-index:2">
  <div class="grid md:grid-cols-2 gap-12 items-center">
    <div class="text-white">
      <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emas-400/20 border border-emas-400/40 rounded-full text-emas-300 text-xs font-semibold mb-6 badge-glow">
        <span class="w-2 h-2 bg-emas-400 rounded-full animate-pulse"></span>
        Sistem Informasi Resmi Desa
      </div>
      <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-black leading-tight mb-6">
        Sadar Hukum<br/>
        <span class="text-emas-400">Desa Tontonunu</span>
      </h1>
      <p class="text-white/80 text-base md:text-lg leading-relaxed mb-8 max-w-md">
        Portal transparansi dan informasi peraturan desa untuk warga Tontonunu, Kabupaten Bombana, Sulawesi Tenggara. Hukum untuk semua, bukan untuk segelintir.
      </p>
      <div class="flex flex-col sm:flex-row gap-3">
        <a href="#peraturan" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emas-500 hover:bg-emas-400 text-gray-900 font-bold rounded-xl transition-all hover:scale-105 shadow-lg">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          Lihat Peraturan
        </a>
        <a href="#tentang" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-white/30 hover:bg-white/10 text-white font-semibold rounded-xl transition-all">
          Pelajari Lebih
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-5 card-hover">
        <div class="text-3xl font-display font-black text-emas-400 mb-1">24</div>
        <div class="text-sm text-white/70">Peraturan Desa Aktif</div>
      </div>
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-5 card-hover">
        <div class="text-3xl font-display font-black text-emas-400 mb-1">12</div>
        <div class="text-sm text-white/70">SK Kepala Desa</div>
      </div>
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-5 card-hover">
        <div class="text-3xl font-display font-black text-emas-400 mb-1">1.2K</div>
        <div class="text-sm text-white/70">Unduhan Dokumen</div>
      </div>
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-5 card-hover">
        <div class="text-3xl font-display font-black text-emas-400 mb-1">2026</div>
        <div class="text-sm text-white/70">Tahun Berjalan</div>
      </div>
    </div>
  </div>
</div>

@if(($headerType ?? 'default') === 'default')
<div class="absolute bottom-0 left-0 right-0" style="z-index:2">
  <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-12 md:h-16">
    <path d="M0,60 C360,0 1080,60 1440,20 L1440,60 Z" fill="{{ $isDark ? '#111827' : '#f9fafb' }}"/>
  </svg>
</div>
@endif
