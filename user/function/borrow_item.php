<?php
session_start();
require_once '../../db_conn.php'; // Include db_conn.php

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode(['error' => 'You are not logged in.']);
    exit;
}

// Check if the user already has a borrowed item
$userId = $_SESSION['user_id'];
$borrowCheckSql = "SELECT * FROM borrow WHERE user_id = ?";
$borrowCheckStmt = $conn->prepare($borrowCheckSql);
$borrowCheckStmt->bind_param('i', $userId);
$borrowCheckStmt->execute();
$borrowResult = $borrowCheckStmt->get_result();

if ($borrowResult->num_rows > 0) {
    echo json_encode(['error' => 'You already have a borrowed item. Return it before borrowing another.']);
    exit;
}

// Continue with borrowing process if the user doesn't have a borrowed item

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $itemId = isset($_POST['item_id']) ? $_POST['item_id'] : null;

    // Retrieve other form data
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
    $borrowDate = isset($_POST['borrowDate']) ? $_POST['borrowDate'] : null;
    $returnDate = isset($_POST['returnDate']) ? $_POST['returnDate'] : null;

    // Check if any of the required fields are empty
    if ($itemId === null || $quantity === null || $borrowDate === null || $returnDate === null) {
        echo json_encode(['error' => 'Please fill out all the required fields.']);
        exit;
    }

    // Prepare and bind parameters to the SQL statement
    $sql = "INSERT INTO borrow (user_id, item_id, quantity, borrow_date, return_date) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiiss', $userId, $itemId, $quantity, $borrowDate, $returnDate);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Update the item quantity in the 'items' table (assuming the quantity needs to be decreased)
        $updateSql = "UPDATE items SET quantity = quantity - ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('ii', $quantity, $itemId);
        $updateStmt->execute();
        $updateStmt->close();

        // Return success response
        echo json_encode(['success' => true]);
        exit;
    } else {
        // Return error response
        echo json_encode(['error' => 'Failed to borrow item.']);
        exit;
    }

    // Close prepared statements and database connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, return error response
    echo json_encode(['error' => 'Invalid request method.']);
    exit;
}
?>
