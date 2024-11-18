<?php
// Konfigurasi koneksi database
$host = 'localhost'; // Host database
$user = 'root';      // Username database
$pass = '';          // Password database
$db   = 'db_bizbalance'; // Nama database

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Periksa apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Alias untuk koneksi (opsional, untuk kompatibilitas)
$koneksi = $conn; // $koneksi bisa digunakan sebagai nama lain dari $conn
?>

