<?php
// File: register_success.php
// HARUS ditempatkan di D:\xampp\htdocs\management_user\

// Pastikan sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah ada token aktivasi di session setelah berhasil register
if (isset($_SESSION['activation_token'])) {
    $token = $_SESSION['activation_token'];
    
    // Hapus token dari session agar tidak dapat digunakan lagi jika halaman direfresh
    unset($_SESSION['activation_token']);
    
    $message = "<p class='success message'>Registrasi berhasil!</p>";
    $message .= "<p>Silakan klik tautan di bawah untuk mengaktifkan akun Anda:</p>";
    $message .= "<p><a href='activate.php?token=$token'>Aktifkan Akun Sekarang</a></p>";
    $message .= "<p>Setelah aktivasi, Anda bisa <a href='login.php'>login</a>.</p>";
} else {
    // Jika user mengakses halaman ini tanpa melalui proses register, kembalikan ke login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Sukses</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Gaya dasar untuk konsistensi */
        .container {
            width: 400px;
            background: #fff;
            margin: 50px auto;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success.message {
            background: #c6f6d5;
            color: #22543d;
            padding: 10px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrasi Berhasil! </h2>
        <?= $message ?>
    </div>
</body>
</html>