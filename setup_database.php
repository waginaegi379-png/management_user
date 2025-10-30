<?php
// Koneksi ke MySQL (tanpa memilih database)
$koneksi = new mysqli("localhost", "root", "");
if ($koneksi->connect_error) {
    die("Koneksi ke MySQL gagal: " . $koneksi->connect_error);
}

$db_name = "usermngnt";

// 1. Buat database usermngnt jika belum ada
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($koneksi->query($sql_create_db)) {
    echo "Database '$db_name' berhasil dibuat atau sudah ada.<br>";
} else {
    die("Gagal membuat database: " . $koneksi->error);
}

// Pilih database
$koneksi->select_db($db_name);

// 2. Buat tabel users (disesuaikan dengan skema file Anda)
// Menggunakan 'username' untuk kolom login (yang di file Anda berisi email) dan 'status'
$sql_create_table_users = "
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE, 
  fullname VARCHAR(150),
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'user',
  activation_token VARCHAR(100) NULL,
  reset_token VARCHAR(100) NULL,
  reset_token_expires DATETIME NULL,
  status ENUM('active', 'inactive') DEFAULT 'inactive',
  reg_date DATETIME, /* Tambahan dari register.php */
  modified DATETIME, /* Tambahan dari register.php */
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

if ($koneksi->query($sql_create_table_users)) {
    echo "Tabel 'users' berhasil dibuat atau sudah ada.<br>";
} else {
    die("Gagal membuat tabel users: " . $koneksi->error);
}

// 3. Buat tabel products
$sql_create_table_products = "
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  created DATETIME DEFAULT CURRENT_TIMESTAMP
);
";

if ($koneksi->query($sql_create_table_products)) {
    echo "Tabel 'products' berhasil dibuat atau sudah ada.<br>";
} else {
    die("Gagal membuat tabel products: " . $koneksi->error);
}

// 4. Tambahkan 1 user admin contoh (agar bisa login)
$username_admin = "admin@gudang.com";
$password_admin = "admin123";
$hashed_pass = password_hash($password_admin, PASSWORD_DEFAULT);
$fullname_admin = "Administrator Gudang";
$role_admin = "AdminGudang";

$stmt_insert = $koneksi->prepare("INSERT IGNORE INTO users (username, fullname, password, role, status, reg_date, modified)
               VALUES (?, ?, ?, ?, 'active', NOW(), NOW())");
$stmt_insert->bind_param("ssss", $username_admin, $fullname_admin, $hashed_pass, $role_admin);

if ($stmt_insert->execute()) {
    echo "User contoh berhasil ditambahkan (Username: admin@gudang.com | Password: admin123).";
} else {
    echo "Gagal menambahkan user contoh (mungkin sudah ada): " . $koneksi->error;
}
$stmt_insert->close();
$koneksi->close();
?>