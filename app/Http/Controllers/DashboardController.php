<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Perdes;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'total'      => Perdes::count(),
            'selesai'    => Perdes::where('status', 'selesai')->count(),
            'draft'      => Perdes::where('status', 'draft')->count(),
            'tahun_ini'  => Perdes::whereYear('created_at', now()->year)->count(),
            'pengumuman' => Pengumuman::where('is_published', true)->count(),
            'berita'     => Pengumuman::where('tipe', 'berita')->where('is_published', true)->count(),
        ];

        $latestPerdes = Perdes::with('user')->latest()->take(5)->get();

        // Aktivitas: 6 perdes terakhir yang diupdate
        $activities = Perdes::with('user')->latest('updated_at')->take(6)->get();

        return view('dashboard', compact('counts', 'latestPerdes', 'activities'));
    }
}
