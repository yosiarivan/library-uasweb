<?php
// Melakukan koneksi ke database
require_once '../config/dbcon.php';

// Mendapatkan data buku berdasarkan pencarian
$searchTerm = $_GET['search'];

$sql = "SELECT * FROM book";
if (!empty($searchTerm)) {
    $sql .= " WHERE title LIKE '%" . $searchTerm . "%'";
}

$result = $conn->query($sql);

$book = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $book = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'author' => $row['author'],
            'genre' => $row['genre'],
            'year' => $row['year'],
            'status' => $row['status'],
            'image' => $row['image']
        );
        $book[] = $book;
    }
}

// Mengirimkan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($book);

$conn->close();
?>