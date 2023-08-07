<?php
// Melakukan koneksi ke database
require_once '../config/dbcon.php';

// Query untuk mengambil data buku terbaru

$query = "SELECT * FROM book ORDER BY id DESC LIMIT 3";


// Eksekusi query

$result = mysqli_query($conn, $query);

// Mengambil hasil query sebagai array assosiatif

$books = array();

while ($row = mysqli_fetch_assoc($result)) {
  $books[] = $row;
}

// Menutup koneksi database

mysqli_close($conn);

// Mengirimkan hasil sebagai respons JSON

header('Content-Type: application/json');
echo json_encode($books);
?>
