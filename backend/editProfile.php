<?php
require_once '../config/dbcon.php';

// Memeriksa apakah permintaan POST memiliki parameter yang diperlukan
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
    $adminId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Mengupload gambar jika ada
    if ($_FILES['image']['size'] > 0) {
        $image = $_FILES['image'];
        $imageName = uniqid() . '_' . $image['name']; // Menambahkan string unik pada nama file
        $imageTmpName = $image['tmp_name'];
        $imagePath = '../img/src/' . $imageName;
        move_uploaded_file($imageTmpName, $imagePath);

        // Query untuk mengupdate data admin dengan gambar baru
        $query = "UPDATE admin SET image = '$imageName', name = '$name', email = '$email' WHERE id = '$adminId'";
    } else {
        // Query untuk mengupdate data admin tanpa mengganti gambar
        $query = "UPDATE admin SET name = '$name', email = '$email' WHERE id = '$adminId'";
    }

    $result = $conn->query($query);

    if ($result) {
        // Jika update berhasil

        // Select data admin dari tabel setelah diupdate
        $selectQuery = "SELECT * FROM admin WHERE id = '$adminId'";
        $selectResult = $conn->query($selectQuery);
        if ($selectResult && $selectResult->num_rows > 0) {
            $adminData = $selectResult->fetch_assoc();

            // Menyimpan data admin dalam session
            session_start();
            // Login berhasil, lakukan tindakan yang diperlukan
            // Contoh: Menyimpan data admin di session
            $_SESSION['admin_id'] = $adminData['id'];
            $_SESSION['admin_name'] = $adminData['name'];
            $_SESSION['admin_email'] = $adminData['email'];
            $_SESSION['admin_no_karyawan'] = $adminData['no_karyawan'];
            $_SESSION['admin_role_id'] = $adminData['role_id'];
            $_SESSION['admin_image'] = $adminData['image'];

        }

        $response = array(
            'status' => 'success',
            'message' => 'Admin data updated successfully'
        );
    } else {
        // Jika update gagal
        $response = array(
            'status' => 'error',
            'message' => 'Failed to update admin data'
        );
    }
} else {
    // Jika parameter yang diperlukan tidak ada dalam permintaan POST
    $response = array(
        'status' => 'error',
        'message' => 'Missing required parameters'
    );
}

// Mengeluarkan respons JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi database
$conn->close();
?>