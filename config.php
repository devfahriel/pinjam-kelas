<?php
// --- Konfigurasi Database ---
$db_host = 'localhost';
$db_user = 'root';      // User default XAMPP
$db_pass = '';          // Password default XAMPP kosong
$db_name = 'fahriel';   // Nama database yang kita buat

// --- Membuat Koneksi ---
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// --- Cek Koneksi ---
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>