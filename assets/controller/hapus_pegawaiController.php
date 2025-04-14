<?php
// Mulai session buat nyimpen alert
session_start();

// Panggil koneksi ke database
include("db.php");

// Cek apakah ada parameter id di URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
        // Siapin query buat hapus data pegawai berdasarkan ID
        $stmt = $pdo->prepare("DELETE FROM pegawai WHERE id = ?");
        $stmt->execute([$id]);

        // Kalau sukses, simpan pesan alert sukses ke session
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Data pegawai berhasil dihapus!'
        ];
    } catch (Exception $e) {
        // Kalau gagal, simpan pesan alert error
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Gagal hapus data: ' . $e->getMessage()
        ];
    }
}

// Setelah proses, redirect ke halaman kelola data
header("Location: ../view/kelola_data.php");
exit();
