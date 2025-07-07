<?php
// Sertakan file koneksi database
include 'config.php';

// Cek apakah 'id_menu' ada di URL
if (isset($_GET['id_menu']) && !empty($_GET['id_menu'])) {
    $id_to_delete = $_GET['id_menu'];

    // Query SQL untuk menghapus data berdasarkan id_menu
    $sql = "DELETE FROM kamis_fahriel WHERE id_menu = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // PERBAIKAN: id_menu kemungkinan adalah string, jadi gunakan tipe 's'
        mysqli_stmt_bind_param($stmt, "s", $id_to_delete);

        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, kembali ke halaman daftar menu
            header("Location: index.php?po=menu");
            exit();
        } else {
            echo "Error: Gagal menghapus data. " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);

    } else {
        echo "Error: Gagal menyiapkan statement. " . mysqli_error($conn);
    }
} else {
    echo "Error: 'id_menu' tidak ditemukan di URL.";
}

// Tutup koneksi
mysqli_close($conn);
?>