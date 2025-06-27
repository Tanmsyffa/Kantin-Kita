<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kantin Kita</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-dashboard">
<div class="container">

    <!-- Header -->
    <div class="header-top">
        <div class="admin-info">
            <div class="admin-avatar">
                <i class="fas fa-user-shield"></i>
            </div>
            <span>Admin Dashboard</span>
        </div>
        <div class="logout-section">
            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Navigasi -->
        <div class="dashboard-nav mb-3 d-flex justify-content-start">
            <a href="{{ route('admin.menu.index') }}" class="btn dashboard-btn">
                <i class="fas fa-utensils me-2"></i>
                Kelola Menu
            </a>
        </div>

        <!-- Statistik Penghasilan -->
        <div class="stats-section">
            <div class="total-income">
                <strong>Total Penghasilan Hari Ini</strong>
                <div class="income-amount">Rp{{ number_format($totalIncome ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Menu Stok Tipis -->
        <div class="orders-section mt-4">
            <div class="orders-header">
                <h2>Menu dengan Stok Menipis</h2>
            </div>
            @if(isset($lowStockMenus) && count($lowStockMenus) > 0)
                <ul class="orders-list">
                    @foreach($lowStockMenus as $menu)
                        <li class="order-item d-flex justify-content-between align-items-center">
                            <div class="order-info">
                                <div class="customer-name">{{ $menu->nama }}</div>
                                <div class="table-number">Stok: {{ $menu->stok }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-danger fw-bold">Segera Restok</span>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#restockModal{{ $menu->id }}">
                                    Restok
                                </button>
                            </div>
                        </li>

                        <!-- Modal Restok -->
                        <div class="modal fade" id="restockModal{{ $menu->id }}" tabindex="-1" aria-labelledby="restockModalLabel{{ $menu->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.menu.restock', $menu->id) }}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="restockModalLabel{{ $menu->id }}">Restok Menu: {{ $menu->nama }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah Restok</label>
                                                <input type="number" name="jumlah" class="form-control" min="1" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Restok Sekarang</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </ul>
            @else
                <div class="empty-orders">
                    <h3>Semua stok dalam kondisi aman</h3>
                </div>
            @endif
        </div>

        <!-- Riwayat Pemesanan -->
        <div class="orders-section mt-5">
            <div class="orders-header">
                <h2>Riwayat Pemesanan</h2>
            </div>
            @if(isset($orders) && count($orders) > 0)
                <ul class="orders-list">
                    @foreach($orders as $order)
                        <li class="order-item">
                            <div class="order-info">
                                <div class="customer-name">{{ $order->nama_pemesan }}</div>
                                <div class="table-number">Meja {{ $order->no_meja }}</div>
                            </div>
                            <div class="order-total">
                                Rp{{ number_format($order->total, 0, ',', '.') }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-orders">
                    <h3>Belum ada pesanan hari ini</h3>
                    <p>Pesanan akan muncul di sini ketika ada pelanggan yang memesan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
