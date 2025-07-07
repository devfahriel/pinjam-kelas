<?php
// Sertakan file koneksi database di awal
include 'config.php';

// Inisialisasi variabel untuk pesan error atau sukses
$message = '';

// Cek apakah form telah disubmit (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data dari form - DIUBAH SESUAI TABEL RUANGAN
    $id_ruangan = $_POST['id_ruangan'];
    $nama_ruangan = $_POST['nama_ruangan'];
    $nomor_ruangan = $_POST['nomor_ruangan'];
    $status = $_POST['status'];

    // 2. Query SQL untuk insert data ke tabel data_ruangan - DIUBAH
    $sql = "INSERT INTO data_ruangan (id_ruangan, nama_ruangan, nomor_ruangan, status) VALUES (?, ?, ?, ?)";
    
    // Siapkan statement
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // 3. Bind parameter ke statement (s=string, i=integer) - DIUBAH
        mysqli_stmt_bind_param($stmt, "ssis", $id_ruangan, $nama_ruangan, $nomor_ruangan, $status);

        // 4. Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect ke halaman utama ruangan - DIUBAH
            header("refresh:1;url=index.php?po=barang");
            $message = '<div class="alert alert-success">Sukses! Data ruangan berhasil disimpan. Anda akan dialihkan...</div>';
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
    <title>Tambah Ruangan Baru</title> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* CSS Kustom tidak diubah */
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
                    <h3><i class="fas fa-plus-circle"></i> Tambah Ruangan Baru</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Tampilkan pesan jika ada
                    if (!empty($message)) {
                        echo $message;
                    }
                    ?>
                    <form action="create_barang.php" method="post">
                        <div class="form-group">
                            <label for="id_ruangan">ID Ruangan</label>
                            <input type="text" class="form-control" id="id_ruangan" name="id_ruangan" placeholder="Contoh: RUANG01" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_ruangan">Nama Ruangan</label>
                            <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" placeholder="Contoh: Ruang Teori 1" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_ruangan">Nomor Ruangan</label>
                            <input type="number" class="form-control" id="nomor_ruangan" name="nomor_ruangan" placeholder="Masukkan nomor" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="available">Available</option>
                                <option value="not available">Not Available</option>
                            </select>
                        </div>
                        <hr>
                        <div class="text-right">
                             <a href="index.php?po=barang" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Ruangan
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