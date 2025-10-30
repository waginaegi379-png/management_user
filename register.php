<?php
require 'connect.php'; 
// Tambahkan require functions.php karena Anda menggunakan bin2hex(random_bytes)
require 'functions.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']); // Input form email
    $fullname = trim($_POST['fullname']); // Input form nama lengkap
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $default_role = 'user'; 
    $default_status = 'inactive'; 
    
    // Generate token menggunakan fungsi generateToken dari functions.php atau random_bytes
    $token = generateToken(); // Asumsi functions.php memiliki generateToken()

    // 1. Cek apakah email sudah digunakan
    $check_stmt = $conn->prepare("SELECT id FROM user WHERE username = ?"); 
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "<p class='error message'>Email sudah digunakan!</p>";
        $check_stmt->close();
    } else {
        // 2. Insert user baru: Kolom disinkronkan dengan skema baru (user, username, fullname, role, status)
        $sql = "INSERT INTO user (username, password, fullname, role, status, reg_date, modified, activation_token)
                VALUES (?, ?, ?, ?, ?, NOW(), NOW(), ?)";
        
        $insert_stmt = $conn->prepare($sql);
        // Bind parameter: ssssss = username(email), password, fullname, role, status, activation_token
        $insert_stmt->bind_param("ssssss", $email, $password, $fullname, $default_role, $default_status, $token);
        
        if ($insert_stmt->execute()) {
            $_SESSION['activation_token'] = $token;
            header("Location: register_success.php");
            exit;
        } else {
            $message = "<p class='error message'>Terjadi kesalahan saat registrasi: " . $insert_stmt->error . "</p>";
        }
        $insert_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h2>Registrasi Pengguna</h2>
    <form method="POST">
        <label for="fullname">Nama Lengkap:</label>
        <input type="text" id="fullname" name="fullname" required value="<?= isset($fullname) ? htmlspecialchars($fullname) : '' ?>">
        
        <label for="email">Email (Login):</label>
        <input type="email" id="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Daftar</button>
    </form>

    <?= $message ?>
    <p><a href="login.php">Sudah punya akun? Login</a></p>
</div>
</body>
</html>