<?php
session_start();
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="assets/img/icon.png">
</head>

<body>
    <?php if ($error): ?>
        <div class="popup-error" id="popupError"><?= htmlspecialchars($error) ?></div>
        <script>
            const popup = document.getElementById("popupError");
            popup.style.display = "block";
            setTimeout(() => popup.style.display = "none", 3000);
        </script>
    <?php endif; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card bg-white">
                    <h1 class="text-center mb-4">Login</h1>
                    <form id="login-form" method="POST" action="assets/view/login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="register-link mt-3 text-center">
                        <p>Belum punya akun? <a href="assets/view/register.php" class="text-decoration-none">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>