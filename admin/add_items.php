<?php
// Include database connection file
include_once "../db_conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $itemName = $_POST["itemName"];
    $itemQuantity = $_POST["itemQuantity"];
    $itemCategory = $_POST["itemCategory"];

    // Handle file upload for item photo
    $targetDir = "items/";
    $targetFile = $targetDir . basename($_FILES["itemPhoto"]["name"]);
    if (move_uploaded_file($_FILES["itemPhoto"]["tmp_name"], $targetFile)) {
        // Insert data into database
        $sql = "INSERT INTO items (name, quantity, category_id, photo_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("siss", $itemName, $itemQuantity, $itemCategory, $targetFile); // Changed "sisi" to "sisss"
        if ($stmt->execute()) {
            echo "Item added successfully";
        } else {
            echo "Error: " . $stmt->error; 
        }
        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Close connection
$conn->close(); 
?>
