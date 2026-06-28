<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function index()
    {
        $headerType    = Setting::get('header_type', 'default');
        $headerImage   = Setting::get('header_image');
        $headerVideo   = Setting::get('header_video');
        $headerPoster  = Setting::get('header_video_poster');
        $headerSlides  = json_decode(Setting::get('header_slideshow', '[]'), true) ?? [];

        return view('admin.header.index', compact(
            'headerType', 'headerImage', 'headerVideo', 'headerPoster', 'headerSlides'
        ));
    }

    public function aktifkan(Request $request)
    {
        $request->validate(['type' => 'required|in:default,image,slideshow,video']);
        Setting::set('header_type', $request->type);
        return back()->with('success', 'Tipe header berhasil diaktifkan.');
    }

    public function simpanImage(Request $request)
    {
        $request->validate(['gambar' => 'required|image|max:5120|mimes:jpg,jpeg,png,webp']);

        if ($old = Setting::get('header_image')) {
            Storage::disk('public')->delete($old);
        }

        $path = $request->file('gambar')->store('header', 'public');
        Setting::set('header_image', $path);

        return back()->with('success', 'Gambar header berhasil disimpan.');
    }

    public function hapusImage()
    {
        if ($old = Setting::get('header_image')) {
            Storage::disk('public')->delete($old);
        }
        Setting::set('header_image', null);
        return back()->with('success', 'Gambar header dihapus.');
    }

    public function simpanVideo(Request $request)
    {
        $request->validate([
            'video'  => 'nullable|mimes:mp4,webm|max:102400',
            'poster' => 'nullable|image|max:5120|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('video')) {
            if ($old = Setting::get('header_video')) {
                Storage::disk('public')->delete($old);
            }
            Setting::set('header_video', $request->file('video')->store('header', 'public'));
        }

        if ($request->hasFile('poster')) {
            if ($old = Setting::get('header_video_poster')) {
                Storage::disk('public')->delete($old);
            }
            Setting::set('header_video_poster', $request->file('poster')->store('header', 'public'));
        }

        return back()->with('success', 'Pengaturan video berhasil disimpan.');
    }

    public function hapusVideo(Request $request)
    {
        $target = $request->input('target');

        if ($target === 'video' && $old = Setting::get('header_video')) {
            Storage::disk('public')->delete($old);
            Setting::set('header_video', null);
        } elseif ($target === 'poster' && $old = Setting::get('header_video_poster')) {
            Storage::disk('public')->delete($old);
            Setting::set('header_video_poster', null);
        }

        return back()->with('success', 'File berhasil dihapus.');
    }

    public function addSlide(Request $request)
    {
        $request->validate(['gambar' => 'required|image|max:5120|mimes:jpg,jpeg,png,webp']);

        $slides = json_decode(Setting::get('header_slideshow', '[]'), true) ?? [];
        $path   = $request->file('gambar')->store('header/slides', 'public');
        $slides[] = $path;
        Setting::set('header_slideshow', json_encode(array_values($slides)));

        return back()->with('success', 'Slide berhasil ditambahkan.');
    }

    public function removeSlide(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        $path   = $request->input('path');
        $slides = json_decode(Setting::get('header_slideshow', '[]'), true) ?? [];

        // Pastikan path berada di dalam folder header/slides untuk keamanan
        if (str_starts_with($path, 'header/slides/')) {
            Storage::disk('public')->delete($path);
            $slides = array_values(array_filter($slides, fn($s) => $s !== $path));
            Setting::set('header_slideshow', json_encode($slides));
        }

        return back()->with('success', 'Slide berhasil dihapus.');
    }
}
