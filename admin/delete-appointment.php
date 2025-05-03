<?php
// Check if appointment_id is set and not empty
if(isset($_POST['appointment_id']) && !empty($_POST['appointment_id'])) {
    // Get the appointment ID and sanitize it
    $appointmentId = $_POST['appointment_id']; // No need to sanitize since it's not directly used in SQL

    // Include your database connection file
    include '../db_conn.php'; // Replace 'db_connection.php' with the actual file that contains your database connection code

    // Construct the SQL query to delete the appointment
    $sql = "DELETE FROM appointments WHERE id = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("i", $appointmentId);

    // Execute the SQL statement
    if($stmt->execute()) {
        // If the query is successful, send a success response
        echo 'success';
    } else {
        // If there's an error, send an error response
        echo 'error';
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If appointment_id is not set or empty, send an error response
    echo 'error';
}
?>
