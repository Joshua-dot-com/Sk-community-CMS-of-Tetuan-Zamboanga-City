<?php
// Include database connection
include('../db_conn.php');

// Check if post ID is provided
if(isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Fetch post data from the database
    $query = "SELECT * FROM announcement WHERE id = $postId";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        // Post data found, return as JSON
        $post = mysqli_fetch_assoc($result);
        echo json_encode($post);
    } else {
        // Post not found
        echo json_encode(array('error' => 'Post not found'));
    }
} else {
    // Post ID not provided
    echo json_encode(array('error' => 'Post ID not provided'));
}

// Close database connection
mysqli_close($conn);
?>
