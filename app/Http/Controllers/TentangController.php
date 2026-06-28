<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangController extends Controller
{
    public function index()
    {
        $s       = Setting::pluck('value', 'key');
        $struktur = StrukturDesa::all()->keyBy('jabatan');
        return view('admin.tentang.index', compact('s', 'struktur'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'about_desc1'         => 'nullable|string|max:1000',
            'about_desc2'         => 'nullable|string|max:1000',
            'about_stat1_value'   => 'nullable|string|max:20',
            'about_stat1_label'   => 'nullable|string|max:50',
            'about_stat2_value'   => 'nullable|string|max:20',
            'about_stat2_label'   => 'nullable|string|max:50',
            'desa_stat_penduduk'  => 'nullable|string|max:20',
            'desa_stat_kk'        => 'nullable|string|max:20',
            'desa_stat_peraturan' => 'nullable|string|max:20',
            'desa_stat_dusun'     => 'nullable|string|max:20',
            'contact_address'     => 'nullable|string|max:200',
            'contact_phone'       => 'nullable|string|max:50',
            'contact_hours'       => 'nullable|string|max:100',
            'contact_email'       => 'nullable|email|max:100',
            'nama.*'              => 'nullable|string|max:100',
            'foto.*'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'logo'                => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        // Logo desa (dipakai pada kop surat PDF dan draf AI)
        if ($request->hasFile('logo')) {
            $old = Setting::get('desa_logo');
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            Setting::set('desa_logo', $request->file('logo')->store('desa', 'public'));
        }

        // Teks settings
        $keys = ['about_desc1','about_desc2','about_stat1_value','about_stat1_label','about_stat2_value','about_stat2_label','desa_stat_penduduk','desa_stat_kk','desa_stat_peraturan','desa_stat_dusun','contact_address','contact_phone','contact_hours','contact_email'];
        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        // Struktur organisasi
        foreach (StrukturDesa::positions() as $jabatan) {
            $data = ['nama' => $request->input("nama.$jabatan") ?? ''];

            if ($request->hasFile("foto.$jabatan")) {
                $existing = StrukturDesa::find($jabatan);
                if ($existing?->foto) {
                    Storage::disk('public')->delete($existing->foto);
                }
                $data['foto'] = $request->file("foto.$jabatan")->store('struktur', 'public');
            }

            StrukturDesa::updateOrCreate(['jabatan' => $jabatan], $data);
        }

        return back()->with('success', 'Data tentang desa berhasil disimpan.');
    }

    public function hapusFoto(string $jabatan)
    {
        $member = StrukturDesa::findOrFail($jabatan);
        if ($member->foto) {
            Storage::disk('public')->delete($member->foto);
            $member->update(['foto' => null]);
        }
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function hapusLogo()
    {
        $logo = Setting::get('desa_logo');
        if ($logo) {
            Storage::disk('public')->delete($logo);
            Setting::set('desa_logo', '');
        }
        return back()->with('success', 'Logo desa berhasil dihapus.');
    }
}
