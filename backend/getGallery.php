<?php
// Koneksi ke database
require_once '../config/dbcon.php';

// Query untuk mengambil data gambar dari database
$query = "SELECT * FROM gallery";
$result = mysqli_query($conn, $query);

$response = array();

if (mysqli_num_rows($result) > 0) {
    $galleryData = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $galleryData[] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'image_url' => $row['image_url']
        );
    }

    $response['status'] = 'success';
    $response['data'] = $galleryData;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Tidak ada data gambar.';
}

// Mengeluarkan respons JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi database
mysqli_close($conn);
?>