<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $s = Setting::pluck('value', 'key');
        return view('admin.pengaturan.index', compact('s'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'theme_mode'      => 'required|in:light,dark',
            'theme_color'     => 'required|in:hijau,langit,biru,ungu,merah,emas',
            'ai_provider'     => 'nullable|in:openai,anthropic,google',
            'ai_model'        => 'nullable|string|max:150',
            'ai_api_key'      => 'nullable|string|max:500',
            'ai_prompt_template_perdes'   => 'nullable|string|max:5000',
            'ai_prompt_template_perkades' => 'nullable|string|max:5000',
            'ai_prompt_template_sk_kades' => 'nullable|string|max:5000',
            'desa_nama'       => 'nullable|string|max:100',
            'desa_kecamatan'  => 'nullable|string|max:100',
            'desa_kabupaten'  => 'nullable|string|max:100',
            'desa_provinsi'   => 'nullable|string|max:100',
            'pdf_font_family'   => 'nullable|in:Arial,Times New Roman,Courier New,DejaVu Sans',
            'pdf_font_size'     => 'nullable|integer|in:10,11,12,14',
            'pdf_line_spacing'  => 'nullable|in:1.0,1.15,1.5,2.0',
            'pdf_margin_top'    => 'nullable|numeric|min:1|max:6',
            'pdf_margin_left'   => 'nullable|numeric|min:1|max:6',
            'pdf_margin_right'  => 'nullable|numeric|min:1|max:6',
            'pdf_margin_bottom' => 'nullable|numeric|min:1|max:6',
        ]);

        Setting::set('theme_mode',  $request->theme_mode);
        Setting::set('theme_color', $request->theme_color);
        Setting::set('ai_provider', $request->ai_provider ?? '');
        Setting::set('ai_model',    $request->ai_model ?? '');

        if ($request->filled('ai_api_key') && $request->ai_api_key !== str_repeat('•', 32)) {
            Setting::set('ai_api_key', encrypt($request->ai_api_key));
        }

        foreach (['perdes', 'perkades', 'sk_kades'] as $jenis) {
            Setting::set("ai_prompt_template_{$jenis}", $request->input("ai_prompt_template_{$jenis}", ''));
        }

        foreach (['desa_nama', 'desa_kecamatan', 'desa_kabupaten', 'desa_provinsi'] as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        foreach (['pdf_font_family', 'pdf_font_size', 'pdf_line_spacing', 'pdf_margin_top', 'pdf_margin_left', 'pdf_margin_right', 'pdf_margin_bottom'] as $key) {
            if ($request->filled($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
