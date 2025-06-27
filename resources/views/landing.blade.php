<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Kita - Makanan Lezat & Terjangkau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="landing-navbar navbar navbar-expand-lg bg-white fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3 text-primary" href="#home">Kantin Kita</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-lg-4 align-items-center">
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark" href="#contact">Kontak</a>
                    </li>

                    @auth
                        <!-- User dropdown jika login -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle text-primary me-2"></i>
                                <span class="text-dark">{{ Auth::user()->username }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="text-dark dropdown-item" href="{{ route('orders') }}">Riwayat Pesanan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Tombol login jika belum login -->
                        <li class="nav-item ms-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <section id="home" class="landing-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="display-4 fw-bold mb-4" style="color: #FFFF;">Selamat Datang di Kantin Kita</h1>
                <p class="lead mb-5">Nikmati makanan lezat dan terjangkau setiap hari dengan bahan-bahan berkualitas tinggi</p>
                <a href="{{ Auth::check() ? route('menu.index') : route('login') }}" class="hero-btn">
                    Pesan Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    <section id="about" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3 section-title">Tentang Kantin Kita</h2>
                    <p class="text-muted mb-5">Lebih dari sekadar tempat makan, kami adalah bagian dari komunitas Anda</p>
                </div>
            </div>
            
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3 class="text-center mb-3">Makanan Berkualitas</h3>
                        <p class="text-center text-muted">Kami menggunakan bahan-bahan segar dan berkualitas tinggi untuk setiap hidangan yang kami sajikan. Menu kami dirancang oleh chef berpengalaman.</p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3 class="text-center mb-3">Bahan Organik</h3>
                        <p class="text-center text-muted">Sayuran dan bahan-bahan kami dipilih dari petani lokal yang menggunakan metode pertanian organik untuk memastikan kualitas terbaik.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="text-center mb-3">Buka Setiap Hari</h3>
                        <p class="text-center text-muted">Kami buka setiap hari dari pukul 08.00 hingga 20.00, siap melayani kebutuhan makanan Anda kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class=" bg-light py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3 section-title">Hubungi Kami</h2>
                    <p class="text-muted mb-5">Kami siap membantu dan menjawab pertanyaan Anda</p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="contact-card d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Telepon</h5>
                                    <p class="mb-0">(+62)877-8504-2065</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="contact-card d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Email</h5>
                                    <p class="mb-0">kantin-kita@gmail.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="contact-card d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Jam Operasional</h5>
                                    <p class="mb-0">08.00 - 20.00 (Setiap Hari)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="text-center bg-white text-black py-5 ">
        <div class="container">
            <div class="row align-items-center">
                    <h3 class="fw-bold text-black mb-3">Kantin Kita</h3>
                    <p class="mb-0">Menyajikan makanan lezat dan sehat untuk komunitas sejak dibuat.</p>
                    <p class="mt-1">&copy; 2025 Kantin Kita.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Scroll navbar effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.landing-navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth anchor scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>