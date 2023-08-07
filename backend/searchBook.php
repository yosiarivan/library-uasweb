<?php
// Koneksi ke database dan lakukan query untuk mendapatkan total data
require_once '../config/dbcon.php';


// Ambil nilai pencarian dari parameter "q"
$searchQuery = $_GET['q'];

// Lakukan pencarian di tabel "admin" dengan kolom "name" dan "email"
$sql = "SELECT * FROM book WHERE id LIKE '%" . $searchQuery . "%' OR title LIKE '%" . $searchQuery . "%'";
$result = $conn->query($sql);

$searchResults = array();

if ($result->num_rows > 0) {
    // Loop melalui hasil pencarian dan tambahkan ke array searchResults
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
}

// Mengembalikan hasil pencarian dalam format JSON
echo json_encode($searchResults);

$conn->close();
?>
