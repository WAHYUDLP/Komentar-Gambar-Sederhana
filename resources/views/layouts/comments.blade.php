@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gambar yang Anda Komentari:</h2>

    @foreach($images as $image)
        <div class="card mb-4">
            <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="{{ $image->title }}">
            <div class="card-body">
                <h5>{{ $image->title }}</h5>
                <p>{{ $image->description }}</p>

                <h6>Komentar Anda:</h6>
                @foreach ($comments->where('image_id', $image->id) as $comment)
                    <div class="border p-2 mb-2">
                        <small>{{ $comment->created_at->format('d M Y H:i') }}</small>
                        <p>{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
