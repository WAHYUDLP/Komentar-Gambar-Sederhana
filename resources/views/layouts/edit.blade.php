@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profil</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tambahkan field lain jika perlu -->

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
