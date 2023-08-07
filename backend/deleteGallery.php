<?php
// Koneksi ke database
require_once '../config/dbcon.php';

// Proses hapus data
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageId = $_POST['id'];

    // Menghapus data gambar dari database
    $deleteQuery = "DELETE FROM gallery WHERE id = $imageId";
    if (mysqli_query($conn, $deleteQuery)) {
        $response['status'] = 'success';
        $response['message'] = 'Data gambar berhasil dihapus';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Terjadi kesalahan saat menghapus data gambar dari database: ' . mysqli_error($conn);
    }

    // Menutup koneksi database
    mysqli_close($conn);
}

// Mengeluarkan respons JSON
header('Content-Type: application/json');
echo json_encode($response);
?>