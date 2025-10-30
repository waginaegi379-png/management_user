<?php
// File: connect.php
// Pastikan nama database sinkron dengan file 'createtable.php'

// Cegah session_start() ganda
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "usermngnt"; // <-- DATABASE YANG BENAR

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, mungkin database belum dibuat.
    // Error ini biasanya muncul sebelum error 'Table doesn't exist'.
    die("Koneksi gagal: " . $conn->connect_error);
}
?>