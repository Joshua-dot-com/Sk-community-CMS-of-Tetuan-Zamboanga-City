<?php
// Check if the item ID is set and is a valid integer
if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
    // Include database connection file
    include("../db_conn.php");

    // Escape the item ID to prevent SQL injection
    $itemId = mysqli_real_escape_string($conn, $_POST['id']);

    // SQL query to delete the item
    $sql = "DELETE FROM items WHERE id = $itemId";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Item deleted successfully
        echo json_encode(array('success' => true));
    } else {
        // Error deleting item
        echo json_encode(array('success' => false, 'message' => 'Error deleting item: ' . $conn->error));
    }

    // Close database connection
    $conn->close();
} else {
    // Invalid item ID
    echo json_encode(array('success' => false, 'message' => 'Invalid item ID.'));
}
?>
