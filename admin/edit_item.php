<?php
include('../db_conn.php'); 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['editItemId']) && isset($_POST['editItemName']) && isset($_POST['editItemQuantity'])) {
        // Get the item ID, name, and quantity from the POST data
        $itemId = $_POST['editItemId'];
        $itemName = $_POST['editItemName'];
        $itemQuantity = $_POST['editItemQuantity'];

        // Check if a new photo is uploaded
        if (isset($_FILES['editItemPhoto']) && $_FILES['editItemPhoto']['error'] === UPLOAD_ERR_OK) {
            // Define upload directory
            $uploadDirectory = 'items/';
            
            // Generate a unique filename for the uploaded photo
            $photoName = uniqid('item_photo_') . '_' . basename($_FILES['editItemPhoto']['name']);
            $photoPath = $uploadDirectory . $photoName;

            // Move the uploaded photo to the upload directory
            if (move_uploaded_file($_FILES['editItemPhoto']['tmp_name'], $photoPath)) {
                // Photo uploaded successfully, update the photo path in the database
                // Make sure to sanitize inputs to prevent SQL injection
                $photoPath = mysqli_real_escape_string($conn, $photoPath);

                // Update the item record in the database
                $sql = "UPDATE items SET name = '$itemName', quantity = $itemQuantity, photo_path = '$photoPath' WHERE id = $itemId";

                // Execute the query
                if ($conn->query($sql) === TRUE) {
                    // Item updated successfully
                    echo json_encode(array('success' => true));
                } else {
                    // Error updating item
                    echo json_encode(array('success' => false, 'message' => 'Error updating item: ' . $conn->error));
                }
            } else {
                // Error moving uploaded photo
                echo json_encode(array('success' => false, 'message' => 'Error uploading photo.'));
            }
        } else {
            // No new photo uploaded, update only name and quantity
            // Update the item record in the database
            $sql = "UPDATE items SET name = '$itemName', quantity = $itemQuantity WHERE id = $itemId";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                // Item updated successfully
                echo json_encode(array('success' => true));
            } else {
                // Error updating item
                echo json_encode(array('success' => false, 'message' => 'Error updating item: ' . $conn->error));
            }
        }
    } else {
        // Required fields not set
        echo json_encode(array('success' => false, 'message' => 'Required fields not set.'));
    }
} else {
    // Form not submitted using POST method
    echo json_encode(array('success' => false, 'message' => 'Form not submitted.'));
}
?>
