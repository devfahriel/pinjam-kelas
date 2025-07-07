<?php
// Sertakan file koneksi database di awal
include 'config.php';

// Inisialisasi variabel untuk pesan error atau sukses
$message = '';

// Cek apakah form telah disubmit (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data dari form
    $Id_user = $_POST['id_user'];
    $Nama_mahasiswa = $_POST['nama'];
    $Nim_nidn = $_POST['nim_nidn'];
    $Role = $_POST['role'];

    // 2. Query SQL untuk insert data
    $sql = "INSERT INTO data_mahasiswa (id_user, nama, nim_nidn, role) VALUES (?, ?, ?, ?)";
    
    // Siapkan statement
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // 3. Bind parameter ke statement (s untuk string, i untuk integer)
        mysqli_stmt_bind_param($stmt, "ssss", $Id_user, $Nama_mahasiswa, $Nim_nidn, $Role);

        // 4. Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect ke halaman utama (index.php) setelah jeda singkat
            header("refresh:1;url=index.php?po=mahasiswa");
            $message = '<div class="alert alert-success">Sukses! Data berhasil disimpan. Anda akan dialihkan...</div>';
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
    <title>Tambah mahasiswa Baru</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* CSS Kustom untuk tampilan animatif dan menarik */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            background-color: #f4f7f6;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 20px rgba(194, 137, 137, 0.08);
            animation: fadeInUp 0.5s ease-out forwards; /* Terapkan animasi */
        }

        .card-header {
            background-color:rgb(16, 128, 240);
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            transition: border-color 0.3s, box-shadow 0.3s; /* Transisi halus */
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Efek 'glow' saat aktif */
            outline: none;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px); /* Efek tombol terangkat */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn i {
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-plus-circle"></i> Tambah Mahasiswa Baru</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Tampilkan pesan jika ada
                    if (!empty($message)) {
                        echo $message;
                    }
                    ?>
                    <form action="create_mahasiswa.php" method="post">
                        <div class="form-group">
                            <label for="id_user">ID User</label>
                            <input type="text" class="form-control" id="id_user" name="id_user" placeholder="Contoh: USER001" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Mahasiswa" required>
                        </div>
                        <div class="form-group">
                            <label for="nim_nidn">Nim_Nidn</label>
                            <input type="text" class="form-control" id="nim_nidn" name="nim_nidn" placeholder="Masukkan Nim/Nidn" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="role" placeholder="Contoh: Admin" required>
                        </div>
                        <hr>
                        <div class="text-right">
                             <a href="index.php?po=mahasiswa" class="btn btn-secondary">
                                <i class="fas fa-times"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>Simpan Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>