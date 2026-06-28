<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterWargaController extends Controller
{
    private const SESSION_KEY = 'register_penduduk_id';

    /** Tahap 1 — form verifikasi NIK + tanggal lahir */
    public function showVerifikasi()
    {
        return view('auth.register');
    }

    /** Tahap 1 submit — cek NIK + tanggal lahir di data penduduk */
    public function verifikasi(Request $request)
    {
        $request->validate([
            'nik'            => 'required|digits:16',
            'tanggal_lahir'  => 'required|date',
        ], [
            'nik.required'           => 'NIK wajib diisi.',
            'nik.digits'             => 'NIK harus 16 digit angka.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
        ]);

        $penduduk = Penduduk::where('nik', $request->nik)
            ->whereDate('tanggal_lahir', $request->tanggal_lahir)
            ->where('aktif', true)
            ->first();

        if (! $penduduk) {
            return back()
                ->withInput()
                ->withErrors(['nik' => 'NIK dan tanggal lahir tidak cocok dengan data penduduk desa.']);
        }

        // Cek apakah sudah punya akun
        if (User::where('penduduk_id', $penduduk->id)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['nik' => 'NIK ini sudah terdaftar. Silakan login menggunakan akun Anda.']);
        }

        // Simpan penduduk_id ke session untuk diverifikasi di tahap 2
        session([self::SESSION_KEY => $penduduk->id]);

        return redirect()->route('register.akun');
    }

    /** Tahap 2 — form buat akun (nama sudah terisi dari data penduduk) */
    public function showBuatAkun()
    {
        $pendudukId = session(self::SESSION_KEY);
        if (! $pendudukId) {
            return redirect()->route('register')
                ->withErrors(['nik' => 'Sesi verifikasi habis. Silakan ulangi verifikasi.']);
        }

        $penduduk = Penduduk::findOrFail($pendudukId);
        return view('auth.register-akun', compact('penduduk'));
    }

    /** Tahap 2 submit — buat akun dan login otomatis */
    public function simpan(Request $request)
    {
        $pendudukId = session(self::SESSION_KEY);
        if (! $pendudukId) {
            return redirect()->route('register');
        }

        $penduduk = Penduduk::findOrFail($pendudukId);

        // Cek lagi apakah sudah ada akun (race condition guard)
        if (User::where('penduduk_id', $penduduk->id)->exists()) {
            session()->forget(self::SESSION_KEY);
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun untuk NIK ini sudah dibuat. Silakan login.']);
        }

        $data = $request->validate([
            'email'    => 'required|email|max:150|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'email.unique'             => 'Email ini sudah digunakan oleh akun lain.',
            'password.min'             => 'Password minimal 8 karakter.',
            'password.letters'         => 'Password harus mengandung huruf.',
            'password.numbers'         => 'Password harus mengandung angka.',
            'password.confirmed'       => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'penduduk_id' => $penduduk->id,
            'name'        => $penduduk->nama,
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => 'warga',
        ]);

        session()->forget(self::SESSION_KEY);

        Auth::login($user);

        return redirect('/')->with('success', 'Akun berhasil dibuat. Selamat datang, '.$user->name.'!');
    }
}
