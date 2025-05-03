<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(array("success" => false, "message" => "You are not allowed in this page. Please log in and try again"));
    exit();
}

// Check if borrow_id is provided and not empty
if (isset($_POST['borrow_id']) && !empty($_POST['borrow_id'])) {
    // Database connection
    include('../db_conn.php');

    // Retrieve the borrow_id from POST data
    $borrowId = $_POST['borrow_id'];

    // Query to fetch item_id and quantity of the borrowed item
    $sql = "SELECT item_id, quantity FROM borrow WHERE borrow_id = $borrowId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch item_id and quantity
        $row = $result->fetch_assoc();
        $itemId = $row['item_id'];
        $quantity = $row['quantity'];

        // Delete the borrow record
        $deleteSql = "DELETE FROM borrow WHERE borrow_id = $borrowId";
        if ($conn->query($deleteSql) === TRUE) {
            // Update item quantity
            $updateSql = "UPDATE items SET quantity = quantity + $quantity WHERE id = $itemId";
            if ($conn->query($updateSql) === TRUE) {
                // Return success response
                echo json_encode(array("success" => true));
            } else {
                // Return error response if failed to update item quantity
                echo json_encode(array("success" => false, "message" => "Failed to update item quantity."));
            }
        } else {
            // Return error response if failed to delete borrow record
            echo json_encode(array("success" => false, "message" => "Failed to return item. Please try again later."));
        }
    } else {
        // Return error response if borrow record not found
        echo json_encode(array("success" => false, "message" => "Invalid borrow ID."));
    }

    // Close database connection
    $conn->close();
} else {
    // Return error response if borrow_id is not provided
    echo json_encode(array("success" => false, "message" => "Borrow ID is required."));
}
?>
