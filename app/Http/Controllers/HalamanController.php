<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HalamanController extends Controller
{
    public function index()
    {
        $halamans = Halaman::with('user')->orderBy('urutan')->orderByDesc('created_at')->paginate(12);
        return view('admin.halaman.index', compact('halamans'));
    }

    public function create()
    {
        return view('admin.halaman.form', ['halaman' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id']      = auth()->id();
        $data['slug']         = $this->uniqueSlug($data['judul']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('halaman', 'public');
        }

        Halaman::create($data);
        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil disimpan.');
    }

    public function edit(Halaman $halaman)
    {
        return view('admin.halaman.form', compact('halaman'));
    }

    public function update(Request $request, Halaman $halaman)
    {
        $data = $this->validated($request, $halaman->id);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('foto')) {
            if ($halaman->foto) Storage::disk('public')->delete($halaman->foto);
            $data['foto'] = $request->file('foto')->store('halaman', 'public');
        }

        if ($data['judul'] !== $halaman->judul) {
            $data['slug'] = $this->uniqueSlug($data['judul'], $halaman->id);
        }

        $halaman->update($data);
        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Halaman $halaman)
    {
        if ($halaman->foto) Storage::disk('public')->delete($halaman->foto);
        $halaman->delete();
        return back()->with('success', 'Halaman berhasil dihapus.');
    }

    public function togglePublish(Halaman $halaman)
    {
        $halaman->update(['is_published' => ! $halaman->is_published]);
        return back()->with('success', $halaman->is_published ? 'Halaman diterbitkan.' : 'Halaman disembunyikan.');
    }

    public function hapusFoto(Halaman $halaman)
    {
        if ($halaman->foto) {
            Storage::disk('public')->delete($halaman->foto);
            $halaman->update(['foto' => null]);
        }
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    private function uniqueSlug(string $judul, ?int $excludeId = null): string
    {
        $base = Str::slug($judul);
        $slug = $base;
        $i    = 1;
        while (
            Halaman::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function validated(Request $request, ?int $excludeId = null): array
    {
        return $request->validate([
            'judul'        => 'required|string|max:200',
            'ringkasan'    => 'nullable|string|max:500',
            'isi'          => 'required|string',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'urutan'       => 'nullable|integer|min:0|max:999',
            'is_published' => 'boolean',
        ]);
    }
}
