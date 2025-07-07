<?php
session_start(); // HARUS menjadi baris pertama

// Cek apakah pengguna sudah login, jika belum, alihkan ke halaman login
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking class</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* --- Styling Navbar (TIDAK BERUBAH) --- */
        .navbar { transition: all 0.3s ease-in-out; }
        .navbar-nav .nav-link { position: relative; padding: 0.8rem 1rem; margin: 0 0.5rem; color: #333; font-weight: 500; transition: color 0.3s; }
        .navbar-nav .nav-link:hover { color: #007bff; }
        .navbar-nav .nav-link::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background-color: #007bff; transform: scaleX(0); transform-origin: bottom right; transition: transform 0.3s ease-out; }
        .navbar-nav .nav-link:hover::after { transform: scaleX(1); transform-origin: bottom left; }
        .navbar-nav .nav-link.active { color: #007bff; font-weight: 700; }
        .navbar-nav .nav-link.active::after { transform: scaleX(1); transform-origin: bottom left; }

        /* --- Kartu Hero (TIDAK BERUBAH) --- */
        .hero-card { background: linear-gradient(45deg, #0d6efd,rgb(204, 140, 3)); color: #fff; border-radius: 1rem; transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .hero-card:hover { transform: translateY(-10px); box-shadow: 0 10px 30px rgba(111, 66, 193, 0.4); }
        .hero-card .btn { transition: transform 0.2s ease; }
        .hero-card .btn:hover { transform: scale(1.05); }

        /* --- PENAMBAHAN: KARTU STATISTIK --- */
        .stat-card {
            background-color: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
       .stat-card .stat-icon {
    font-size: 2rem; /* Ukuran ikon sedikit disesuaikan */
    color: #fff;
    border-radius: 50%;
    
    /* Menjadikan lingkaran memiliki ukuran pasti */
    width: 64px;
    height: 64px;

    /* Memaksa ikon di dalamnya untuk selalu di tengah */
    display: flex;
    align-items: center;
    justify-content: center;
}
        /* --- PENAMBAHAN: PANEL AKSI CEPAT --- */
        .action-panel {
            background-color: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e9ecef;
            padding: 1.5rem;
        }

        /* --- Animasi --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-item { opacity: 0; }
        .fade-in-delay-1 { animation: fadeInUp 0.5s 0.2s ease-out forwards; }
        .fade-in-delay-2 { animation: fadeInUp 0.5s 0.4s ease-out forwards; }
        .fade-in-delay-3 { animation: fadeInUp 0.5s 0.6s ease-out forwards; }
        .fade-in-row { opacity:0; animation: fadeInUp 0.5s 0.8s ease-out forwards; }
        .fade-in-row-2 { opacity:0; animation: fadeInUp 0.5s 1s ease-out forwards; }


        .main-content { margin-top: 2rem; }
    </style>
  </head>
  <body>

  <?php
    error_reporting(0);
    include_once "config.php";
    $page = $_GET['po'] ?? null;
  ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
    <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
    <img src="67b5454cd9714.png" alt="Logo" style="height: 60px; margin-right: 0px;">
    Booking Kelas
</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item"> <a class="nav-link <?= ($page == null) ? 'active' : '' ?>" href="index.php">Home</a> </li>
            <li class="nav-item"> <a class="nav-link <?= ($page == 'barang') ? 'active' : '' ?>" href="?po=barang">Data Ruangan</a> </li>
            <li class="nav-item"> <a class="nav-link <?= ($page == 'mahasiswa') ? 'active' : '' ?>" href="?po=mahasiswa">Data Mahasiswa</a> </li>
            <li class="nav-item"> <a class="nav-link <?= ($page == 'booking') ? 'active' : '' ?>" href="?po=booking">Status Booking</a> </li>
            <li class="nav-item"> <a class="nav-link <?= ($page == 'menu') ? 'active' : '' ?>" href="?po=menu">Booking</a> </li>
        </ul>
        <div class="d-flex align-items-center">
             <span class="navbar-text text-muted me-3"> <i class="far fa-calendar-alt"></i> <?php echo date("d M Y"); ?> </span>
             <a href="logout.php" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="container-fluid px-0 ">
      <?php
        if ($page == null) {
          
          // --- KONTEN HALAMAN HOME YANG DIPERBARUI ---
          echo '
            <div class="p-5 mb-4 hero-card rounded-7000 fade-in-delay-1">
              <div class="container-fluid py-4">
                <h1 class="display-5 fw-bold fade-in-item fade-in-delay-2">Selamat Datang di Pinjam Kelas! 👋</h1>
                <p class="col-md-9 fs-5 fade-in-item fade-in-delay-3">Halaman ini adalah pusat kendali Anda untuk mengelola semua data.</p>
              </div>
            </div>

            <div class="row fade-in-row">
              <div class="col-md-4 mb-4">
                <div class="stat-card p-3">
                  <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary me-3"> <i class="fas fa-door-closed"></i> </div>
                    <div>
                      <h5 class="mb-0 text-dark">Total Ruangan</h5>
                      <h3 class="fw-bold text-dark">6</h3>
                      <small class="text-muted">Ruangan keseluruhan</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="stat-card p-3">
                  <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success me-3"> <i class="fas fa-calendar-check"></i> </div>
                    <div>
                      <h5 class="mb-0 text-dark">Total booking</h5>
                      <h3 class="fw-bold text-dark">1</h3>
                      <small class="text-muted">Status Booking aktif</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="stat-card p-3">
                  <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning me-3"> <i class="fas fa-user-graduate "></i> </div>
                    <div>
                      <h5 class="mb-0 text-dark">Data Mahasiswa</h5>
                      <h3 class="fw-bold text-dark">3</h3>
                       <small class="text-muted">Mahasiswa terdaftar</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row fade-in-row-2">
                <div class="col-12">
                    <div class="action-panel">
                        <h4 class="text-dark">Aksi Cepat</h4>
                        <p class="text-muted">Langsung menuju halaman yang paling sering Anda gunakan.</p>
                        <a href="?po=barang" class="btn btn-outline-primary me-2"><i class="fas fa-list-alt me-1"></i> Lihat Data Ruangan</a>
                        <a href="?po=mahasiswa" class="btn btn-outline-info"><i class="fas fa-user-graduate me-1"></i> Laporan Mahasiswa</a>
                        <a href="?po=menu" class="btn btn-outline-success me-2"><i class="fas fa-calendar-check me-1"></i> Status Booking</a>
                    </div>
                    <section id="kontak" class="py-5 bg-light">
                <div class="container" style="min-height: 2px;">
                    <div class="text-center mb-5">
                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-dark text-white py-1">
            <div class="container text-center">
                <p>&copy; 2025 USTI Booking Class. Semua Hak Cipta Dilindungi.</p>
            </div>
        </footer>
                </div>
            </div>
            ';
          } elseif ($page == "barang") {
            include "barang.php";
          } elseif ($page == "menu") {
            include "menu.php";
          } elseif ($page == "mahasiswa") {
          include "mahasiswa.php";
          } elseif ($page == "booking") {
          include "status_booking.php";
        }
      ?>
  </div>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>