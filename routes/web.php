<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman utama - menampilkan semua gambar dengan komentar
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail gambar individual
Route::get('/image/{id}', [HomeController::class, 'showImage'])->name('image.show');

// Halaman untuk pilih gambar yang mau dikomentar
Route::get('/images', [ImageController::class, 'getAllImages'])->name('images.all');

// Route untuk upload gambar
Route::get('/upload', [ImageController::class, 'showUploadForm'])->name('images.upload');
Route::post('/upload', [ImageController::class, 'store'])->name('images.store');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::delete('/delete-account', [AuthController::class, 'deleteAccount'])->name('delete-account');

// Comment routes
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Route untuk menghapus gambar
Route::post('/images', [ImageController::class, 'store'])->middleware('auth')->name('image.store');
Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('image.destroy');

// Tampilkan form edit profil
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');

// Proses update profil
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
