<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
   // Database configuration
$host = 'localhost'; // Your database host (usually 'localhost')
$db_name = 'sktetuan'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Attempt to establish a connection
$con = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (!$con) {
    // If connection fails, display an error message and terminate execution
    die("Connection failed: " . mysqli_connect_error());
}
    // Get form data
    $caption = $_POST['caption'];
    $description = $_POST['description'];

    // Check if file is uploaded
    if (isset($_FILES['image'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];

        // Move uploaded file to a permanent location
        $target_dir = "upload/"; // Directory where uploaded images will be stored
        $target_file = $target_dir . basename($image_name);

        // Check if file upload is successful
        if (move_uploaded_file($image_tmp_name, $target_file)) {
            // Insert announcement data into database
            $query = "INSERT INTO announcement (caption, description, image_path) VALUES ('$caption', '$description', '$target_file')";
            if (mysqli_query($con, $query)) {
                echo "success"; // Send success response
            } else {
                echo "Error adding announcement: " . mysqli_error($con);
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Image file not found.";
    }

    // Close database connection
    mysqli_close($con);
}
?>
