<?php
include 'config.php';

$message = '';
$row = []; // Inisialisasi $row sebagai array kosong

// Langkah 1: Ambil data mahasiswa dari database berdasarkan parameter URL
// DIUBAH: Menggunakan 'id_user' sebagai parameter
if (isset($_GET['id_user'])) {
    $id_from_url = $_GET['id_user'];
    
    // DIUBAH: Query SELECT untuk tabel 'data_mahasiswa'
    $sql_select = "SELECT * FROM data_mahasiswa WHERE id_user = ?";
    
    if ($stmt_select = mysqli_prepare($conn, $sql_select)) {
        mysqli_stmt_bind_param($stmt_select, "s", $id_from_url); 
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt_select);

        if (!$row) {
            $message = '<div class="alert alert-danger">Data mahasiswa tidak ditemukan. Pastikan ID pada URL sudah benar.</div>';
        }
    } else {
        die("Error: Query SELECT gagal disiapkan.");
    }
} else {
    $message = '<div class="alert alert-warning">ID User tidak ditemukan di URL.</div>';
}

// Langkah 2: Proses form update saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DIUBAH: Variabel disesuaikan dengan form mahasiswa
    $id_user_original = $_POST['id_user_original']; 
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $nim_nidn = $_POST['nim_nidn'];
    $role = $_POST['role'];

    // DIUBAH: Query UPDATE untuk tabel 'data_mahasiswa'
    $sql_update = "UPDATE data_mahasiswa SET id_user = ?, nama = ?, nim_nidn = ?, role = ? WHERE id_user = ?";
    
    if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
        // DIUBAH: Tipe data disesuaikan -> s, s, s, s, s
        mysqli_stmt_bind_param($stmt_update, "sssss", $id_user, $nama, $nim_nidn, $role, $id_user_original);

        if (mysqli_stmt_execute($stmt_update)) {
            // DIUBAH: Redirect ke halaman data mahasiswa
            header("refresh:1;url=index.php?po=mahasiswa");
            $message = '<div class="alert alert-success">Sukses! Data berhasil diperbarui. Anda akan dialihkan...</div>';
            
            // Ambil ulang data terbaru untuk ditampilkan di form setelah update
            $sql_select_again = "SELECT * FROM data_mahasiswa WHERE id_user = ?";
             if ($stmt_select_again = mysqli_prepare($conn, $sql_select_again)) {
                mysqli_stmt_bind_param($stmt_select_again, "s", $id_user);
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
    <title>Edit Data Mahasiswa</title> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
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
                    <h3><i class="fas fa-user-edit"></i> Edit Data Mahasiswa</h3> </div>
                <div class="card-body">
                    <?php if (!empty($message)) { echo $message; } ?>

                    <?php if (!empty($row)): ?>
                    <form action="edit_mahasiswa.php?id_user=<?= htmlspecialchars($row['id_user']); ?>" method="post">
                        
                        <input type="hidden" name="id_user_original" value="<?= htmlspecialchars($row['id_user']); ?>">
                        
                        <div class="form-group">
                            <label for="id_user">ID User (Primary Key)</label>
                            <input type="text" class="form-control" id="id_user" name="id_user" value="<?= htmlspecialchars($row['id_user']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nim_nidn">NIM/NIDN</label>
                            <input type="text" class="form-control" id="nim_nidn" name="nim_nidn" value="<?= htmlspecialchars($row['nim_nidn']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin" <?= ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?= ($row['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                <option value="super user" <?= ($row['role'] == 'super user') ? 'selected' : ''; ?>>Super User</option>
                            </select>
                        <hr>
                        <div class="text-right">
                             <a href="index.php?po=mahasiswa" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>
                        </div>
                    </form>
                    <?php elseif(empty($message)): ?>
                        <div class="alert alert-danger">Memuat data gagal atau data tidak ada.</div>
                        <a href="index.php?po=mahasiswa" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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