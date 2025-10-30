<?php
// File: activate.php - DENGAN PREPARED STATEMENT DAN STRUKTUR HTML
require 'connect.php';

$message = '';
$message_class = 'error';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $status_inactive = 'inactive';
    $status_active = 'active';

    // 1. Cek token dan status menggunakan Prepared Statement
    // Perhatian: Penggunaan SELECT * tanpa LIMIT 1 di sini tidak ideal, tapi ini hanya untuk contoh.
    $stmt_select = $conn->prepare("SELECT id FROM user WHERE activation_token = ? AND status = ?");
    $stmt_select->bind_param("ss", $token, $status_inactive);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // 2. Aktifkan akun dan hapus token
        $stmt_update = $conn->prepare("UPDATE user SET status = ?, activation_token = NULL, modified = NOW() WHERE id = ?");
        $stmt_update->bind_param("si", $status_active, $user['id']);
        
        if ($stmt_update->execute()) {
             $message = "Akun berhasil diaktivasi! Silakan <a href='login.php'>login</a>.";
             $message_class = 'success';
        } else {
            $message = "Terjadi kesalahan saat aktivasi akun.";
            $message_class = 'error';
        }
        $stmt_update->close();
        
    } else {
        $message = "Token tidak valid, sudah kedaluwarsa, atau akun sudah aktif.";
        $message_class = 'error';
    }
    $stmt_select->close();
    
} else {
    $message = "Token aktivasi tidak ditemukan.";
    $message_class = 'error';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="auth-container">
        <h2>Status Aktivasi</h2>
        <!-- Menampilkan pesan dengan class CSS yang sesuai -->
        <p class="<?= $message_class ?> message"><?= $message ?></p>
    </div>
</body>
</html>
