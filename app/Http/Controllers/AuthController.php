<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('app');
    }

    public function signin(Request $request)
    {
        // Validasi
        $akun = $request->validate([
            'email' => 'required|email',
            'password' => 'min:5|required',
        ]);

        // login
        if (Auth::attempt($akun)) {
            return redirect()->intended('/dashboard');
        } else {
            return back()->with('error', 'Email atau Password Salah');
        }
    }

    public function logout(Request $request)
    {

        // Logout
        Auth::logout();

        // Hapus Session Lama
        $request->session()->invalidate();

        // Reset CSRF Token
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Log Out Berhasil');
    }
}
