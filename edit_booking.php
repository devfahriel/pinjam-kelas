<?php
include 'config.php';

$message = '';
$row = []; // Inisialisasi $row sebagai array kosong

// Langkah 1: Ambil data peminjaman dari database berdasarkan 'nama_ruang' di URL.
if (isset($_GET['nama_ruang'])) {
    $nama_ruang_from_url = $_GET['nama_ruang'];
    
    // Query SELECT menggunakan 'nama_ruang' sebagai kunci
    $sql_select = "SELECT * FROM status_booking WHERE nama_ruang = ?";
    
    if ($stmt_select = mysqli_prepare($conn, $sql_select)) {
        // 's' untuk string, karena nama_ruang adalah varchar
        mysqli_stmt_bind_param($stmt_select, "s", $nama_ruang_from_url); 
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt_select);

        if (!$row) {
            $message = '<div class="alert alert-danger">Data peminjaman tidak ditemukan.</div>';
        }
    } else {
        die("Error: Query SELECT gagal disiapkan.");
    }
} else {
    $message = '<div class="alert alert-warning">Nama Ruang tidak ditemukan di URL.</div>';
}

// Langkah 2: Proses form update saat disubmit (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil semua data dari form
    $nama_ruang_original = $_POST['nama_ruang_original']; // Kunci asli untuk klausa WHERE
    $nama_ruang_new = $_POST['nama_ruang']; // Nilai baru untuk nama_ruang
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $nama_user = $_POST['nama_user'];
    $keperluan = $_POST['keperluan'];

    // Query UPDATE, menggunakan 'nama_ruang_original' di klausa WHERE
    $sql_update = "UPDATE status_booking SET nama_ruang = ?, tanggal = ?, jam = ?, nama_user = ?, keperluan = ? WHERE nama_ruang = ?";
    
    if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
        // Bind 6 parameter string (s)
        mysqli_stmt_bind_param($stmt_update, "ssssss", $nama_ruang_new, $tanggal, $jam, $nama_user, $keperluan, $nama_ruang_original);

        if (mysqli_stmt_execute($stmt_update)) {
            // Redirect ke halaman laporan
            header("refresh:2;url=index.php?po=booking");
            $message = '<div class="alert alert-success">Sukses! Data berhasil diperbarui. Anda akan dialihkan...</div>';
            
            // Ambil ulang data terbaru untuk ditampilkan di form (menggunakan nama_ruang yang baru jika diubah)
            $sql_select_again = "SELECT * FROM status_booking WHERE nama_ruang = ?";
             if ($stmt_select_again = mysqli_prepare($conn, $sql_select_again)) {
                mysqli_stmt_bind_param($stmt_select_again, "s", $nama_ruang_new);
                mysqli_stmt_execute($stmt_select_again);
                $result_again = mysqli_stmt_get_result($stmt_select_again);
                $row = mysqli_fetch_assoc($result_again);
                mysqli_stmt_close($stmt_select_again);
            }
        } else {
            // Cek jika error disebabkan oleh duplicate entry
            if (mysqli_errno($conn) == 1062) {
                 $message = '<div class="alert alert-danger">Error: Gagal memperbarui data. Nama Ruang \''.htmlspecialchars($nama_ruang_new).'\' sudah ada. Primary key harus unik.</div>';
            } else {
                 $message = '<div class="alert alert-danger">Error: Gagal memperbarui data. ' . mysqli_stmt_error($stmt_update). '</div>';
            }
        }
        mysqli_stmt_close($stmt_update);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* CSS Anda tidak diubah */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        body { background-color: #f4f7f6; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); animation: fadeInUp 0.5s ease-out forwards; }
        .card-header { background-color: #28a745; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; font-weight: 600; }
        .form-control { border-radius: 8px; }
        .btn { border-radius: 8px; font-weight: 600; padding: 10px 20px; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-edit"></i> Edit Data Peminjaman</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($message)) { echo $message; } ?>

                    <?php if (!empty($row)): ?>
                    <form action="edit_booking.php?nama_ruang=<?= urlencode($row['nama_ruang']); ?>" method="post">
                        
                        <input type="hidden" name="nama_ruang_original" value="<?= htmlspecialchars($row['nama_ruang']); ?>">
                        
                        <div class="form-group">
                            <label for="nama_ruang">Nama Ruang (Primary Key)</label>
                            <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" value="<?= htmlspecialchars($row['nama_ruang']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars($row['tanggal']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jam">Jam</label>
                            <input type="text" class="form-control" id="jam" name="jam" value="<?= htmlspecialchars($row['jam']); ?>" placeholder="Contoh: 09:00 - 11:00" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_user">Nama Peminjam</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= htmlspecialchars($row['nama_user']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="keperluan">Keperluan</label>
                            <textarea class="form-control" id="keperluan" name="keperluan" rows="3" required><?= htmlspecialchars($row['keperluan']); ?></textarea>
                        </div>
                        <hr>
                        <div class="text-right">
                             <a href="laporan_peminjaman.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i> Update Data
                            </button>
                        </div>
                    </form>
                    <?php elseif(empty($message)): ?>
                        <div class="alert alert-danger">Memuat data gagal atau data tidak ditemukan.</div>
                        <a href="index.php?po=booking" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>