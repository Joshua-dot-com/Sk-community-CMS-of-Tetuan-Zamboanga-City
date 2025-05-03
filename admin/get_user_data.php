<?php
// Include database connection file
include '../db_conn.php';

// Check if user ID is provided
if(isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Prepare and execute query to fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if user with provided ID exists
    if ($result->num_rows > 0) {
        // Fetch user data as an associative array
        $userData = $result->fetch_assoc();

        // Close statement
        $stmt->close();

        // Close database connection
        $conn->close();

        // Return user data as JSON response
        header('Content-Type: application/json');
        echo json_encode($userData);
    } else {
        // User with provided ID not found
        http_response_code(404);
        echo json_encode(array('message' => 'User not found.'));
    }
} else {
    // User ID not provided
    http_response_code(400);
    echo json_encode(array('message' => 'User ID not provided.'));
}
?>
