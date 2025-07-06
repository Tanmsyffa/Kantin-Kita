<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Pelanggan</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY_HERE"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="username" content="{{ auth()->user()->username ?? '' }}">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <h2 class="mb-0">Menu Tersedia</h2>
            <div class="d-flex align-items-center">
                <div class="cart-icon position-relative" id="cartIcon" style="cursor: pointer;">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">0</span>
                </div>
            </div>
        </div>

        @if ($menus->isEmpty())
            <div class="text-center text-muted">
                <i class="fas fa-utensils fa-3x mb-3"></i>
                <h4>Belum ada menu yang tersedia</h4>
                <p>Silakan kembali lagi nanti</p>
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

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $menu->nama }}</h5>
                                <p class="card-text flex-grow-1">{{ $menu->deskripsi }}</p>
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="price-tag">
                                        <i class="fas fa-tag me-1"></i>Rp{{ number_format($menu->harga, 0, ',', '.') }}
                                    </div>
                                    <div class="stock-info">
                                        <i class="fas fa-box me-1"></i>Stok: {{ $menu->stok ?? '-' }}
                                    </div>
                                </div>
                                <button class="btn btn-success w-100 mt-auto add-to-cart"
                                    data-id="{{ $menu->id }}"
                                    data-name="{{ $menu->nama }}"
                                    data-price="{{ $menu->harga }}"
                                    data-image="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : asset('img/default.png') }}">
                                    <i class="fas fa-cart-plus me-1"></i>Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Keranjang -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Anda
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div id="cartItems" class="mb-3">
                <p class="text-muted">Keranjang kosong</p>
            </div>
            <div class="mt-auto">
                <div class="d-flex justify-content-between border-top pt-3">
                    <strong>Total:</strong>
                    <span id="cartTotal">Rp0</span>
                </div>

                <form id="checkoutForm" action="{{ route('order.store') }}" method="POST" class="mt-3">
                    @csrf
                    <div id="cartHiddenInputs"></div>

                    <div class="mb-2">
                        <label for="nama" class="form-label">Nama Lengkap Pemesan</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                            value="{{ auth()->user()->nama ?? auth()->user()->username ?? '' }}" readonly>
                    </div>

                    <div class="mb-2">
                        <label for="no_meja" class="form-label">Nomor Meja</label>
                        <input type="text" class="form-control" id="no_meja" name="no_meja" required>
                    </div>

                    <button type="button" class="btn btn-primary w-100" onclick="processPayment()">
                        <i class="fas fa-check-circle me-1"></i>Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/cart.js"></script>
</body>
</html>