<?php
require_once '../config/dbcon.php';

// Memeriksa apakah permintaan POST memiliki parameter ID
if (isset($_POST['id'])) {
    $bookId = $_POST['id'];

    // Query untuk mendapatkan data buku berdasarkan ID
    $query = "SELECT * FROM book WHERE id = '$bookId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();

        // Mengembalikan data buku dalam format JSON
        $response = array(
            'status' => 'success',
            'book' => $book
        );
        echo json_encode($response);
    } else {
        // Jika tidak ada buku dengan ID yang diberikan
        $response = array(
            'status' => 'error',
            'message' => 'Book not found'
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