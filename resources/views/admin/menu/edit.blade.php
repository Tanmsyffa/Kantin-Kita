<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h1><i class="fas fa-edit"></i> Edit Menu</h1>
            <p>Perbarui informasi menu restoran Anda</p>
        </div>
        
        <div class="form-container">
            <form method="POST" action="{{ route('admin.menu.update', $menu->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nama">Nama Menu</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $menu->nama }}" required>
                    <i class="fas fa-utensils form-icon"></i>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ $menu->harga }}" required>
                            <i class="fas fa-tag form-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stok">Stok Tersedia</label>
                            <input type="number" class="form-control" id="stok" name="stok" value="{{ $menu->stok }}" required>
                            <i class="fas fa-box form-icon"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Menu</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ $menu->deskripsi }}</textarea>
                    <i class="fas fa-align-left form-icon"></i>
                </div>
                
                <div class="form-group">
                    <label for="gambar">Gambar Menu</label>
                    <div class="file-upload">
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <div class="file-preview mt-3">
                            @if ($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="Preview" id="imagePreview" class="img-thumbnail">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <p>Belum ada gambar</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-update">
                        <i class="fas fa-save me-2"></i>Perbarui Menu
                    </button>
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
        
        <div class="form-footer">
            <p>&copy; {{ date('Y') }} Sistem Manajemen Menu Restoran</p>
        </div>
    </div>

    <script>
        // JavaScript untuk preview gambar
        document.getElementById('gambar').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            if (preview) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                    
                    // Tampilkan preview jika sebelumnya tidak ada gambar
                    preview.style.display = 'block';
                }
            }
        });
    </script>
</body>
</html>