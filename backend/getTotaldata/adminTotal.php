<?php
// Koneksi ke database dan lakukan query untuk mendapatkan total data
$serverName = "localhost";
$username = "root";
$password = "";
$database = "20222_wp2_412019030";

// Membuat Koneksi
$conn = new mysqli($serverName, $username, $password, $database);

if ($conn->connect_error) {
    die("Konkesi Error: " . $conn->connect_error);
}

$query = "SELECT COUNT(*) AS total FROM admin";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row['total'];

    // Mengirim total data sebagai respons JSON
    echo json_encode(['total' => $total]);
} else {
    echo json_encode(['total' => 0]);
}

$conn->close();
?>