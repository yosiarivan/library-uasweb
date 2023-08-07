<?php
require_once '../config/dbcon.php';

// Memeriksa apakah permintaan POST memiliki parameter yang diperlukan
if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content'])) {
    $articleId = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

// Mengupload gambar jika ada
if ($_FILES['image']['size'] > 0) {
    $image = $_FILES['image'];
    $imageName = uniqid() . '_' . $image['name']; // Menambahkan string unik pada nama file
    $imageTmpName = $image['tmp_name'];
    $imagePath = '../img/src/' . $imageName;
    move_uploaded_file($imageTmpName, $imagePath);

    // Query untuk mengupdate data buku dengan gambar baru
    $query = "UPDATE article SET image = '$imageName', title = '$title', content = '$content', edited_date = NOW() WHERE id = '$articleId'";
} else {
    // Query untuk mengupdate data buku tanpa mengganti gambar
    $query = "UPDATE article SET title = '$title', content = '$content', edited_date = NOW() WHERE id = '$articleId'";
}


    $result = $conn->query($query);

    if ($result) {
        // Jika update berhasil
        $response = array(
            'status' => 'success',
            'message' => 'Article data updated successfully'
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
