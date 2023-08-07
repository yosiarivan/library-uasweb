<?php
$serverName = "localhost";
$username = "root";
$password = "";
$database = "20222_wp2_412019030";

$conn = new mysqli($serverName, $username, $password, $database);

if ($conn->connect_error) {
    die("Konkesi Error: " . $conn->connect_error);
}

?>