<?php
// Panggil koneksi ke database
include("../controller/db.php");

// Cek apakah request-nya metode POST (form dikirim)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ambil data dari form
    $username = $_POST['username'];

    // Hash password biar nggak disimpan mentah di database
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah dipakai
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    // Kalau sudah ada user dengan username itu, redirect dan kirim pesan error
    if ($stmt->rowCount() > 0) {
        header("Location: ../../register.php?error=Username%20sudah%20terdaftar.");
        exit();
    } else {
        // Kalau belum, simpan user baru ke database
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        // Redirect ke halaman register dengan pesan sukses
        header("Location: ../../register.php?success=Pendaftaran%20berhasil.%20Silakan%20login.");
        exit();
    }
}
