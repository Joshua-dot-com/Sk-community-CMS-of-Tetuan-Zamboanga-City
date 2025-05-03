<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include('../db_conn.php');

    // Initialize variables to store form data
    $categoryName = '';

    // Check if category name is set and not empty
    if (isset($_POST['categoryName']) && !empty($_POST['categoryName'])) {
        $categoryName = $_POST['categoryName'];

        // Prepare SQL statement to insert new category into the database
        $sql = "INSERT INTO categories (name) VALUES (?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoryName);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Category added successfully
            echo "Category added successfully!";
        } else {
            // Error while adding category
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Category name is not provided or empty
        echo "Category name is required!";
    }
} else {
    // Redirect to the homepage or display an error message
    echo "Error: Form submission method not allowed!";
}
?>
