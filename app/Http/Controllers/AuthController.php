<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Layouts/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/')->with('success', 'Masuk berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau Kata Sandi salah.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('Layouts/register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Keluar berhasil!');
    }

    public function deleteAccount()
    {
        $user = Auth::user();
        Auth::logout();
        if ($user instanceof \App\Models\User) {
            $user->delete();
        }
        
        return redirect('/')->with('success', 'Akun berhasil dihapus!');
    }
}