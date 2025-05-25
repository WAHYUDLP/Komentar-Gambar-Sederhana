<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Komentar Gambar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .image-container {
            max-width: 100%;
        }

        .comment-card {
            border-left: 4px solid #007bff;
            background-color: #f8f9fa;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .image-post {
            margin-bottom: 3rem;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
        }

        .image-post img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .comment-form {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">📸 Galeri Komentar</a>

            <div class="navbar-nav ms-auto">
                @auth
                <a href="{{ route('images.upload') }}" class="btn btn-outline-light me-2">Unggah Gambar</a>
                <a href="{{ route('images.all') }}" class="btn btn-outline-light me-3">Pilih Gambar</a>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu">
                        <li>

                            <form action="{{ route('profile.edit') }}" method="GET" class="d-inline">
                                <button type="submit" class="dropdown-item">Edit Profil</button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('delete-account') }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">Hapus Akun</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-light">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>