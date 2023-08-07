<?php
$serverName = "localhost";
$username = "root";
$password = "";
// Change the name of database to yours
$database = "20222_wp2_412019030";

// Membuat Koneksi
$conn = new mysqli($serverName, $username, $password, $database);

if ($conn->connect_error) {
    die("Konkesi Error: " . $conn->connect_error);
}

// Menerima data dari formulir
$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$year = $_POST['year'];
$status = $_POST['status'];

// Mengupload gambar
$targetDir = "../img/src/";
$fileName = uniqid() . '_' .  $_FILES['image']['name'];
$targetFilePath = $targetDir . $fileName;
move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

// Menyimpan data ke dalam database
$sql = "INSERT INTO book (title, author, genre, year, status, img)
        VALUES ('$title', '$author', '$genre', '$year', '$status', '$fileName')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan!";
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>