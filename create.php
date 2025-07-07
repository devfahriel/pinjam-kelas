<?php
// Sertakan file koneksi database di awal
include 'config.php';

// Inisialisasi variabel untuk pesan
$message = '';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data dari form
    $id_menu = $_POST['id_menu'];
    $nama = $_POST['nama'];
    $link = $_POST['link'];
    $class = $_POST['class'];
    $posisi = $_POST['posisi'];
    $aktif = $_POST['aktif'];

    // 2. Gunakan Prepared Statements untuk keamanan
    $sql = "INSERT INTO Kamis_fahriel (id_menu, nama, link, class, posisi, aktif) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // 3. Bind parameter (s untuk string, i untuk integer)
        mysqli_stmt_bind_param($stmt, "ssssis", $id_menu, $nama, $link, $class, $posisi, $aktif);

        // 4. Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, siapkan pesan sukses dan redirect
            header("refresh:1;url=index.php?po=menu");
            $message = '<div class="alert alert-success">Sukses! Menu baru berhasil disimpan. Anda akan dialihkan...</div>';
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
    <title>Tambah Menu Baru</title>
    <!-- Bootstrap & Font Awesome -->
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
                    <h3><i class="fas fa-bars"></i> Tambah Menu Baru</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Tampilkan pesan jika ada
                    if (!empty($message)) {
                        echo $message;
                    }
                    ?>
                    <form action="create.php" method="post">
                        <div class="form-group">
                            <label for="id_menu">ID Menu</label>
                            <input type="text" class="form-control" id="id_menu" name="id_menu" placeholder="Contoh: menu01" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Menu</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Menu" required>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Contoh: ?po=home" required>
                        </div>
                        <div class="form-group">
                            <label for="class">Class</label>
                            <input type="text" class="form-control" id="class" name="class" placeholder="Contoh: nav-link" required>
                        </div>
                        <div class="form-group">
                            <label for="posisi">Posisi</label>
                            <input type="number" class="form-control" id="posisi" name="posisi" placeholder="Masukkan urutan menu" required>
                        </div>
                        <div class="form-group">
                            <label for="aktif">Aktif</label>
                            <select class="form-control" name="aktif" id="aktif">
                                <option value="Y">Ya</option>
                                <option value="N">Tidak</option>
                            </select>
                        </div>
                        <hr>
                        <div class="text-right">
                            <a href="index.php?po=menu" class="btn btn-secondary">
                                <i class="fas fa-times"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript (Opsional, untuk Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi di paling akhir skrip
mysqli_close($conn);
?>