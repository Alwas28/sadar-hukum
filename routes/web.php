<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\PartisipasiController;
use App\Http\Controllers\IdmController;
use App\Http\Controllers\SambutanController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PerdesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang-program', function () {
    return view('tentang-program');
})->name('tentang-program');

Route::get('/panduan', function () {
    return view('panduan');
})->name('panduan');

Route::get('/berita/{slug}', function ($slug) {
    $berita = \App\Models\Pengumuman::where('slug', $slug)
        ->where('tipe', 'berita')
        ->where('is_published', true)
        ->firstOrFail();
    return view('berita.show', compact('berita'));
})->name('berita.show');

// Partisipasi Warga (harus login, role warga)
Route::middleware('auth')->prefix('partisipasi')->name('partisipasi.')->group(function () {
    Route::get('/',               [PartisipasiController::class, 'index'])->name('index');
    Route::get('/{perdes}',       [PartisipasiController::class, 'show'])->name('show');
    Route::post('/{perdes}/vote', [PartisipasiController::class, 'vote'])->name('vote');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tentang Desa
    Route::get('/admin/tentang',                        [TentangController::class, 'index'])->name('admin.tentang.index');
    Route::post('/admin/tentang',                       [TentangController::class, 'update'])->name('admin.tentang.update');
    Route::delete('/admin/tentang/{jabatan}/foto',      [TentangController::class, 'hapusFoto'])->name('admin.tentang.hapus-foto');
    Route::delete('/admin/tentang/logo',                [TentangController::class, 'hapusLogo'])->name('admin.tentang.hapus-logo');

    // Pengaturan
    Route::get('/admin/pengaturan',  [SettingController::class, 'index'])->name('admin.pengaturan.index');
    Route::post('/admin/pengaturan', [SettingController::class, 'update'])->name('admin.pengaturan.update');

    // Perdes (Buat Perdes Baru via AI)
    Route::prefix('admin/perdes')->name('admin.perdes.')->group(function () {
        Route::get('/',           [PerdesController::class, 'index'])->name('index');
        Route::get('/create',     [PerdesController::class, 'create'])->name('create');
        Route::post('/generate',  [PerdesController::class, 'generate'])->name('generate');
        Route::get('/{perdes}',     [PerdesController::class, 'show'])->name('show');
        Route::get('/{perdes}/pdf', [PerdesController::class, 'pdf'])->name('pdf');
        Route::patch('/{perdes}/toggle', [PerdesController::class, 'toggleStatus'])->name('toggle');
        Route::patch('/{perdes}',  [PerdesController::class, 'update'])->name('update');
        Route::delete('/{perdes}', [PerdesController::class, 'destroy'])->name('destroy');
    });

    // Halaman Statis
    Route::prefix('admin/halaman')->name('admin.halaman.')->group(function () {
        Route::get('/',                      [HalamanController::class, 'index'])->name('index');
        Route::get('/create',                [HalamanController::class, 'create'])->name('create');
        Route::post('/',                     [HalamanController::class, 'store'])->name('store');
        Route::get('/{halaman}/edit',        [HalamanController::class, 'edit'])->name('edit');
        Route::patch('/{halaman}',           [HalamanController::class, 'update'])->name('update');
        Route::delete('/{halaman}',          [HalamanController::class, 'destroy'])->name('destroy');
        Route::patch('/{halaman}/toggle',    [HalamanController::class, 'togglePublish'])->name('toggle');
        Route::delete('/{halaman}/foto',     [HalamanController::class, 'hapusFoto'])->name('hapus-foto');
    });

    // Sambutan Kepala Desa
    Route::prefix('admin/sambutan')->name('admin.sambutan.')->group(function () {
        Route::get('/',                 [SambutanController::class, 'index'])->name('index');
        Route::get('/create',           [SambutanController::class, 'create'])->name('create');
        Route::post('/generate',        [SambutanController::class, 'generate'])->name('generate');
        Route::get('/{sambutan}',       [SambutanController::class, 'show'])->name('show');
        Route::patch('/{sambutan}',     [SambutanController::class, 'update'])->name('update');
        Route::delete('/{sambutan}',    [SambutanController::class, 'destroy'])->name('destroy');
    });

    // IDM
    Route::prefix('admin/idm')->name('admin.idm.')->group(function () {
        Route::get('/',              [IdmController::class, 'index'])->name('index');
        Route::get('/create',        [IdmController::class, 'create'])->name('create');
        Route::post('/',             [IdmController::class, 'store'])->name('store');
        Route::get('/{idm}/edit',    [IdmController::class, 'edit'])->name('edit');
        Route::patch('/{idm}',       [IdmController::class, 'update'])->name('update');
        Route::delete('/{idm}',      [IdmController::class, 'destroy'])->name('destroy');
    });

    // Header Homepage
    Route::prefix('admin/header')->name('admin.header.')->group(function () {
        Route::get('/',                   [HeaderController::class, 'index'])->name('index');
        Route::post('/aktifkan',          [HeaderController::class, 'aktifkan'])->name('aktifkan');
        Route::post('/simpan-image',      [HeaderController::class, 'simpanImage'])->name('simpan-image');
        Route::delete('/hapus-image',     [HeaderController::class, 'hapusImage'])->name('hapus-image');
        Route::post('/simpan-video',      [HeaderController::class, 'simpanVideo'])->name('simpan-video');
        Route::delete('/hapus-video',     [HeaderController::class, 'hapusVideo'])->name('hapus-video');
        Route::post('/add-slide',         [HeaderController::class, 'addSlide'])->name('add-slide');
        Route::delete('/remove-slide',    [HeaderController::class, 'removeSlide'])->name('remove-slide');
    });

    // Data Penduduk
    Route::prefix('admin/penduduk')->name('admin.penduduk.')->group(function () {
        Route::get('/',              [PendudukController::class, 'index'])->name('index');
        Route::get('/create',        [PendudukController::class, 'create'])->name('create');
        Route::post('/',             [PendudukController::class, 'store'])->name('store');
        Route::get('/{penduduk}/edit',   [PendudukController::class, 'edit'])->name('edit');
        Route::patch('/{penduduk}',  [PendudukController::class, 'update'])->name('update');
        Route::delete('/{penduduk}', [PendudukController::class, 'destroy'])->name('destroy');
    });

    // Pengumuman
    Route::prefix('admin/pengumuman')->name('admin.pengumuman.')->group(function () {
        Route::get('/',                      [PengumumanController::class, 'indexPengumuman'])->name('index');
        Route::get('/create',                [PengumumanController::class, 'createPengumuman'])->name('create');
        Route::post('/',                     [PengumumanController::class, 'store'])->name('store');
        Route::get('/{pengumuman}/edit',     [PengumumanController::class, 'edit'])->name('edit');
        Route::patch('/{pengumuman}',        [PengumumanController::class, 'update'])->name('update');
        Route::delete('/{pengumuman}',       [PengumumanController::class, 'destroy'])->name('destroy');
        Route::patch('/{pengumuman}/toggle', [PengumumanController::class, 'togglePublish'])->name('toggle');
    });

    // Berita
    Route::prefix('admin/berita')->name('admin.berita.')->group(function () {
        Route::get('/',                      [PengumumanController::class, 'indexBerita'])->name('index');
        Route::get('/create',                [PengumumanController::class, 'createBerita'])->name('create');
        Route::post('/',                     [PengumumanController::class, 'store'])->name('store');
        Route::get('/{pengumuman}/edit',     [PengumumanController::class, 'editBerita'])->name('edit');
        Route::patch('/{pengumuman}',        [PengumumanController::class, 'update'])->name('update');
        Route::delete('/{pengumuman}',       [PengumumanController::class, 'destroy'])->name('destroy');
        Route::patch('/{pengumuman}/toggle', [PengumumanController::class, 'togglePublish'])->name('toggle');
    });
});

require __DIR__.'/auth.php';
