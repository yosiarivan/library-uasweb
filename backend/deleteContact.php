<?php

require_once '../config/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the contact ID to delete
    $id = $_POST['id'];

    // Code to delete the contact from the database based on the ID
    $sql = "DELETE FROM contact_us WHERE id = $id";
    $result = $conn->query($sql);

    // Determine the response message
    $response = array();
    if ($result) {
        $response['success'] = true;
        $response['message'] = "Contact has been deleted successfully.";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to delete contact.";
    }

    // Return the response in JSON format
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>