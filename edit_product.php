<?php
require 'connect.php';


// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID produk tidak valid.");
}

$id = $_GET['id'];
$message = "";

// 1. Ambil data produk berdasarkan ID
$stmt = $conn->prepare("SELECT name, description FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Produk tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // 2. Update produk menggunakan prepared statement
    $update_stmt = $conn->prepare("UPDATE products SET name = ?, description = ? WHERE id = ?");
    $update_stmt->bind_param("ssi", $name, $description, $id);

    if ($update_stmt->execute()) {
        $message = "<p style='color:green;'>Produk berhasil diperbarui!</p>";
        // Update data $product untuk menampilkan data terbaru di form
        $product['name'] = $name;
        $product['description'] = $description;
    } else {
        $message = "<p style='color:red;'>Terjadi kesalahan saat memperbarui produk: " . $conn->error . "</p>";
    }
    $update_stmt->close();
}
?>

<h2>Edit Produk</h2>
<?= $message; ?>
<form method="POST">
    Nama Produk: <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required><br><br>
    Deskripsi Produk: <textarea name="description" required><?= htmlspecialchars($product['description']); ?></textarea><br><br>
    <button type="submit">Perbarui Produk</button>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>
</form>