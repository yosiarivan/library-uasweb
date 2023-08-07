<?php
// Koneksi ke database
require_once '../config/dbcon.php';

// Periksa apakah ID admin telah diterima
if (isset($_POST['id'])) {
    $admin_id = $_POST['id'];

    // Query untuk menghapus data admin berdasarkan ID
    $query = "DELETE FROM admin WHERE id = '$admin_id'";
    $result = $conn->query($query);

    if ($result) {
        // Jika penghapusan berhasil, kirim respons sukses
        $response = array('status' => 'success', 'message' => 'Data admin berhasil dihapus');
    } else {
        // Jika penghapusan gagal, kirim respons error
        $response = array('status' => 'error', 'message' => 'Gagal menghapus data admin');
    }
} else {
    // Jika ID admin tidak diterima, kirim respons error
    $response = array('status' => 'error', 'message' => 'ID admin tidak ditemukan');
}

// Mengembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
