<?php
// Include database connection file
include_once "../db_conn.php";

// Query to retrieve items from the database
$sql = "SELECT items.id, items.name AS itemName, items.quantity, categories.name AS categoryName
        FROM items
        INNER JOIN categories ON items.category_id = categories.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["itemName"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["categoryName"] . "</td>";
        // Add more columns if needed
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No items found</td></tr>";
}

// Close connection
$conn->close();
?>
