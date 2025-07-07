<?php
// Sertakan file koneksi database di awal
include 'config.php';

// Inisialisasi variabel untuk pesan
$message = '';

// Cek apakah form telah disubmit (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data dari form sesuai dengan tabel status_booking
    $nama_ruang = $_POST['nama_ruang'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $nama_user = $_POST['nama_user'];
    $keperluan = $_POST['keperluan'];

    // 2. Query SQL untuk insert data ke tabel status_booking
    $sql = "INSERT INTO status_booking (nama_ruang, tanggal, jam, nama_user, keperluan) VALUES (?, ?, ?, ?, ?)";
    
    // Siapkan statement
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // 3. Bind 5 parameter string (s) ke statement
        mysqli_stmt_bind_param($stmt, "sssss", $nama_ruang, $tanggal, $jam, $nama_user, $keperluan);

        // 4. Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, siapkan pesan sukses dan redirect ke halaman laporan
            // (Asumsi halaman laporan bernama 'laporan_peminjaman.php')
            header("refresh:2;url=index.php?po=booking");
            $message = '<div class="alert alert-success">Sukses! Data peminjaman berhasil disimpan. Anda akan dialihkan...</div>';
        } else {
            $message = '<div class="alert alert-danger">Error: Gagal menyimpan data. ' . mysqli_stmt_error($stmt) . '</div>';
        }
        
        // Tutup statement
        mysqli_stmt_close($stmt);

    } else {
        $message = '<div class="alert alert-danger">Error: Gagal menyiapkan query. ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman Ruang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* CSS Kustom Anda dipertahankan karena sudah bagus */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        body { background-color: #f4f7f6; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); animation: fadeInUp 0.5s ease-out forwards; }
        .card-header { background-color: #007bff; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; font-weight: 600; }
        .form-control { border-radius: 8px; transition: border-color 0.3s, box-shadow 0.3s; }
        .form-control:focus { border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); outline: none; }
        .btn { border-radius: 8px; font-weight: 600; padding: 10px 20px; transition: transform 0.2s, box-shadow 0.2s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        .btn i { margin-right: 8px; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar-plus"></i> Tambah Peminjaman Ruang</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Tampilkan pesan jika ada
                    if (!empty($message)) {
                        echo $message;
                    }
                    ?>
                    <form action="create_booking.php" method="post">
                        <div class="form-group">
                            <label for="nama_ruang">Nama Ruang</label>
                            <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" placeholder="Contoh: Aula Gedung A" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="jam">Jam</label>
                            <select class="form-control" id="jam" name="jam" required>
                                <option value="08.00-10.00">08.00-10.00</option>
                                <option value="10.00-12.00">10.00-12.00</option>
                                <option value="13.00-15.00">13.00-15.00</option>
                                <option value="15.00-17.00">15.00-17.00</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_user">Nama Peminjam</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                        <div class="form-group">
                            <label for="keperluan">Keperluan</label>
                            <textarea class="form-control" id="keperluan" name="keperluan" rows="3" placeholder="Contoh: Rapat Himpunan Mahasiswa" required></textarea>
                        </div>
                        <hr>
                        <div class="text-right">
                              <a href="index.php?po=booking" class="btn btn-secondary">
                                <i class="fas fa-times"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>Simpan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>