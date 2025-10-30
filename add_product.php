<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Prepared statement untuk mencegah SQL Injection
    $insert_stmt = $conn->prepare("INSERT INTO products (name, description, created) VALUES (?, ?, NOW())");
    $insert_stmt->bind_param("ss", $name, $description);

    if ($insert_stmt->execute()) {
        $message = "<p style='color:green;'>Produk berhasil ditambahkan!</p>";
    } else {
        $message = "<p style='color:red;'>Terjadi kesalahan saat menambahkan produk: " . $conn->error . "</p>";
    }
    $insert_stmt->close();
}
?>

<h2>Tambah Produk</h2>
<?= $message; ?>
<form method="POST">
    Nama Produk: <input type="text" name="name" required><br><br>
    Deskripsi Produk: <textarea name="description" required></textarea><br><br>
    <button type="submit">Tambah Produk</button>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>
</form>