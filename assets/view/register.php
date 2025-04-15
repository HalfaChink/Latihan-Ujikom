<?php
// Ambil parameter error dan success dari URL
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>

    <!-- Menampilkan pesan error jika ada -->
    <?php if ($error): ?>
        <div class="popup-error" id="popupError"><?= htmlspecialchars($error) ?></div>
        <script>
            // Menampilkan popup error dan sembunyikan setelah 3 detik
            const popup = document.getElementById("popupError");
            popup.style.display = "block";
            setTimeout(() => popup.style.display = "none", 3000);
        </script>
    <?php endif; ?>

    <!-- Menampilkan pesan success jika ada -->
    <?php if ($success): ?>
        <div class="popup-success" id="popupSuccess"><?= htmlspecialchars($success) ?></div>
        <script>
            // Menampilkan popup success dan sembunyikan setelah 3 detik
            const popup = document.getElementById("popupSuccess");
            popup.style.display = "block";
            setTimeout(() => popup.style.display = "none", 3000);
        </script>
    <?php endif; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card bg-white">
                    <h1 class="text-center mb-4">Daftar</h1>
                    <form id="register-form" method="POST" action="../controller/registerController.php">
                        <!-- Form input untuk username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <!-- Form input untuk password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <!-- Tombol submit -->
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                    <div class="login-link mt-3">
                        <p>Sudah punya akun? <a href="../../index.php" class="text-decoration-none">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>