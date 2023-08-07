<?php
// Koneksi ke database dan lakukan query untuk mendapatkan total data
require_once '../config/dbcon.php';

// Menerima data dari permintaan AJAX
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Memasukkan data ke tabel contact_messages
$sql = "INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$name, $email, $message]);

// Mengembalikan respon dalam bentuk JSON
$response = ['success' => true, 'message' => 'Data has been successfully saved.'];
echo json_encode($response);
?>