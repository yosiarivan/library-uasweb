<?php
// Melakukan koneksi ke database
require_once '../config/dbcon.php';

// Mendapatkan ID artikel dari parameter URL
$articleID = $_GET['id'];

// Query untuk mengambil data artikel berdasarkan ID
$query = "SELECT * FROM article WHERE id = '$articleID'";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Mendapatkan hasil query sebagai array associative
$article = mysqli_fetch_assoc($result);

// Menutup koneksi database
mysqli_close($conn);

// Mengirimkan hasil sebagai respons JSON
header('Content-Type: application/json');
echo json_encode($article);
?>
