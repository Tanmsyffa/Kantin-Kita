<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container py-4">
        <div class="form-header text-center mb-5">
            <h1 class="text-primary"><i class="fas fa-plus-circle me-2"></i>Tambah Menu Baru</h1>
            <p class="lead">Tambahkan menu baru ke dalam daftar restoran Anda</p>
        </div>
        
        <div class="form-container">
            <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Menu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama menu" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga menu" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stok" class="form-label">Stok Tersedia</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                                <input type="number" class="form-control" id="stok" name="stok" placeholder="Jumlah stok" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi Menu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi menu (bahan, rasa, dll)"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="gambar" class="form-label">Gambar Menu</label>
                    <div class="file-upload">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                        <div class="file-preview text-center">
                            <div class="no-image p-4">
                                <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                                <p class="text-muted">Belum ada gambar yang dipilih</p>
                                <small class="text-muted">Format: JPG, PNG, JPEG | Maks: 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions mt-4">
                    <button type="submit" class="btn btn-success btn-lg w-100 py-2">
                        <i class="fas fa-save me-2"></i>Simpan Menu Baru
                    </button>
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary mt-0 w-100">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Menu
                    </a>
                </div>
            </form>
        </div>
        
        <div class="form-footer mt-5 text-center">
            <p class="text-muted">&copy; {{ date('Y') }} Sistem Manajemen Menu Restoran</p>
        </div>
    </div>

    <script>
        // Preview gambar saat dipilih
        document.getElementById('gambar').addEventListener('change', function(e) {
            const previewContainer = document.querySelector('.file-preview');
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                        <div class="d-flex justify-content-center">
                            <img src="${e.target.result}" alt="Preview Gambar" class="img-thumbnail" style="max-height: 300px;">
                        </div>
                        <p class="mt-2 text-center">${document.getElementById('gambar').files[0].name}</p>
                    `;
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                previewContainer.innerHTML = `
                    <div class="no-image p-4">
                        <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                        <p class="text-muted">Belum ada gambar yang dipilih</p>
                        <small class="text-muted">Format: JPG, PNG, JPEG | Maks: 2MB</small>
                    </div>
                `;
            }
        });
    </script>
</body>
</html>