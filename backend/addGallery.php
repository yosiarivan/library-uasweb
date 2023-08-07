<?php
// Koneksi ke database dan lakukan query untuk mendapatkan total data
require_once '../config/dbcon.php';
// Proses tambah data
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];

    // Mengambil informasi file
    $imageFile = $_FILES['imageFile'];
    $imageName = $imageFile['name'];
    $imageTmpName = $imageFile['tmp_name'];
    $imageSize = $imageFile['size'];
    $imageError = $imageFile['error'];

    // Generate nama file acak
    $randomName = uniqid();
    $fileExtension = pathinfo($imageName, PATHINFO_EXTENSION);
    $newFileName = $randomName . '.' . $fileExtension;

    // Cek apakah file berhasil diunggah
    if ($imageError === UPLOAD_ERR_OK) {
        // Memindahkan file ke direktori tujuan
        $uploadDir = '../img/src/';
        $imagePath = $newFileName;
        if (move_uploaded_file($imageTmpName, $uploadDir . $newFileName)) {
            // Menyimpan data gambar ke dalam database
            $query = "INSERT INTO gallery (title, image_url) VALUES ('$title', '$imagePath')";
            if (mysqli_query($conn, $query)) {
                $response['status'] = 'success';
                $response['message'] = 'Data berhasil ditambahkan ke database';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Terjadi kesalahan saat menambahkan data ke database: ' . mysqli_error($conn);
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal memindahkan file gambar';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Terjadi kesalahan saat mengunggah file gambar';
    }

    // Menutup koneksi database
    mysqli_close($conn);
}

// Mengeluarkan respons JSON
header('Content-Type: application/json');
echo json_encode($response);
?>