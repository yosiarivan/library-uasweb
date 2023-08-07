<?php
require_once '../config/dbcon.php';

// Memeriksa apakah permintaan POST memiliki parameter yang diperlukan
if (isset($_POST['id']) && isset($_POST['no_karyawan']) && isset($_POST['name']) && isset($_POST['email'])) {
    $adminId = $_POST['id'];
    $noKaryawan = $_POST['no_karyawan'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role_id = $_POST['role'];

    // Query untuk mengupdate data admin
    $query = "UPDATE admin SET no_karyawan = '$noKaryawan', name = '$name', email = '$email', role_id = '$role_id' WHERE id = '$adminId'";
    $result = $conn->query($query);

    if ($result) {
        // Jika update berhasil
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
$conn->close();
?>