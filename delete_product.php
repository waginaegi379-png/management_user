<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus produk berdasarkan ID dengan prepared statement
    $delete_stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete_stmt->bind_param("i", $id);

    if ($delete_stmt->execute()) {
        $delete_stmt->close();
        // Redirect ke halaman dashboard setelah berhasil menghapus produk
        header("Location: dashboard.php");
        exit;
    } else {
        $delete_stmt->close();
        echo "<p>Terjadi kesalahan saat menghapus produk: " . $conn->error . "</p>";
    }
} else {
    echo "<p>ID Produk tidak ditemukan atau tidak valid.</p>";
}
?>