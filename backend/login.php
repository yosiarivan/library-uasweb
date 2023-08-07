<?php
session_start();

require_once '../config/dbcon.php';

$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']);

// Query untuk mencari admin berdasarkan email
$query = "SELECT * FROM admin WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $admin = $result->fetch_assoc();

    // Periksa kecocokan password
    if (password_verify($password, $admin['password'])) {
        // Login berhasil, lakukan tindakan yang diperlukan
        // Contoh: Menyimpan data admin di session
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_no_karyawan'] = $admin['no_karyawan'];
        $_SESSION['admin_role_id'] = $admin['role_id'];
        $_SESSION['admin_image'] = $admin['image'];

        // Catat waktu login pada kolom "access_at"
        $accessTime = date('Y-m-d H:i:s');
        $updateQuery = "UPDATE admin SET access_at = '$accessTime' WHERE id = " . $admin['id'];
        $conn->query($updateQuery);

        $response = array(
            'success' => true,
            'message' => 'Login berhasil.'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Password salah.'
        );
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'Email tidak ditemukan.'
    );
}

echo json_encode($response);
$conn->close();
exit();
?>
