<?php
// Include database connection
include('../db_conn.php');

// Check if the database connection is established successfully
if ($conn->connect_error) {
    // Handle error if database connection couldn't be established
    echo '<option value="">Database connection failed</option>';
    exit(); // Stop further execution
}

// Fetch categories from the database
$query = "SELECT id, name FROM categories";
$result = $conn->query($query);

// Check if categories were fetched successfully
if ($result->num_rows > 0) {
    // Initialize an empty string to store HTML options
    $options = '';
    while ($row = $result->fetch_assoc()) {
        // Append each category as an option to the string
        $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    // Return the HTML options
    echo $options;
} else {
    // Handle error if categories couldn't be fetched
    echo '<option value="">No categories available</option>';
}

// Close database connection
$conn->close();
?>
