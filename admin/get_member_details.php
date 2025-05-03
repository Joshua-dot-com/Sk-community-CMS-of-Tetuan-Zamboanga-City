<?php
include('../db_conn.php');
// Check if member_id is provided in the request
if(isset($_GET['member_id'])) {
    // Sanitize the input to prevent SQL injection
    $member_id = mysqli_real_escape_string($conn, $_GET['member_id']);

    // Query to fetch member details based on member_id
    $query = "SELECT * FROM sk_kagawads WHERE id = $member_id";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if($result) {
        // Fetch the member details
        $member = mysqli_fetch_assoc($result);

        // Check if member details were found
        if($member) {
            // Return member details as JSON response
            echo json_encode($member);
        } else {
            // Member not found
            http_response_code(404); // Set HTTP response code to 404 Not Found
            echo "Member not found.";
        }
    } else {
        // Error executing the query
        http_response_code(500); // Set HTTP response code to 500 Internal Server Error
        echo "Error: " . mysqli_error($your_db_connection);
    }
} else {
    // member_id parameter not provided
    http_response_code(400); // Set HTTP response code to 400 Bad Request
    echo "Member ID parameter is missing.";
}

// Close database connection
mysqli_close($conn);
?>
