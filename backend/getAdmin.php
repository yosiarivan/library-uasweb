<?php
require_once '../config/dbcon.php';

// Memeriksa apakah permintaan POST memiliki parameter ID
if (isset($_POST['id'])) {
    $adminId = $_POST['id'];

    // Query untuk mendapatkan data admin berdasarkan ID
    $query = "SELECT * FROM admin WHERE id = '$adminId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Mengembalikan data admin dalam format JSON
        $response = array(
            'status' => 'success',
            'admin' => $admin
        );
        echo json_encode($response);
    } else {
        // Jika tidak ada admin dengan ID yang diberikan
        $response = array(
            'status' => 'error',
            'message' => 'Admin not found'
        );
        echo json_encode($response);
    }
} else {
    // Jika parameter ID tidak ada dalam permintaan POST
    $response = array(
        'status' => 'error',
        'message' => 'Missing ID parameter'
    );
    echo json_encode($response);
}

//412019030 Yosia
$conn->close();
?>
