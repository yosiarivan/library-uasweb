<?php
// Koneksi ke database
require_once '../config/dbcon.php';

// Periksa apakah ID admin telah diterima
if (isset($_POST['id'])) {
    $article_id = $_POST['id'];

    // Query untuk menghapus data admin berdasarkan ID
    $query = "DELETE FROM article WHERE id = '$article_id'";
    $result = $conn->query($query);

    if ($result) {
        // Jika penghapusan berhasil, kirim respons sukses
        $response = array('status' => 'success', 'message' => 'Data article berhasil dihapus');
    } else {
        // Jika penghapusan gagal, kirim respons error
        $response = array('status' => 'error', 'message' => 'Gagal menghapus data article');
    }
} else {
    // Jika ID admin tidak diterima, kirim respons error
    $response = array('status' => 'error', 'message' => 'ID article tidak ditemukan');
}

// Mengembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>