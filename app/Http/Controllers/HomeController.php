<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua gambar yang punya komentar, beserta komentar-komentarnya
        $images = Image::whereHas('comments')
            ->with(['commentsWithUser'])
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('Layouts/home', compact('images'));
    }

    public function showImage($id)
    {
        $image = Image::with(['commentsWithUser'])->findOrFail($id);
        return view('Layouts/image-detail', compact('image'));
    }
}