<?php
// Mulai session buat cek login & nyimpen alert
session_start();

// Panggil koneksi ke database
include("db.php");

// Cek apakah user udah login, kalau belum, lempar ke halaman login
if (!isset($_SESSION['users_id'])) {
    header("Location: ../../index.html");
    exit();
}

// Cek apakah request-nya metode POST (form edit dikirim)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari form (pakai null coalescing & trim buat amankan input)
    $id      = $_POST['id'] ?? '';
    $nama    = trim($_POST['nama'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    // Cek apakah semua field terisi
    if ($id && $nama && $jabatan && $email && $telepon) {
        try {
            // Query untuk update data pegawai berdasarkan id
            $stmt = $pdo->prepare("UPDATE pegawai SET nama = ?, jabatan = ?, email = ?, telepon = ? WHERE id = ?");
            $stmt->execute([$nama, $jabatan, $email, $telepon, $id]);

            // Simpan alert sukses ke session
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Data pegawai berhasil diubah!'
            ];
        } catch (PDOException $e) {
            // Simpan alert error kalau query gagal
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Gagal mengedit data: ' . htmlspecialchars($e->getMessage())
            ];
        }
    } else {
        // Simpan alert warning kalau ada field yang kosong
        $_SESSION['alert'] = [
            'type' => 'warning',
            'message' => 'Semua field harus diisi!'
        ];
    }

    // Setelah proses, redirect ke halaman kelola data
    header("Location: ../view/kelola_data.php");
    exit();
}

// Kalau akses bukan POST, tetap arahkan balik ke kelola data
header("Location: ../view/kelola_data.php");
exit();
