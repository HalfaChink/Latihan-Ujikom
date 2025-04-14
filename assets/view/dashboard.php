<?php
// Memulai sesi untuk melacak status login pengguna
session_start();

// Mengimpor file koneksi ke database
include("../controller/db.php");

// Mengecek apakah session 'users_id' ada, yang menandakan pengguna sudah login
if (!isset($_SESSION['users_id'])) {
    // Jika session 'users_id' tidak ada, redirect pengguna ke halaman login
    header("Location: ../../index.php");
    exit(); // Menghentikan eksekusi kode setelah redirect
}

// Menyiapkan query untuk mengambil username pengguna berdasarkan session 'users_id'
$stmtUser = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmtUser->execute([$_SESSION['users_id']]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC); // Mengambil hasil query username

// Menyiapkan query untuk mengambil statistik jabatan pegawai (jumlah pegawai per jabatan)
$stmtJabatan = $pdo->query("SELECT jabatan, COUNT(*) AS jumlah FROM pegawai GROUP BY jabatan");
$jabatanStats = $stmtJabatan->fetchAll(PDO::FETCH_ASSOC); // Menyimpan hasil statistik jabatan
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Menambahkan link CSS Bootstrap untuk styling halaman -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menambahkan link ke file CSS custom untuk halaman dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <!-- Loading screen yang ditampilkan saat halaman sedang dimuat -->
    <div id="loading-screen">
        <div class="spinner"></div> <!-- Animasi loading -->
    </div>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar dengan menu navigasi -->
        <div class="border-end bg-dark text-white p-3" id="sidebar-wrapper">
            <div class="sidebar-heading fw-bold">Admin Panel</div>
            <div class="list-group list-group-flush mt-3">
                <!-- Menu sidebar untuk navigasi ke halaman dashboard dan kelola data -->
                <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
                <a href="kelola_data.php" class="list-group-item list-group-item-action bg-dark text-white">Kelola Data</a>
            </div>
        </div>

        <!-- Konten utama halaman -->
        <div id="page-content-wrapper" class="w-100">
            <!-- Navbar bagian atas dengan tombol untuk toggle sidebar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom px-3">
                <button class="btn btn-outline-secondary" id="menu-toggle">☰</button>
                <div class="ms-auto">
                    <!-- Menampilkan nama pengguna yang sedang login -->
                    <span class="me-2 fw-bold">Halo, <?= htmlspecialchars($user['username']) ?></span>
                    <!-- Tombol logout yang mengarahkan ke file logout.php -->
                    <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                </div>
            </nav>

            <!-- Menampilkan statistik jabatan pegawai dalam bentuk card -->
            <div class="row m-4">
                <?php foreach ($jabatanStats as $stat): ?>
                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                        <div class="card text-white bg-dark mb-3 shadow-sm" style="border-radius: 8px;">
                            <!-- Header card berisi nama jabatan -->
                            <div class="card-header" style="font-size: 14px;"><?= htmlspecialchars($stat['jabatan']) ?></div>
                            <div class="card-body" style="padding: 10px;">
                                <!-- Body card berisi jumlah pegawai untuk jabatan tersebut -->
                                <h5 class="card-title" style="font-size: 16px;"><?= $stat['jumlah'] ?> Pegawai</h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Mengimpor Bootstrap JS dan bundle untuk interaktivitas (collapse, modal, dll) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menghitung durasi halaman loading agar loading screen menghilang dengan smooth
        const loadingScreen = document.getElementById('loading-screen');
        const startTime = Date.now();

        // Setelah halaman selesai dimuat, hilangkan loading screen
        window.addEventListener('load', function() {
            const loadDuration = Date.now() - startTime;
            const minimumDuration = 800; // Durasi minimum untuk menampilkan loading screen
            const remainingTime = Math.max(minimumDuration - loadDuration, 0); // Waktu sisa yang perlu ditunggu

            // Setelah waktu yang cukup, menghilangkan loading screen dengan efek fade-out
            setTimeout(() => {
                loadingScreen.classList.add('fade-out');
                setTimeout(() => loadingScreen.style.display = 'none', 500);
            }, remainingTime);
        });
    </script>
</body>

</html>