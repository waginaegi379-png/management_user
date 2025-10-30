<?php
require 'connect.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // 1. Ambil password lama
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();

    if (password_verify($old_password, $user_data['password'])) {
        // 2. Update password baru
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_password_hash, $user_id);

        if ($update_stmt->execute()) {
            $message = "<p style='color:green;'>Password berhasil diperbarui!</p>";
        } else {
            $message = "<p style='color:red;'>Terjadi kesalahan saat memperbarui password.</p>";
        }
        $update_stmt->close();
    } else {
        $message = "<p style='color:red;'>Password lama tidak sesuai.</p>";
    }
}
?>

<h2>Ubah Password</h2>
<?= $message; ?>
<form method="POST">
    Password Lama: <input type="password" name="old_password" required><br><br>
    Password Baru: <input type="password" name="new_password" required><br><br>
    <button type="submit">Ubah Password</button>
</form>