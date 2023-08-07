<?php
// Melakukan koneksi ke database
require_once '../config/dbcon.php';

// Mengambil semua data dari tabel artikel
$sql = "SELECT * FROM article ORDER BY id DESC LIMIT 2";
$result = $conn->query($sql);

// Menyimpan data artikel ke dalam array
$articles = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $article = array(
            "id" => $row["id"],
            "image" => $row["image"],
            "title" => $row["title"],
            "content" => $row["content"],
        );
        array_push($articles, $article);
    }
}

// Membuat respons dalam format yang diharapkan
$response = array(
    "status" => "success",
    "data" => $articles
);

// Mengirim data artikel sebagai respons JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi ke database
$conn->close();
?>