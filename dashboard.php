<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];  // Menyimpan username atau ID pengguna

// Ambil data profil pengguna
// PENTING: Sebaiknya gunakan Prepared Statement untuk keamanan
$result = $conn->query("SELECT * FROM user WHERE username='$user'");
$user_data = $result->fetch_assoc();

// Ambil data produk
// BARIS INI YANG DIPERBAIKI (MENGGANTI created_at DENGAN created)
$product_result = $conn->query("SELECT * FROM products ORDER BY created DESC"); 

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Gudang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Dashboard Admin Gudang</h2>
    <p>Selamat datang, <b><?= htmlspecialchars($user_data['fullname']); ?></b> (<?= htmlspecialchars($user_data['role']); ?>)</p>

    <p><a href="profile.php">Profil Saya</a> | <a href="change_password.php">Ubah Password</a> | <a href="logout.php">Logout</a></p>

    <h3>Data Produk</h3>
    <a href="add_product.php">Tambah Produk</a>
    <?php if ($product_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $product_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $product['id']; ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= htmlspecialchars($product['description']); ?></td>
                        <td><?= $product['created']; ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id']; ?>">Edit</a> |
                            <a href="delete_product.php?id=<?= $product['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Belum ada produk yang ditambahkan.</p>
    <?php endif; ?>
</body>
</html>