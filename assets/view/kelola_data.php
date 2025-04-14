<?php
// Memulai session untuk memastikan admin login
session_start();
include("../controller/db.php"); // Termasuk file database untuk koneksi

// Cek jika session user_id tidak ada, berarti user belum login, alihkan ke halaman login
if (!isset($_SESSION['users_id'])) {
    header("Location: ../../index.php");
    exit(); // Menghentikan eksekusi lebih lanjut
}

// Ambil data username dari database berdasarkan session user_id yang login
$stmtUser = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmtUser->execute([$_SESSION['users_id']]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Ambil semua data pegawai dari database
$stmt = $pdo->query("SELECT * FROM pegawai ORDER BY id DESC");
$pegawai = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data</title>
    <!-- Menggunakan Bootstrap untuk desain dan layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css"> <!-- Menyertakan file CSS untuk tampilan custom -->
</head>

<body>
    <div id="loading-screen">
        <div class="spinner"></div>
    </div>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-dark text-white p-3" id="sidebar-wrapper">
            <div class="sidebar-heading fw-bold">Admin Panel</div>
            <div class="list-group list-group-flush mt-3">
                <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
                <a href="kelola_data.php" class="list-group-item list-group-item-action bg-dark text-white">Kelola Data</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom px-3">
                <button class="btn btn-outline-secondary" id="menu-toggle">☰</button>
                <div class="ms-auto">
                    <!-- Menampilkan username yang login dan tombol logout -->
                    <span class="me-2 fw-bold">Halo, <?= htmlspecialchars($user['username']) ?></span>
                    <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                </div>
            </nav>

            <div class="container-fluid mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Daftar Pegawai</h3>
                    <!-- Tombol untuk menambahkan data pegawai baru -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Tambahkan Data</button>
                </div>

                <!-- Menampilkan notifikasi jika ada alert dalam session -->
                <?php if (isset($_SESSION['alert'])): ?>
                    <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['alert']['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['alert']); ?> <!-- Menghapus alert setelah ditampilkan -->
                <?php endif; ?>

                <input type="text" id="search" class="form-control mb-3" placeholder="Cari pegawai...">

                <!-- Menampilkan tabel data pegawai -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="pegawaiTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop untuk menampilkan data pegawai -->
                            <?php foreach ($pegawai as $p): ?>
                                <tr>
                                    <td><?= $p['id'] ?></td>
                                    <td><?= $p['nama'] ?></td>
                                    <td><?= $p['jabatan'] ?></td>
                                    <td><?= $p['email'] ?></td>
                                    <td><?= $p['telepon'] ?></td>
                                    <td>
                                        <!-- Tombol untuk edit dan hapus data pegawai -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>">Edit</button>
                                        <a href="../controller/hapus_pegawaiController.php?id=<?= $p['id'] ?>" onclick="return confirm('Yakin?')" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal Tambah -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <!-- Form untuk menambahkan pegawai baru -->
                        <form class="modal-content" action="../controller/tambah_pegawaiController.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Tambah Pegawai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                                <!-- Dropdown untuk memilih jabatan pegawai -->
                                <select name="jabatan" class="form-control mb-2" required>
                                    <option value="Software Engineer">Software Engineer</option>
                                    <option value="Project Manager">Project Manager</option>
                                    <option value="QA Engineer">QA Engineer</option>
                                    <option value="UI/UX Designer">UI/UX Designer</option>
                                    <option value="Backend Developer">Backend Developer</option>
                                    <option value="Frontend Developer">Frontend Developer</option>
                                    <option value="DevOps Engineer">DevOps Engineer</option>
                                </select>
                                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                                <input type="text" name="telepon" class="form-control" placeholder="Telepon" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit -->
                <?php foreach ($pegawai as $p): ?>
                    <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $p['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <!-- Form untuk mengedit data pegawai -->
                            <form class="modal-content" method="POST" action="../controller/edit_pegawaiController.php">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="nama" class="form-control mb-2" value="<?= $p['nama'] ?>" required>
                                    <!-- Dropdown untuk memilih jabatan pegawai -->
                                    <select name="jabatan" class="form-control mb-2" required>
                                        <option value="Software Engineer" <?= $p['jabatan'] == 'Software Engineer' ? 'selected' : '' ?>>Software Engineer</option>
                                        <option value="Project Manager" <?= $p['jabatan'] == 'Project Manager' ? 'selected' : '' ?>>Project Manager</option>
                                        <option value="QA Engineer" <?= $p['jabatan'] == 'QA Engineer' ? 'selected' : '' ?>>QA Engineer</option>
                                        <option value="UI/UX Designer" <?= $p['jabatan'] == 'UI/UX Designer' ? 'selected' : '' ?>>UI/UX Designer</option>
                                        <option value="Backend Developer" <?= $p['jabatan'] == 'Backend Developer' ? 'selected' : '' ?>>Backend Developer</option>
                                        <option value="Frontend Developer" <?= $p['jabatan'] == 'Frontend Developer' ? 'selected' : '' ?>>Frontend Developer</option>
                                        <option value="DevOps Engineer" <?= $p['jabatan'] == 'DevOps Engineer' ? 'selected' : '' ?>>DevOps Engineer</option>
                                    </select>
                                    <input type="email" name="email" class="form-control mb-2" value="<?= $p['email'] ?>" required>
                                    <input type="text" name="telepon" class="form-control" value="<?= $p['telepon'] ?>" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Memuat Bootstrap JS dan file JS lainnya -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>