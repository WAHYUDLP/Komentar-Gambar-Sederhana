<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();  // Ambil user yang sedang login
        return view('layouts/edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Unique tapi kecuali user sendiri
            // tambah validasi lain kalau perlu
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Kalau ada field lain yang ingin diedit, tambahkan di sini

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
