<?php
// Koneksi ke database dan lakukan query untuk mendapatkan total data
require_once '../config/dbcon.php';

// Mengambil data dari tabel contact_messages
$sql = "SELECT * FROM contact_us ORDER BY created_at DESC";
$result = $conn->query($sql);

$messages = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Menutup koneksi
$conn->close();

// Mengembalikan data sebagai respons JSON
header('Content-Type: application/json');
echo json_encode($messages);
?>