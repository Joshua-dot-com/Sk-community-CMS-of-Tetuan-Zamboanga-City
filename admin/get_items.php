<?php
// Include database connection
include('../db_conn.php');

// Fetch items from the database
$query = "SELECT * FROM items";
$result = mysqli_query($conn, $query);

$items = array();

// Check if items were fetched successfully
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Add each item to the $items array
        $items[] = $row;
    }
}

// Return items data as JSON
echo json_encode($items);
?>
