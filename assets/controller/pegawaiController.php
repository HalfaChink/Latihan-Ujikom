<?php
// Panggil koneksi ke database
include 'db.php';

// Fungsi untuk tambah data pegawai ke database
function addEmployee($nama, $jabatan, $email, $telepon)
{
    global $pdo;
    // Query insert ke tabel pegawai
    $stmt = $pdo->prepare("INSERT INTO pegawai (nama, jabatan, email, telepon) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $jabatan, $email, $telepon]);
}

// Fungsi untuk ambil semua data pegawai dari database
function getEmployees()
{
    global $pdo;
    // Ambil semua data pegawai, urut dari yang terbaru
    $stmt = $pdo->query("SELECT * FROM pegawai ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
