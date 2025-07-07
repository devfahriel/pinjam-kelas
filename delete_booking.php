<?php
// Sertakan file koneksi database
include 'config.php';

// Cek apakah 'nama_ruang' ada di URL dan bukan kosong
if (isset($_GET['nama_ruang']) && !empty($_GET['nama_ruang'])) {
    // Ambil nama ruang dari URL
    $nama_ruang_to_delete = $_GET['nama_ruang'];

    // Query SQL untuk menghapus data berdasarkan nama_ruang
    $sql = "DELETE FROM status_booking WHERE nama_ruang = ?";
    
    // Siapkan statement
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // nama_ruang adalah string, jadi gunakan tipe 's'
        mysqli_stmt_bind_param($stmt, "s", $nama_ruang_to_delete);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, kembali ke halaman laporan peminjaman
            // Pastikan nama file laporan Anda sudah benar
            header("Location: index.php?po=booking");
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
    // Pesan jika tidak ada 'nama_ruang' di URL
    echo "Error: Parameter 'nama_ruang' tidak ditemukan di URL.";
}

// Tutup koneksi
mysqli_close($conn);
?>