<?php
// Database connection
include('../db_conn.php');

// Check if item_id and quantity are provided and not empty
if (isset($_POST['item_id']) && !empty($_POST['item_id']) && isset($_POST['quantity']) && !empty($_POST['quantity'])) {
    // Retrieve item_id and quantity from POST data
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    // Update item quantity
    $sql = "UPDATE items SET quantity = $quantity WHERE id = $itemId";
    if ($conn->query($sql) === TRUE) {
        // Return success response
        echo json_encode(array("success" => true));
    } else {
        // Return error response if failed to update item quantity
        echo json_encode(array("success" => false, "message" => "Failed to update item quantity."));
    }
} else {
    // Return error response if item_id or quantity is not provided
    echo json_encode(array("success" => false, "message" => "Item ID and quantity are required."));
}

// Close database connection
$conn->close();
?>
