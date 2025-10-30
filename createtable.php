<?php
// File: createtable.php - (FINAL SKEMA KONSISTEN)

// Koneksi ke MySQL (tanpa memilih database dulu)
$koneksi = mysqli_connect("localhost", "root", ""); 
if (!$koneksi) {
    die("Koneksi ke MySQL gagal: " . mysqli_connect_error());
}

$db_name = "usermngnt";

// 1. Buat database usermngnt
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $db_name";
if (!mysqli_query($koneksi, $sql_create_db)) {
    die("Gagal membuat database: " . mysqli_error($koneksi));
}

// Pilih database
mysqli_select_db($koneksi, $db_name);

// 2. Buat tabel user (Singular, sesuai kebutuhan register.php, login.php, dll.)
$sql_create_table = "
CREATE TABLE IF NOT EXISTS user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE, /* Digunakan sebagai Email Login */
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'user', /* Ada di login.php, dashboard.php, dll */
  activation_token VARCHAR(100) NULL,
  reset_token VARCHAR(100) NULL, 
  reset_token_expires DATETIME NULL, 
  status VARCHAR(10) DEFAULT 'inactive', /* Ada di login.php dan activate.php */
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
);
";

if (!mysqli_query($koneksi, $sql_create_table)) {
    die("Gagal membuat tabel user: " . mysqli_error($koneksi));
} else {
    echo "Tabel 'user' berhasil dibuat.<br>";
}

// 3. Tambahkan 1 user admin contoh (JIKA ANDA INGIN LANGSUNG LOGIN)
$email_admin = "admin@gudang.com";
$password_admin = "admin123";
$hashed_pass = password_hash($password_admin, PASSWORD_DEFAULT);
$name_admin = "Administrator Gudang";
$role_admin = "admin"; 
$status_admin = "active"; 

$stmt_insert = $koneksi->prepare("INSERT IGNORE INTO user (username, password, fullname, role, status)
               VALUES (?, ?, ?, ?, ?)");
$stmt_insert->bind_param("sssss", $email_admin, $hashed_pass, $name_admin, $role_admin, $status_admin);

if ($stmt_insert->execute()) {
    echo "User admin contoh berhasil ditambahkan (Email: admin@gudang.com | Password: admin123).";
} else {
    echo "Gagal menambahkan user contoh: " . $stmt_insert->error;
}
$stmt_insert->close();
mysqli_close($koneksi);
?>