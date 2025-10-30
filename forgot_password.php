<?php
require 'connect.php';
// Asumsi functions.php sudah di-require atau fungsinya generateToken ada

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // 1. Cek email terdaftar (MENGGUNAKAN KOLOM EMAIL)
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND is_active = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Generate token reset dan waktu kedaluwarsa 1 jam
        $token = bin2hex(random_bytes(32)); 
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
        // 2. Simpan token dan waktu kedaluwarsa (Prepared Statement)
        $update_stmt = $conn->prepare("UPDATE users SET reset_code = ?, reset_code_expires = ? WHERE id = ?");
        // reset_code_expires adalah kolom baru yang saya asumsikan untuk reset code
        $update_stmt->bind_param("ssi", $token, $expiry, $user['id']); 

        if ($update_stmt->execute()) {
            $_SESSION['reset_token'] = $token; // Simpan token untuk forgot_success.php
            header("Location: forgot_success.php");
            exit;
        } else {
             $message = "<p class='error message'>Terjadi kesalahan saat menyimpan token.</p>";
        }
        $update_stmt->close();
    } else {
        $message = "<p class='error message'>Email tidak ditemukan atau akun belum aktif!</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h2>Lupa Password</h2>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Kirim Link Reset</button>
    </form>
    <?= $message ?>
    <p><a href="login.php">Kembali ke Login</a></p>
</div>
</body>
</html>