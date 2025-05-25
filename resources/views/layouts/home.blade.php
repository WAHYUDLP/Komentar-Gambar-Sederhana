@extends('layouts.app')

@section('content')

<div class="container my-4">
    {{-- Header bagian atas --}}
    <div class="d-flex justify-content-end mb-4">
        @guest
            <!-- <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar</a> -->
        @else
            <div>
                <!-- <span class="me-3">Halo, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form> -->
            </div>
        @endguest
    </div>

    {{-- Konten gambar dan komentar --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if($images->isEmpty())
                <div class="text-center py-5">
                    <h3 class="text-muted">Belum ada gambar dengan komentar</h3>
                    <p class="text-muted">Jadilah yang pertama memberikan komentar!</p>
                    @auth
                        <a href="{{ route('images.upload') }}" class="btn btn-primary">Unggah Gambar Baru</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Masuk untuk Unggah gambar</a>
                    @endauth
                </div>
            @endif

            @foreach($images as $image)
                <div class="image-post mb-4">
                    {{-- Gambar --}}
                    <img src="{{ $image->image_url }}" alt="{{ $image->title }}" class="img-fluid rounded">

                    {{-- Info Gambar --}}
                    <div class="p-3">
                        <h5 class="mb-2">{{ $image->title }}</h5>
                        @if($image->description)
                            <p class="text-muted mb-3">{{ $image->description }}</p>
                        @endif

                        {{-- Statistik --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary">{{ $image->comments->count() }} Komentar</span>
                            <small class="text-muted">Terakhir diupdate: {{ $image->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    {{-- Daftar Komentar --}}
                    <div class="px-3 pb-3">
                        @foreach($image->comments as $comment)
                            <div class="comment-card p-3 mb-2 rounded border">
                                <div class="d-flex">
                                    <div class="user-avatar me-3 rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $comment->user->name }}</strong>
                                                <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            @auth
                                                @if($comment->user_id === Auth::id())
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                        <p class="mt-2 mb-0">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Form Komentar --}}
                    @auth
                        <div class="comment-form p-3 border rounded">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <div class="row g-2">
                                    <div class="col-md-10">
                                        <textarea name="content" class="form-control" rows="2" 
                                                  placeholder="Tulis komentar untuk gambar ini..." required>{{ old('content') }}</textarea>
                                    </div>
                                    <div class="col-md-2 d-grid">
                                        <button type="submit" class="btn btn-primary h-100">Kirim</button>
                                    </div>
                                </div>
                                @error('content')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </form>
                        </div>
                    @else
                        <div class="comment-form p-3 text-center border rounded">
                            <p class="mb-2">Ingin memberikan komentar?</p>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm me-2">Masuk</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Daftar</a>
                        </div>
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
