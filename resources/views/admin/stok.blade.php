<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Menu Menipis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-dashboard">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <h2 class="mb-0">Menu dengan Stok Menipis</h2>
        </div>

        @if($menus->isEmpty())
            <div class="alert alert-success">Semua stok dalam kondisi aman.</div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($menus as $menu)
                    <div class="col">
                        <div class="card h-100 menu-card">
                            @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" class="card-img-top card-img-custom" alt="{{ $menu->nama }}">
                            @else
                                <div class="text-center py-5 bg-light">
                                    <i class="fas fa-image fa-4x text-secondary"></i>
                                    <p class="mt-2 text-muted">Tanpa Gambar</p>
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $menu->nama }}</h5>
                                <p class="card-text">{{ $menu->deskripsi }}</p>
                                <div class="mb-2">
                                    <i class="fas fa-tag me-1"></i> Rp{{ number_format($menu->harga, 0, ',', '.') }}
                                </div>
                                <div class="text-warning fw-bold">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Stok Menipis: {{ $menu->stok }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
