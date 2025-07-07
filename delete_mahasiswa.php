<?php
// Sertakan file koneksi database
include 'config.php';

// Cek apakah 'id_user' ada di URL dan bukan kosong
if (isset($_GET['id_user']) && !empty($_GET['id_user'])) {
    $id_to_delete = $_GET['id_user'];

    // Query SQL untuk menghapus data berdasarkan id_user
    $sql = "DELETE FROM data_mahasiswa WHERE id_user = ?";
    
    // Siapkan statement
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // id_user adalah string, jadi gunakan tipe 's'
        mysqli_stmt_bind_param($stmt, "s", $id_to_delete);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, kembali ke halaman daftar mahasiswa
            header("Location: index.php?po=mahasiswa");
            exit();
        } else {
            // Tampilkan pesan jika eksekusi gagal
            echo "Error: Gagal menghapus data. " . mysqli_stmt_error($stmt);
        }
        
        // Tutup statement
        mysqli_stmt_close($stmt);

    } else {
        // Tampilkan pesan jika persiapan statement gagal
        echo "Error: Gagal menyiapkan statement. " . mysqli_error($conn);
    }
} else {
    // Pesan jika tidak ada 'id_user' di URL
    echo "Error: 'id_user' tidak ditemukan di URL.";
}

// Tutup koneksi
mysqli_close($conn);
?>