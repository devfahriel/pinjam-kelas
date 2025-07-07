<?php
session_start();

// Jika sudah dalam keadaan login, alihkan ke dashboard
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = '';

// Logika untuk memproses login saat form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // In a real application, you would get this from a database
    $valid_username = 'Fahriel';
    $valid_password = 'RPL123'; // In a real app, use hashed passwords

    $input_username = $_POST['username'];
    $input_password = $_POST['password'];
    // $input_role = $_POST['role']; // You can use this value as needed

    // Check credentials
    if ($input_username == $valid_username && $input_password == $valid_password) {
        // If successful, set session and redirect
        $_SESSION['is_logged_in'] = true;
        $_SESSION['username'] = $input_username;
        header("Location: index.php");
        exit;
    } else {
        // If it fails, show an error message
        $error = 'Nama Pengguna atau Kata Sandi salah!';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Peminjaman Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #e9ecef;
        }
        .main-container {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
        }
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 500px;
            background-color: #fff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 1rem;
            overflow: hidden;
        }
        .image-section {
            flex: 1;
            background: url('WhatsApp Image 2025-07-07 at 00.48.21_ffff4acd.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
            position: relative;
            text-align: left;
        }
        .image-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.1));
        }
        .welcome-text {
            position: relative;
            z-index: 1;
        }
        .welcome-line {
            width: 80px;
            height: 5px;
            background-color: #0d6efd;
            border-radius: 3px;
            margin-bottom: 1.5rem;
            animation: slideIn 0.8s 0.2s ease-out forwards;
            opacity: 0;
        }
        .welcome-text h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
            animation: slideUp 0.8s 0.4s ease-out forwards;
            opacity: 0;
        }
        .welcome-text p {
            font-size: 1.1rem;
            font-weight: 400;
            opacity: 0;
            line-height: 1.6;
            max-width: 350px;
            animation: slideUp 0.8s 0.6s ease-out forwards;
        }
        .form-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-section h3 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .form-section p {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }
        .btn-primary {
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
        }
        @keyframes slideIn {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="login-wrapper">
        <div class="image-section">
            <div class="welcome-text">
                <div class="welcome-line"></div>
                <h2>Selamat datang.</h2>
                <p>Di Sistem Peminjaman Kelas Universitas Sains dan Teknologi Indonesia.</p>
            </div>
        </div>

        <div class="form-section text-center">
            <h3>Peminjaman Kelas</h3>
            <p>Silakan masuk untuk melanjutkan</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3 text-start">
                    <label for="username" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control" id="username" name="username" value="admin" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select form-control" id="role" name="role">
                        <option>Pilih Role</option>
                        <option value="admin" selected>Admin</option> 
                        <option value="super user">Super User</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="mb-4 text-start">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>