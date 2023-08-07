<?php
require_once '../config/dbcon.php';

// Memeriksa apakah permintaan POST memiliki parameter yang diperlukan
if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['genre']) && isset($_POST['year']) && isset($_POST['status'])) {
    $bookId = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $status = $_POST['status'];

// Mengupload gambar jika ada
if ($_FILES['img']['size'] > 0) {
    $image = $_FILES['img'];
    $imageName = uniqid() . '_' . $image['name']; // Menambahkan string unik pada nama file
    $imageTmpName = $image['tmp_name'];
    $imagePath = '../img/src/' . $imageName;
    move_uploaded_file($imageTmpName, $imagePath);

    // Query untuk mengupdate data buku dengan gambar baru
    $query = "UPDATE book SET img = '$imageName', title = '$title', author = '$author', genre = '$genre', year = '$year', status = '$status' WHERE id = '$bookId'";
} else {
    // Query untuk mengupdate data buku tanpa mengganti gambar
    $query = "UPDATE book SET title = '$title', author = '$author', genre = '$genre', year = '$year', status = '$status' WHERE id = '$bookId'";
}


    $result = $conn->query($query);

    if ($result) {
        // Jika update berhasil
        $response = array(
            'status' => 'success',
            'message' => 'Book data updated successfully'
        );
        echo json_encode($response);
    } else {
        // Jika update gagal
        $response = array(
            'status' => 'error',
            'message' => 'Failed to update book data'
        );
        echo json_encode($response);
    }
} else {
    // Jika parameter yang diperlukan tidak ada dalam permintaan POST
    $response = array(
        'status' => 'error',
        'message' => 'Missing required parameters'
    );
    echo json_encode($response);
}

// Menutup koneksi database
$conn->close();
?>
