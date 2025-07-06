<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <h2 class="mb-0">Daftar Menu</h2>
            <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Menu
            </a>
        </div>

        @if ($menus->isEmpty())
            <div class="no-menu-container">
                <i class="fas fa-utensils fa-3x mb-3 text-secondary"></i>
                <h4 class="text-muted">Belum ada menu yang tersedia</h4>
                <p class="text-muted">Mulai dengan menambahkan menu baru</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($menus as $menu)
                    <div class="col">
                        <div class="card h-100 menu-card">
                            @if ($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" class="card-img-top card-img-custom" alt="{{ $menu->nama }}">
                            @else
                                <div class="text-center py-5 bg-light">
                                    <i class="fas fa-image fa-4x text-secondary"></i>
                                    <p class="mt-2 text-muted">Tanpa Gambar</p>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $menu->nama }}</h5>
                                </div>
                                <p class="card-text flex-grow-1">{{ $menu->deskripsi }}</p>
                                
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="price-tag">
                                        <i class="fas fa-tag me-1"></i>Rp{{ number_format($menu->harga, 0, ',', '.') }}
                                    </div>
                                    <div class="stock-info">
                                        <i class="fas fa-box me-1"></i>Stok: {{ $menu->stok }}
                                    </div>
                                </div>
                                
                                <div class="action-container">
                                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-outline-primary flex-grow-1">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash-alt me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>