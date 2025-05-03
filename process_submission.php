<?php
// Establish database connection (replace these values with your actual database credentials)
include('db_conn.php');

// Check if the request is an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize the comment input
        $comment = trim($_POST['comment']);
        // Check if comment is not empty
        if (!empty($comment)) {
            // Create a database connection
            include('db_conn.php');
            // Prepare the SQL statement to insert the comment into the database
            $sql = "INSERT INTO comments_table (comment) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $comment);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Comment submitted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Comment cannot be empty!";
        }
    } else {
        echo "Invalid request method!";
    }
} else {
    echo "Unauthorized access!";
}
?>
