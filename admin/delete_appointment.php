<?php
include '../db_conn.php';

// Check if appointment ID is provided via POST
if (isset($_POST['id'])) {
    // Sanitize the appointment ID to prevent SQL injection
    $appointmentId = mysqli_real_escape_string($conn, $_POST['id']);

    // Perform the delete operation
    $query = "DELETE FROM appointments WHERE id = '$appointmentId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // If the query is successful, return 'success'
        echo 'success';
    } else {
        // If there's an error with the query, return 'error'
        echo 'error';
    }
} else {
    // If appointment ID is not provided, return 'error'
    echo 'error';
}
?>
