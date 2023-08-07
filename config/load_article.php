<?php
require_once '../config/dbcon.php';

$query = "SELECT * FROM article "; // Mengambil 5 artikel terbaru
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $articles = array();

    while ($row = $result->fetch_assoc()) {
        $article = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'content' => $row['content'],
            'image' => $row['image']
        );

        $articles[] = $article;
    }

    // Mengeluarkan data artikel dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($articles);
} else {
    // Jika tidak ada artikel ditemukan
    $response = array(
        'status' => 'error',
        'message' => 'No articles found'
    );

    // Mengeluarkan pesan error dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Menutup koneksi database
$conn->close();
?>