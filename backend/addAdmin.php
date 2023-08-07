<?php
// Koneksi ke database dan lakukan query untuk mendapatkan total data
require_once '../config/dbcon.php';

// Ambil data dari form
$noKaryawan = $_POST['noKaryawan'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Proses tambah data ke database
$sql = "INSERT INTO admin (no_karyawan, name, email, password) VALUES ('$noKaryawan', '$name', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
  $response = array('success' => true);
} else {
  $response = array('success' => false);
}

// Menutup koneksi dan mengirim response ke JavaScript
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>