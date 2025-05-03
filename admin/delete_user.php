<?php
// Include database connection file
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user id from the AJAX request
    $userId = $_POST['userId'];

    // Perform delete query
    $query = "DELETE FROM users WHERE id = $userId";

    if (mysqli_query($conn, $query)) {
        // Deletion successful
        $response = array("status" => "success", "message" => "User deleted successfully.");
        echo json_encode($response);
    } else {
        // Deletion failed
        $response = array("status" => "error", "message" => "Error deleting user: " . mysqli_error($conn));
        echo json_encode($response);
    }
} else {
    // Handle invalid request method
    $response = array("status" => "error", "message" => "Invalid request method.");
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
