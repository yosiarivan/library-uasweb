<?php
require_once '../config/dbcon.php';

// Memeriksa apakah permintaan POST memiliki parameter ID
if (isset($_POST['id'])) {
    $articleId = $_POST['id'];

    // Query untuk mendapatkan data admin berdasarkan ID
    $query = "SELECT * FROM article WHERE id = '$articleId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();

        // Mengembalikan data admin dalam format JSON
        $response = array(
            'status' => 'success',
            'article' => $article
        );
        echo json_encode($response);
    } else {
        // Jika tidak ada admin dengan ID yang diberikan
        $response = array(
            'status' => 'error',
            'message' => 'Article not found'
        );
        echo json_encode($response);
    }
} else {
    // Jika parameter ID tidak ada dalam permintaan POST
    $response = array(
        'status' => 'error',
        'message' => 'Missing ID parameter'
    );
    echo json_encode($response);
}

// Menutup koneksi database
$conn->close();
?>
