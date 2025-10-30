<?php
require 'connect.php';

if (!isset($_GET['token'])) {
    die("Token tidak ditemukan.");
}

$token = $_GET['token'];
$now = date("Y-m-d H:i:s");

// Cek token dan waktu kedaluwarsa
$stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expires > ?");
$stmt->bind_param("ss", $token, $now);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("<p style='color:red;'>Token tidak valid atau sudah kedaluwarsa.</p>");
}

$user = $result->fetch_assoc();
$user_id = $user['id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password dan hapus token
    $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
    $update_stmt->bind_param("si", $hashed_password, $user_id);

    if ($update_stmt->execute()) {
        $message = "<p style='color:green;'>Password berhasil diubah! Silakan <a href='login.php'>login</a>.</p>";
    } else {
        $message = "<p style='color:red;'>Gagal mengubah password.</p>";
    }
    $update_stmt->close();
}
?>

<h2>Reset Password</h2>
<?= $message; ?>
<?php if (empty($message)): ?>
    <form method="POST">
        Password Baru: <input type="password" name="new_password" required><br><br>
        <button type="submit">Ubah Password</button>
    </form>
<?php endif; ?>