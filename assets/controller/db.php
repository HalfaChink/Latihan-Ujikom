<?php
// Koneksi ke database
$host = 'localhost';  // Alamat server database
$db = 'pegawai_db';   // Nama database yang digunakan
$user = 'root';       // Username untuk login ke database
$pass = '';           // Password untuk user

// Membuat koneksi menggunakan PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Menentukan mode error untuk menampilkan exception saat ada kesalahan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Menangani error jika koneksi gagal
    echo "Koneksi gagal: " . $e->getMessage();
}
