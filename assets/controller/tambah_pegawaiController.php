<?php
// Mulai session untuk akses login dan simpan alert
session_start();

// Panggil koneksi ke database
include("db.php");

// Cek apakah user sudah login, kalau belum arahkan ke halaman login
if (!isset($_SESSION['users_id'])) {
    header("Location: ../../index.html");
    exit();
}

// Cek apakah request-nya metode POST (form dikirim)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari form
    $nama = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $email = $_POST['email'] ?? '';
    $telepon = $_POST['telepon'] ?? '';

    // Cek apakah semua field terisi
    if ($nama && $jabatan && $email && $telepon) {
        try {
            // Simpan data ke tabel pegawai
            $stmt = $pdo->prepare("INSERT INTO pegawai (nama, jabatan, email, telepon) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nama, $jabatan, $email, $telepon]);

            // Simpan alert sukses ke session
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Data pegawai berhasil ditambahkan!'];
        } catch (PDOException $e) {
            // Kalau gagal insert, simpan alert error ke session
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Gagal menyimpan data: ' . $e->getMessage()];
        }
    } else {
        // Kalau ada field kosong, simpan alert warning ke session
        $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Semua field harus diisi!'];
    }

    // Setelah selesai, kembali ke dashboard
    header("Location: ../view/dashboard.php");
    exit();
} else {
    // Kalau akses bukan lewat POST, langsung arahkan ke dashboard
    header("Location: ../view/dashboard.php");
    exit();
}
