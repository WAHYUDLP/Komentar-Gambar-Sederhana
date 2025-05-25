@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Pilih Gambar untuk Dikomentar</h2>
            <div>
                <a href="{{ route('images.upload') }}" class="btn btn-success me-2">Unggah Gambar Baru</a>
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
            </div>
        </div>

        <div class="row">
            @foreach($images as $image)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $image->image_url }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $image->title }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $image->title }}</h5>
                            @if($image->description)
                                <p class="card-text text-muted small">{{ Str::limit($image->description, 100) }}</p>
                            @endif
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-info">{{ $image->comments->count() }} Komentar</span>
                                </div>
                                <a href="{{ route('image.show', $image->id) }}" class="btn btn-primary btn-sm w-100">Lihat & Komentar</a>

                                @if(Auth::id() === $image->user_id)
                                    <form action="{{ route('image.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mt-2 w-100">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
