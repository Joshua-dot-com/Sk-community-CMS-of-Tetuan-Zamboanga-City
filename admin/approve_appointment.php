<?php
// Include database connection
include '../db_conn.php';

// Check if appointment ID is provided
if (isset($_POST['id'])) {
    // Sanitize the input
    $appointmentId = mysqli_real_escape_string($conn, $_POST['id']);

    // Update the database record to mark the appointment as approved
    $query = "UPDATE appointments SET is_approved = 1 WHERE id = $appointmentId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Return success response
        echo 'success';
    } else {
        // Return error response
        echo 'error';
    }
} else {
    // Return error response if ID is not provided
    echo 'error';
}
?>
