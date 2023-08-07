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
$author = $_POST['author'];
$title = $_POST['title'];
$content = $_POST['content'];

// Mengupload gambar
$targetDir = "../img/src/";
$fileName = uniqid() . '_' .  $_FILES['image']['name'];
$targetFilePath = $targetDir . $fileName;
move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

// Menyimpan data ke dalam database
$sql = "INSERT INTO article (title, author, content, image)
        VALUES ('$title', '$author', '$content', '$fileName')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan!";
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>