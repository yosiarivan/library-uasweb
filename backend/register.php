<?php
require_once '../config/dbcon.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Generate nomor karyawan acak sepanjang 5 digit
$noKaryawan = rand(1000, 9999);

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Proses registrasi pengguna
$sql = "INSERT INTO admin (no_karyawan, name, email, password) VALUES ('$noKaryawan', '$name', '$email', '$hashedPassword')";
if ($conn->query($sql) === TRUE) {
    $response = array('success' => true);
} else {
    $response = array('success' => false, 'message' => 'Registration failed. Please try again.');
}

// Menutup koneksi dan mengirim response ke JavaScript
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
