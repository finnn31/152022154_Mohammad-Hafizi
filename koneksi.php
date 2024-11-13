<?php
// config/db.php

$host = 'localhost';  // Server database (localhost untuk server lokal)
$dbname = 'iot'; // Nama database
$username = 'root';   // Username MySQL (root adalah default untuk server lokal)
$password = '';       // Password MySQL (kosong di XAMPP, isi sesuai server Anda)

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
