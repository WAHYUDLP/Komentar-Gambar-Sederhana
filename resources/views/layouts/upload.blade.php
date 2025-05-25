@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Unggah Gambar Baru</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Preview area -->
                    <div class="mb-4">
                        <label class="form-label">Preview Gambar:</label>
                        <div id="image-preview" class="border rounded p-3 text-center" style="min-height: 200px; background-color: #f8f9fa;">
                            <span class="text-muted">Pilih gambar untuk melihat preview</span>
                        </div>
                    </div>

                    <!-- Input file -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Pilih Gambar</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*" required>
                        <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 5MB.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Gambar</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required 
                               placeholder="Masukkan judul untuk gambar Anda">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi (Opsional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Ceritakan tentang gambar ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('images.all') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Unggah Gambar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 300px; border-radius: 5px;" alt="Preview">`;
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<span class="text-muted">Pilih gambar untuk melihat preview</span>';
    }
});
</script>
@endsection