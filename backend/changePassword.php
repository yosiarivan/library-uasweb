<?php
// Koneksi ke database
require_once '../config/dbcon.php';

// Mengambil data dari permintaan AJAX
$userId = $_POST['userId'];
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];

// Mengambil password pengguna dari database
$sql = "SELECT password FROM admin WHERE id = '$userId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

    // Memeriksa kecocokan password saat ini
    if (password_verify($currentPassword, $storedPassword)) {
        // Mengenkripsi password baru sebelum menyimpannya di database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Memperbarui password di database
        $updateSql = "UPDATE admin SET password = '$hashedPassword' WHERE id = '$userId'";
        if ($conn->query($updateSql) === TRUE) {
            // Mengirim respons ke AJAX dengan status sukses
            $response = array('success' => true);
        } else {
            // Mengirim respons ke AJAX dengan pesan error
            $response = array('success' => false, 'message' => 'Error updating password');
        }
    } else {
        // Mengirim respons ke AJAX dengan pesan error
        $response = array('success' => false, 'message' => 'Invalid current password');
    }
} else {
    // Mengirim respons ke AJAX dengan pesan error
    $response = array('success' => false, 'message' => 'User not found');
}

// Mengembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>