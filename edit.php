<?php
include 'config.php';

$message = '';
$row = []; // Inisialisasi $row

// Langkah 1: Ambil data jika parameter URL ada
if (isset($_GET['id_menu'])) {
    $id_from_url = $_GET['id_menu'];
    
    // id_menu kemungkinan adalah string (misal: "id_2"), jadi gunakan tipe 's'
    $sql_select = "SELECT * FROM kamis_fahriel WHERE id_menu = ?";
    
    if ($stmt_select = mysqli_prepare($conn, $sql_select)) {
        mysqli_stmt_bind_param($stmt_select, "s", $id_from_url);
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt_select);

        if (!$row) {
            $message = '<div class="alert alert-danger">Data menu tidak ditemukan.</div>';
        }
    } else {
        die("Error: Query SELECT gagal disiapkan.");
    }
} else {
     $message = '<div class="alert alert-warning">ID Menu tidak ditemukan di URL.</div>';
}

// Langkah 2: Proses form update saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_menu_original = $_POST['id_menu_original'];
    $id_menu = $_POST['id_menu'];
    $nama = $_POST['nama'];
    $link = $_POST['link'];
    $class = $_POST['class'];
    $posisi = $_POST['posisi'];
    $aktif = $_POST['aktif'];

    // Perbaikan tipe data bind_param: s,s,s,s,i,s,s
    $sql_update = "UPDATE kamis_fahriel SET id_menu = ?, nama = ?, link = ?, class = ?, posisi = ?, aktif = ? WHERE id_menu = ?";
    
    if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
        mysqli_stmt_bind_param($stmt_update, "ssssiss", $id_menu, $nama, $link, $class, $posisi, $aktif, $id_menu_original);

        if (mysqli_stmt_execute($stmt_update)) {
            header("refresh:1;url=index.php?po=menu");
            $message = '<div class="alert alert-success">Sukses! Data menu berhasil diperbarui. Anda akan dialihkan...</div>';
            
            // Ambil ulang data terbaru untuk ditampilkan di form
            $sql_select_again = "SELECT * FROM kamis_fahriel WHERE id_menu = ?";
             if ($stmt_select_again = mysqli_prepare($conn, $sql_select_again)) {
                mysqli_stmt_bind_param($stmt_select_again, "s", $id_menu);
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
    <title>Edit Data Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* CSS Kustom untuk tampilan animatif dan menarik */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        body { background-color: #f4f7f6; }
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            animation: fadeInUp 0.5s ease-out forwards;
        }
        .card-header {
            background-color:rgb(16, 128, 240);
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-weight: 600;
        }
        .form-control {
            border-radius: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            outline: none;
        }
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover {
            transform: translateY(-px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn i { margin-right: 8px; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-edit"></i> Edit Data Menu</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Tampilkan pesan jika ada
                    if (!empty($message)) {
                        echo $message;
                    }
                    ?>

                    <?php if (!empty($row)): ?>
                    <form action="edit.php?id_menu=<?= htmlspecialchars($row['id_menu']); ?>" method="post">
                        
                        <input type="hidden" name="id_menu_original" value="<?= htmlspecialchars($row['id_menu']); ?>">
                        
                        <div class="form-group">
                            <label for="id_menu">ID Menu</label>
                            <input type="text" class="form-control" id="id_menu" name="id_menu" value="<?= htmlspecialchars($row['id_menu']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" value="<?= htmlspecialchars($row['link']); ?>" required>
                        </div>
                         <div class="form-group">
                            <label for="class">Class</label>
                            <input type="text" class="form-control" id="class" name="class" value="<?= htmlspecialchars($row['class']); ?>" required>
                        </div>
                         <div class="form-group">
                            <label for="posisi">Posisi</label>
                            <input type="number" class="form-control" id="posisi" name="posisi" value="<?= htmlspecialchars($row['posisi']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="aktif">Aktif</label>
                            <select class="form-control" name="aktif" id="aktif" required>
                                <option value="Y" <?php if ($row['aktif'] == 'Y') echo 'selected'; ?>>Ya</option>
                                <option value="N" <?php if ($row['aktif'] == 'N') echo 'selected'; ?>>Tidak</option>
                            </select>
                        </div>
                        <hr>
                        <div class="text-right">
                             <a href="index.php?po=menu" class="btn btn-secondary">
                                <i class="fas fa-times"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i>Update
                            </button>
                        </div>
                    </form>
                    <?php elseif(empty($message)): ?>
                        <div class="alert alert-danger">Memuat data gagal atau data tidak ada.</div>
                        <a href="index.php?po=menu" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi di paling akhir skrip
mysqli_close($conn);
?>