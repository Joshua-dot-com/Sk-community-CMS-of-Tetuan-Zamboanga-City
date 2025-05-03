<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ID is provided in the URL
    if(isset($_GET['id'])) {
        // Include database connection
        include '../db_conn.php';
        
        // Get post ID from the URL
        $post_id = $_GET['id'];
        
        // Retrieve form data
        $post_title = $_POST['post_title'];
        $post_description = $_POST['post_description'];
        
        // Check if a new image is uploaded
        if(isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
            // Get file information
            $file_name = $_FILES['post_image']['name'];
            $file_tmp = $_FILES['post_image']['tmp_name'];
            
            // Move uploaded file to destination directory
            $upload_dir = '../admin/upload/';
            move_uploaded_file($file_tmp, $upload_dir . $file_name);
            
            // Update image path in the database
            $query = "UPDATE announcement SET caption = '$post_title', description = '$post_description', image_path = '$file_name' WHERE id = $post_id";
        } else {
            // No new image uploaded, update without changing the image path
            $query = "UPDATE announcement SET caption = '$post_title', description = '$post_description' WHERE id = $post_id";
        }
        
        // Execute query
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            // Post updated successfully
            echo "Post updated successfully.";
        } else {
            // Error updating post
            echo "Error updating post: " . mysqli_error($conn);
        }
        
        // Close database connection
        mysqli_close($conn);
    } else {
        // ID is not provided in the URL
        echo "Post ID is missing.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
    