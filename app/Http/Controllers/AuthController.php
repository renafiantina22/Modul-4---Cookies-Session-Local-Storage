<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (Auth::attempt([
            $field => $credentials['login'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            return redirect()->intended(route('products.index'))
                ->with('success', 'Login berhasil.');
        }

        return back()
            ->withErrors(['login' => 'Username/email atau password salah.'])
            ->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'id_user' => 'USR' . strtoupper(Str::random(12)),
            'nama_lengkap' => $data['nama_lengkap'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'no_hp' => $data['no_hp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('products.index')
            ->with('success', 'Registrasi berhasil. Selamat berbelanja!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('products.index')
            ->with('success', 'Kamu berhasil logout.');
    }
}
