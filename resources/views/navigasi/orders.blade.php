<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Riwayat Pesanan Anda</h2>
            <a href="/" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>

        @if ($orders->isEmpty())
            <div class="alert alert-info">Anda belum memiliki pesanan.</div>
        @else
            @foreach ($orders as $order)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Pesanan #{{ $order->id }} - {{ $order->created_at->translatedFormat('l, d F Y - H:i') }}</span>
                        <span class="fw-bold text-primary">Total: Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item->nama_menu }}</strong><br>
                                    <small>{{ $item->qty }} x Rp{{ number_format($item->subtotal / $item->qty, 0, ',', '.') }}</small>
                                </div>
                                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
