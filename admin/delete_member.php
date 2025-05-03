<?php
// Check if member ID is provided
if(isset($_POST['member_id'])) {
    // Establish a connection to your database
   include('../db_conn.php');

    // Sanitize member ID to prevent SQL injection
    $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);

    // Construct the delete query
    $delete_query = "DELETE FROM sk_kagawads WHERE id='$member_id'";

    // Execute the delete query
    if (mysqli_query($conn, $delete_query)) {
        // If the query was successful, return success message
        echo "success";
    } else {
        // If there was an error with the query, return the error message
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If the member ID is not provided, return an error message
    echo "Member ID is missing.";
}
?>
