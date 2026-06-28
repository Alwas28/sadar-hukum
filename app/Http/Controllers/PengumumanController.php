<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    private function uniqueSlug(string $judul, ?int $excludeId = null): string
    {
        $base = Str::slug($judul);
        $slug = $base;
        $i    = 1;
        while (
            Pengumuman::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function queryFiltered(Request $request, string $tipe)
    {
        return Pengumuman::with('user')
            ->where('tipe', $tipe)
            ->when($request->filled('kategori'), fn($q) => $q->where('kategori', $request->kategori))
            ->when($request->filled('q'),        fn($q) => $q->where('judul', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function indexPengumuman(Request $request)
    {
        $items = $this->queryFiltered($request, 'pengumuman');
        return view('admin.pengumuman.index', compact('items'));
    }

    public function indexBerita(Request $request)
    {
        $items = $this->queryFiltered($request, 'berita');
        return view('admin.berita.index', compact('items'));
    }

    public function createPengumuman()
    {
        return view('admin.pengumuman.create');
    }

    public function createBerita()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipe'              => 'required|in:berita,pengumuman',
            'kategori'          => 'required|in:penting,info,kegiatan,umum',
            'judul'             => 'required|string|max:255',
            'ringkasan'         => 'nullable|string|max:500',
            'isi'               => 'required|string',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tanggal_publikasi' => 'required|date',
            'is_published'      => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $data['user_id']      = auth()->id();
        $data['is_published'] = $request->boolean('is_published');
        $data['slug']         = $this->uniqueSlug($data['judul']);

        $item = Pengumuman::create($data);

        $route = $data['tipe'] === 'berita' ? 'admin.berita.index' : 'admin.pengumuman.index';
        return redirect()->route($route)->with('success', ucfirst($data['tipe']).' berhasil disimpan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function editBerita(Pengumuman $pengumuman)
    {
        return view('admin.berita.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->validate([
            'tipe'              => 'required|in:berita,pengumuman',
            'kategori'          => 'required|in:penting,info,kegiatan,umum',
            'judul'             => 'required|string|max:255',
            'ringkasan'         => 'nullable|string|max:500',
            'isi'               => 'required|string',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tanggal_publikasi' => 'required|date',
            'is_published'      => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $data['is_published'] = $request->boolean('is_published');
        if ($data['judul'] !== $pengumuman->judul || !$pengumuman->slug) {
            $data['slug'] = $this->uniqueSlug($data['judul'], $pengumuman->id);
        }
        $pengumuman->update($data);

        return redirect($pengumuman->indexRoute())->with('success', 'Berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $redirect = $pengumuman->indexRoute();
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }
        $pengumuman->delete();

        return redirect($redirect)->with('success', 'Berhasil dihapus.');
    }

    public function togglePublish(Pengumuman $pengumuman)
    {
        $pengumuman->update(['is_published' => !$pengumuman->is_published]);
        return back()->with('success', $pengumuman->is_published ? 'Dipublikasikan.' : 'Disembunyikan.');
    }
}
