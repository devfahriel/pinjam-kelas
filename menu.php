<!DOCTYPE html>
<html lang="id">
<head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Ruang Kelas</title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('63780726737-img-20240330-wa0002.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .login-image-bg {
            background-image: linear-gradient(to top, rgba(0, 0, 0, 0.7) 10%, transparent 50%), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        .welcome-text {
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.6);
        }
        .scrollable-container {
            max-height: 450px;
            overflow-y: auto;
            padding-right: 1rem;
        }
        .scrollable-container::-webkit-scrollbar {
            width: 8px;
        }
        .scrollable-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .scrollable-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .scrollable-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* ========== NEW ANIMATION STYLES ========== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes heroText {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animated-login-card {
            animation: fadeInUp 0.8s 0.2s ease-out forwards;
            opacity: 0;
        }
        .animated-hero-text > * {
            opacity: 0;
            animation: heroText 0.8s ease-out forwards;
        }
        .animated-hero-text > h1 { animation-delay: 0.2s; }
        .animated-hero-text > p { animation-delay: 0.4s; }
        .animated-hero-text > a { animation-delay: 0.6s; }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.6s ease-out, transform 0.8s ease-out;
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .room-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Nav Link Hover Effect - Bootstrap Override */
        .navbar-nav .nav-link {
            position: relative;
            transition: color 0.3s;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #0d6efd !important; /* Bootstrap primary color */
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #0d6efd;
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
        .navbar-nav .nav-link.active {
            font-weight: 600;
        }
        
    </style>
</head>
<body class="bg-light text-dark" data-bs-spy="scroll" data-bs-target="#mainNavbar" data-bs-offset="100">


    <div class="container-fluid px-0 ">
        <main>
            <section id="hero" class="hero-bg text-white d-flex align-items-center">
                <div class="container text-center">
                    <div class="animated-hero-text">
                        <h1 class="display-3 fw-bold mb-4">Pesan Ruang Kelas dengan Mudah</h1>
                        <p class="lead mb-5 mx-auto" style="max-width: 600px;">Temukan dan pesan ruang kelas yang sesuai dengan kebutuhan Anda secara online, cepat, dan efisien.</p>
                        <a href="#ruangan" class="btn btn-light btn-lg text-primary fw-bold py-3 px-4 shadow me-2">Lihat Pilihan Ruangan</a>
                        <a href="create_booking.php" class="btn btn-light btn-lg text-primary fw-bold py-3 px-4 shadow">Booking Sekarang</a>
                    </div>
                </div>
            </section>

            <section id="ruangan" class="py-5 bg-white">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold">Pilihan Ruang Kelas</h2>
                        <p class="text-muted mt-2">Pilih ruangan yang paling sesuai untuk kegiatan belajar Anda.</p>
                    </div>
                    <h3 class="h4 fw-semibold mb-4 text-secondary">Ruang Teori</h3>
                    <div class="scrollable-container">
                        <div id="theory-room-list" class="row g-4"></div>
                    </div>
                    <h3 class="h4 fw-semibold mt-5 mb-4 text-secondary">Ruangan Lainnya</h3>
                    <div id="other-room-list-container" class="row g-4"></div>
                </div>
            </section>

            <section id="kontak" class="py-5 bg-light">
                <div class="container" style="min-height: 500px;">
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold">Hubungi Kami</h2>
                        <p class="text-muted mt-2">Punya pertanyaan? Jangan ragu untuk menghubungi kami.</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="card shadow-lg border-0 rounded-3 p-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4 mb-md-0">
                                            <h3 class="h5 fw-semibold mb-4">Informasi Kontak</h3>
                                            <p class="d-flex align-items-start mb-3">
                                                <svg class="w-10 h-10 me-3 text-primary flex-shrink-0" style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Jl. Pendidikan No.17, Sidomulyo Bar., Kec. Tampan, Kota Pekanbaru, Riau 28293
                                            </p>
                                            <p class="d-flex align-items-center mb-3">
                                                <svg class="w-5 h-5 me-3 text-primary" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                (0761) 7047091, 589561
                                            </p>
                                            <p class="d-flex align-items-center">
                                                <svg class="w-5 h-5 me-3 text-primary" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                admin@usti.ac.id
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 class="h5 fw-semibold mb-4">Jam Operasional</h3>
                                            <p><strong>Senin - Jumat:</strong> 08:00 - 21:00</p>
                                            <p><strong>Sabtu, Minggu & Hari Libur:</strong> Tutup</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-dark text-white py-4">
            <div class="container text-center">
                <p>&copy; 2025 USTI Booking Class. Semua Hak Cipta Dilindungi.</p>
            </div>
        </footer>

        <div class="modal fade" id="booking-modal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-3 shadow-lg">
                    <div class="modal-header border-bottom-0">
                        <h3 class="modal-title h5" id="bookingModalLabel">Formulir Booking Ruangan</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="booking-form">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="room-selection" class="form-label">Pilih Ruangan</label>
                                    <select id="room-selection" name="room-selection" class="form-select"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="booking-date" class="form-label">Tanggal Booking</label>
                                    <input type="date" id="booking-date" name="booking-date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="booking-time" class="form-label">Jam</label>
                                    <select id="booking-time" name="booking-time" class="form-select" required>
                                        <option>08:00 - 10:00</option>
                                        <option>10:00 - 12:00</option>
                                        <option>13:00 - 15:00</option>
                                        <option>15:00 - 17:00</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="user-name" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="user-name" name="user-name" placeholder="Masukkan nama lengkap Anda" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label for="purpose" class="form-label">Keperluan</label>
                                    <textarea id="purpose" name="purpose" rows="3" placeholder="Contoh: Kelas tambahan, rapat organisasi, dll." class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                <a href="create_booking.php" class="btn btn-primary">Booking Ruangan Ini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="success-toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Booking berhasil! Konfirmasi telah dikirim.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Data Ruangan ---
            const otherRooms = [{
                id: 'lab-komputer',
                name: 'Laboratorium Komputer',
                capacity: 30,
                image: '321344P_20200108_125347_vHDR_On.jpeg',
                facilities: ['PC Lengkap', 'AC', 'Proyektor', 'Internet Cepat']
            }, {
                id: 'mini_hall',
                name: 'Mini Hall',
                capacity: 50,
                image: 'https://placehold.co/600x400/e74c3c/ffffff?text=Ruang+Diskusi',
                facilities: ['Smart TV', 'AC', 'Meja Bundar']
            }, {
                id: 'aula',
                name: 'Aula YKR',
                capacity: 700,
                image: 'WhatsApp Image 2025-07-07 at 00.46.23_f297dff0.jpg',
                facilities: ['Proyektor', 'Sound System', 'AC Sentral', 'Panggung']
            }, {
                id: 'Mushola',
                name: 'Mushola',
                capacity: 30,
                image: 'Screenshot 2025-07-03 013258.png',
                facilities: ['Lighting', 'AC']
            }, {
                id: 'perpustakaan-pribadi',
                name: 'Perpustakaan Pribadi',
                capacity: 10,
                image: '956944WhatsApp-Image-2020-01-07-at-10.50.22.jpeg',
                facilities: ['Koleksi Buku', 'Wi-Fi', 'Meja Baca']
            }];

            const facilityIcons = {
                'Proyektor': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>`,
                'AC': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>`,
                'Papan Tulis': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>`,
                'Wi-Fi': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 8.929a15 15 0 0121.212 0"></path></svg>`,
                'PC Lengkap': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>`,
                'Internet Cepat': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>`,
                'Smart TV': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>`,
                'Meja Bundar': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path></svg>`,
                'Sound System': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.858 5.858a3 3 0 114.242 4.243L5.858 14.343a3 3 0 01-4.242-4.243l4.242-4.242z"></path></svg>`,
                'AC Sentral': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>`,
                'Panggung': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M4 17v4m-2-2h4m11-1h4m-2-2v4m5-12v4m-2-2h4"></path></svg>`,
                'Green Screen': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z"></path></svg>`,
                'Lighting': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M12 16a4 4 0 110-8 4 4 0 010 8z"></path></svg>`,
                'Koleksi Buku': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>`,
                'Meja Baca': `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path></svg>`,
            };

            const theoryRoomList = document.getElementById('theory-room-list');
            const otherRoomListContainer = document.getElementById('other-room-list-container');
            const roomSelection = document.getElementById('room-selection');
            roomSelection.innerHTML = ''; // Clear existing options

            const createRoomCard = (room) => {
                const facilitiesHTML = room.facilities.map(facility => `
                    <div class="col-6">
                        <div class="d-flex align-items-center text-muted small">
                            <span class="me-2" style="width: 1.25rem; height: 1.25rem;">${facilityIcons[facility] || ''}</span>
                            <span>${facility}</span>
                        </div>
                    </div>
                `).join('');

                return `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 room-card">
                        <img src="${room.image}" class="card-img-top" alt="${room.name}" style="height: 200px; object-fit: cover;" onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/ffffff?text=Image+Not+Found';">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">${room.name}</h5>
                            <p class="card-text text-muted mb-3 d-flex align-items-center">
                                <svg class="me-2" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Kapasitas: ${room.capacity} orang
                            </p>
                            <div class="row g-2 mb-4">
                                ${facilitiesHTML}
                            </div>
                            <button data-roomid="${room.id}" class="book-button btn btn-primary mt-auto w-100">
                                Booking Ruangan Ini
                            </button>
                        </div>
                    </div>
                </div>
                `;
            };

            // Populate rooms
            let allRooms = [];
            for (let i = 1; i <= 16; i++) {
                const room = {
                    id: `ruang-teori-${i}`,
                    name: `Ruang Teori ${i}`,
                    capacity: 40,
                    image: `Screenshot 2025-07-03 013157.png`,
                    facilities: ['Proyektor', 'AC', 'Papan Tulis']
                };
                theoryRoomList.innerHTML += createRoomCard(room);
                allRooms.push(room);
            }
            otherRooms.forEach(room => {
                otherRoomListContainer.innerHTML += createRoomCard(room);
                allRooms.push(room);
            });

            // Populate room selection dropdown
            allRooms.sort((a, b) => a.name.localeCompare(b.name)).forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.textContent = room.name;
                roomSelection.appendChild(option);
            });


            // --- Modal Logic ---
            const bookingModalEl = document.getElementById('booking-modal');
            const bookingModal = new bootstrap.Modal(bookingModalEl);

            const openModal = (roomId) => {
                if (roomId) {
                    roomSelection.value = roomId;
                }
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('booking-date').setAttribute('min', today);
                document.getElementById('booking-date').value = today;
                bookingModal.show();
            };

            document.querySelectorAll('.book-button').forEach(button => {
                button.addEventListener('click', () => {
                    openModal(button.dataset.roomid);
                });
            });

            // --- Form Submission ---
            const mainBookingForm = document.getElementById('booking-form');
            const successToastEl = document.getElementById('success-toast');
            const successToast = new bootstrap.Toast(successToastEl);

            mainBookingForm.addEventListener('submit', (e) => {
                e.preventDefault();
                bookingModal.hide();
                mainBookingForm.reset();
                successToast.show();
            });
            
             // --- Scroll-Spy active link update ---
            // This is handled automatically by Bootstrap's ScrollSpy via data attributes on the body tag.
            // We just ensure the navigation links have the correct href attributes.

            // --- Smooth Scrolling for anchor links ---
            // Bootstrap handles this automatically for links pointing to IDs.
            // The scrollspy functionality also requires this behavior.
        });
    </script>
</body>
</html>