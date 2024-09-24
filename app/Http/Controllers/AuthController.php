<?php

namespace App\Http\Controllers;

use App\Models\UserVedika; // Pastikan model diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')
                        ->withSuccess('You have Successfully logged in');
        }

        return redirect("login")->withError('Oppes! You have entered invalid credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'confirmed', // Harus ada konfirmasi password
                'regex:/[a-z]/', // Harus ada huruf kecil
                'regex:/[A-Z]/', // Harus ada huruf besar
                'regex:/[0-9]/', // Harus ada angka
                'regex:/[@$!%*?&]/', // Harus ada simbol
            ],
            'level' => 'required|in:VERIFIKATOR_BPJSKES,VERIFIKATOR_RS,ADMIN', // Validasi enum
        ]);
       
        $user = UserVedika::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level' => $request->level, // atau level lain yang diinginkan
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->withSuccess('You have Successfully registered');
    }
}
