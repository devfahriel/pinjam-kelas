<?php
include 'config.php';

$message = '';
$row = []; // Inisialisasi $row sebagai array kosong

// Langkah 1: Ambil data ruangan dari database berdasarkan parameter URL
// DIUBAH: Menggunakan 'id_ruangan' sebagai parameter
if (isset($_GET['id_ruangan'])) {
    $id_from_url = $_GET['id_ruangan'];
    
    // DIUBAH: Query SELECT untuk tabel 'data_ruangan'
    $sql_select = "SELECT * FROM data_ruangan WHERE id_ruangan = ?";
    
    if ($stmt_select = mysqli_prepare($conn, $sql_select)) {
        mysqli_stmt_bind_param($stmt_select, "s", $id_from_url); 
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt_select);

        if (!$row) {
            $message = '<div class="alert alert-danger">Data ruangan tidak ditemukan. Pastikan ID pada URL sudah benar.</div>';
        }
    } else {
        die("Error: Query SELECT gagal disiapkan.");
    }
} else {
    $message = '<div class="alert alert-warning">ID Ruangan tidak ditemukan di URL.</div>';
}

// Langkah 2: Proses form update saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DIUBAH: Variabel disesuaikan dengan form ruangan
    $id_ruangan_original = $_POST['id_ruangan_original']; 
    $id_ruangan = $_POST['id_ruangan'];
    $nama_ruangan = $_POST['nama_ruangan'];
    $nomor_ruangan = $_POST['nomor_ruangan'];
    $status = $_POST['status'];

    // DIUBAH: Query UPDATE untuk tabel 'data_ruangan'
    $sql_update = "UPDATE data_ruangan SET id_ruangan = ?, nama_ruangan = ?, nomor_ruangan = ?, status = ? WHERE id_ruangan = ?";
    
    if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
        // DIUBAH: Tipe data disesuaikan -> s, s, i, s, s
        mysqli_stmt_bind_param($stmt_update, "ssiss", $id_ruangan, $nama_ruangan, $nomor_ruangan, $status, $id_ruangan_original);

        if (mysqli_stmt_execute($stmt_update)) {
            // DIUBAH: Redirect ke halaman data ruangan
            header("refresh:1;url=index.php?po=barang");
            $message = '<div class="alert alert-success">Sukses! Data berhasil diperbarui. Anda akan dialihkan...</div>';
            
            // Ambil ulang data terbaru untuk ditampilkan di form setelah update
            $sql_select_again = "SELECT * FROM data_ruangan WHERE id_ruangan = ?";
             if ($stmt_select_again = mysqli_prepare($conn, $sql_select_again)) {
                mysqli_stmt_bind_param($stmt_select_again, "s", $id_ruangan);
                mysqli_stmt_execute($stmt_select_again);
                $result_again = mysqli_stmt_get_result($stmt_select_again);
                $row = mysqli_fetch_assoc($result_again);
                mysqli_stmt_close($stmt_select_again);
            }
        } else {
            $message = '<div class="alert alert-danger">Error: Gagal memperbarui data. ' . mysqli_stmt_error($stmt_update). '</div>';
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
    <title>Edit Data Ruangan</title> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* CSS Tidak Diubah */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        body { background-color: #f4f7f6; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); animation: fadeInUp 0.5s ease-out forwards; }
        .card-header { background-color: #28a745; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; font-weight: 600; }
        .form-control { border-radius: 8px; transition: border-color 0.3s, box-shadow 0.3s; }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25); outline: none; }
        .btn { border-radius: 8px; font-weight: 600; padding: 10px 20px; transition: transform 0.2s, box-shadow 0.2s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn i { margin-right: 8px; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-edit"></i> Edit Data Ruangan</h3> </div>
                <div class="card-body">
                    <?php if (!empty($message)) { echo $message; } ?>

                    <?php if (!empty($row)): ?>
                    <form action="edit_barang.php?id_ruangan=<?= htmlspecialchars($row['id_ruangan']); ?>" method="post">
                        
                        <input type="hidden" name="id_ruangan_original" value="<?= htmlspecialchars($row['id_ruangan']); ?>">
                        
                        <div class="form-group">
                            <label for="id_ruangan">ID Ruangan (Primary Key)</label>
                            <input type="text" class="form-control" id="id_ruangan" name="id_ruangan" value="<?= htmlspecialchars($row['id_ruangan']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_ruangan">Nama Ruangan</label>
                            <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" value="<?= htmlspecialchars($row['nama_ruangan']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_ruangan">Nomor Ruangan</label>
                            <input type="number" class="form-control" id="nomor_ruangan" name="nomor_ruangan" value="<?= htmlspecialchars($row['nomor_ruangan']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="available" <?= ($row['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                                <option value="not available" <?= ($row['status'] == 'not available') ? 'selected' : ''; ?>>Not Available</option>
                            </select>
                        </div>
                        <hr>
                        <div class="text-right">
                             <a href="index.php?po=barang" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>
                        </div>
                    </form>
                    <?php elseif(empty($message)): ?>
                        <div class="alert alert-danger">Memuat data gagal atau data tidak ada.</div>
                        <a href="index.php?po=barang" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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