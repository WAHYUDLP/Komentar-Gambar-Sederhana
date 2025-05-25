@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="mb-3">
            <a href="{{ route('home') }}" class="btn btn-secondary">← Kembali ke Beranda</a>
        </div>

        <div class="image-post">
            <!-- Gambar -->
            <img src="{{ $image->image_url }}" alt="{{ $image->title }}">
            
            <!-- Info Gambar -->
            <div class="p-4">
                <h3 class="mb-3">{{ $image->title }}</h3>
                @if($image->description)
                    <p class="text-muted mb-4">{{ $image->description }}</p>
                @endif
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="badge bg-primary fs-6">{{ $image->comments->count() }} Komentar</span>
                    <small class="text-muted">Terakhir diupdate: {{ $image->updated_at->diffForHumans() }}</small>
                </div>
            </div>

            <!-- Form Komentar -->
            @auth
                <div class="comment-form p-4">
                    <h6 class="mb-3">Tulis Komentar</h6>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <div class="mb-3">
                            <textarea name="content" class="form-control" rows="3" 
                                      placeholder="Tulis komentar Anda..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>
                </div>
            @else
                <div class="comment-form p-4 text-center">
                    <h6 class="mb-3">Ingin memberikan komentar?</h6>
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar</a>
                </div>
            @endauth

            <!-- Daftar Komentar -->
            <div class="p-4">
                <h6 class="mb-3">Semua Komentar</h6>
                @forelse($image->comments as $comment)
                    <div class="comment-card p-3 mb-3 rounded">
                        <div class="d-flex">
                            <div class="user-avatar me-3">
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
                @empty
                    <p class="text-center text-muted">Belum ada komentar. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection