<?php
require 'connect.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data profil pengguna
$stmt = $conn->prepare("SELECT username, fullname, role, status, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

if (!$user_data) {
    // Seharusnya tidak terjadi jika user_id ada di sesi
    header("Location: logout.php"); 
    exit;
}
?>

<h2>Profil Saya</h2>
<p>
    <b>Username:</b> <?= htmlspecialchars($user_data['username']); ?><br>
    <b>Nama Lengkap:</b> <?= htmlspecialchars($user_data['fullname']); ?><br>
    <b>Peran (Role):</b> <?= htmlspecialchars($user_data['role']); ?><br>
    <b>Status Akun:</b> <?= htmlspecialchars($user_data['status']); ?><br>
    <b>Bergabung Sejak:</b> <?= htmlspecialchars($user_data['created_at']); ?><br>
</p>
<p><a href="dashboard.php">Kembali ke Dashboard</a></p>