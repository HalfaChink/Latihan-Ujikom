<?php
// Mulai sesi untuk melacak login pengguna
session_start();

// Mengimpor file untuk koneksi ke database
include("../controller/db.php");

// Cek jika request method adalah POST (form login dikirim)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Persiapkan query untuk mencari user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    // Ambil data pengguna
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek jika user ditemukan dan password sesuai
    if ($users && password_verify($password, $users['password'])) {
        // Jika berhasil, simpan user ID ke session dan redirect ke dashboard
        $_SESSION['users_id'] = $users['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Jika gagal, redirect ke halaman login dengan pesan error
        header("Location: ../../index.php?error=Username%20atau%20password%20salah.");
        exit();
    }
} else {
    // Jika bukan POST, redirect ke halaman login
    header("Location: ../../index.php");
    exit();
}
