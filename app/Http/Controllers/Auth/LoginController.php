<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login — validasi dari tabel pengguna Supabase.
     * Hanya role admin_jurusan dan kajur yang bisa masuk.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Autentikasi via Supabase Auth REST API
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => env('SUPABASE_ANON_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('SUPABASE_URL') . '/auth/v1/token?grant_type=password', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (! $response->successful()) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput(['email' => $request->email]);
        }

        // Cari user di tabel pengguna
        $pengguna = Pengguna::where('email', $request->email)->first();

        if (! $pengguna) {
            return back()->withErrors([
                'email' => 'Akun tidak ditemukan di database.',
            ])->withInput(['email' => $request->email]);
        }

        // Cek role — hanya admin dan kajur
        if (! $pengguna->isAdminOrKajur()) {
            return back()->withErrors([
                'email' => 'Anda tidak memiliki akses ke panel admin.',
            ])->withInput(['email' => $request->email]);
        }

        // Login berhasil
        Auth::guard('web')->login($pengguna, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
