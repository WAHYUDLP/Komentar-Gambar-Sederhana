<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'showUploadForm']);
    }

    public function getAllImages()
    {
        // Ambil semua gambar untuk pilihan komentar
        $images = Image::orderBy('title')->get();
        return view('Layouts/all', compact('images'));
    }

    public function showUploadForm()
    {
        return view('Layouts/upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        // Upload gambar ke storage
        $imagePath = $request->file('image')->store('images', 'public');

        // Buat URL lengkap
        $imageUrl = Storage::url($imagePath);

        // Simpan ke database, PENTING: isi user_id dengan ID user yang sedang login
        $image = Image::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $imageUrl,
            'path' => $imagePath,
            'user_id' => auth()->id(),  // <-- wajib ini
            //'user_id' => 1,  // asumsi user dengan id 1 memang ada di database

        ]);

        return redirect()->route('home')->with('success', 'Gambar berhasil diunggah! Sekarang orang lain bisa memberikan komentar.');
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // Hapus file gambar dari storage
        Storage::disk('public')->delete($image->path);

        // Hapus gambar dari database
        $image->delete();

        return redirect()->route('home')->with('success', 'Gambar berhasil dihapus!');
    }
}
