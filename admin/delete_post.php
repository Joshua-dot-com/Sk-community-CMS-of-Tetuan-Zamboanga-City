<?php
// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Include database connection
    include '../db_conn.php'; // Include your database connection file

    // Escape user inputs for security
    $post_id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to delete the post with the specified id
    $query = "DELETE FROM announcement WHERE id = '$post_id'";

    if (mysqli_query($conn, $query)) {
        // If deletion is successful, redirect back to the page where the user came from
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // If deletion fails, display an error message
        echo "Error deleting post: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // If the 'id' parameter is not set in the URL, redirect to the homepage or another appropriate page
    header("Location: index.php"); // Redirect to index.php or any other page
    exit();
}
?>
