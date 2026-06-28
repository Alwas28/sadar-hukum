@extends('layouts.public')

@section('title', $berita->judul)

@php $activeNav = ''; @endphp

@section('styles')
.prose-berita h2 { font-size:1.25rem; font-weight:700; color:#1f2937; margin:1.5rem 0 0.75rem; }
.prose-berita h3 { font-size:1.1rem; font-weight:600; color:#374151; margin:1.25rem 0 0.5rem; }
.prose-berita p  { color:#4b5563; line-height:1.75; margin-bottom:1rem; }
.prose-berita ul, .prose-berita ol { padding-left:1.5rem; margin-bottom:1rem; color:#4b5563; }
.prose-berita li { margin-bottom:0.25rem; }
.prose-berita strong { color:#111827; }
.prose-berita a { color:var(--p-700); text-decoration:underline; }
.dark .prose-berita h2 { color:#f9fafb; }
.dark .prose-berita h3 { color:#e5e7eb; }
.dark .prose-berita p, .dark .prose-berita li { color:#9ca3af; }
.dark .prose-berita strong { color:#f3f4f6; }
@endsection

@section('content')

{{-- Hero Image --}}
@if($berita->gambar)
<div class="w-full h-64 md:h-96 overflow-hidden relative">
  <img src="{{ asset('storage/'.$berita->gambar) }}"
       alt="{{ $berita->judul }}"
       class="w-full h-full object-cover"/>
  <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
</div>
@endif

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

  {{-- Breadcrumb --}}
  <nav class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-8">
    <a href="{{ url('/') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Beranda</a>
    <span>›</span>
    <span class="text-gray-500 dark:text-gray-400">Berita Desa</span>
    <span>›</span>
    <span class="text-gray-700 dark:text-gray-300 truncate max-w-xs">{{ $berita->judul }}</span>
  </nav>

  {{-- Meta --}}
  <div class="flex flex-wrap items-center gap-3 mb-5">
    @if($berita->kategori)
    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-400">
      {{ $berita->kategori }}
    </span>
    @endif
    <span class="flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
      {{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') : '' }}
    </span>
  </div>

  {{-- Judul --}}
  <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-800 dark:text-white leading-tight mb-6">
    {{ $berita->judul }}
  </h1>

  {{-- Ringkasan --}}
  @if($berita->ringkasan)
  <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed border-l-4 pl-4 mb-8"
     style="border-color:var(--p-500)">
    {{ $berita->ringkasan }}
  </p>
  @endif

  {{-- Divider --}}
  <hr class="border-gray-100 dark:border-gray-700 mb-8"/>

  {{-- Isi --}}
  <div class="prose-berita">
    {!! $berita->isi !!}
  </div>

  {{-- Divider --}}
  <hr class="border-gray-100 dark:border-gray-700 mt-10 mb-8"/>

  {{-- Back button --}}
  <a href="{{ url('/') }}#beranda"
     class="inline-flex items-center gap-2 text-sm font-semibold transition-colors"
     style="color:var(--p-700)">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Kembali ke Beranda
  </a>

</div>

@endsection
