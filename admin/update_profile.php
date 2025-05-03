<?php
// Include database connection file
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the AJAX request
    $userId = $_POST['userId'];
    $firstName = $_POST['editFirstName'];
    $middleName = $_POST['editMiddleName'];
    $lastName = $_POST['editLastName'];
    $email = $_POST['editEmail'];
    $phoneNumber = $_POST['editPhoneNumber'];
    $purok = $_POST['editPurok'];
    $birthday = $_POST['editBirthday'];
    $sex = $_POST['editSex'];
    $maritalStatus = $_POST['editMaritalStatus'];
    $hasChild = $_POST['editHasChild'];

    // Perform update query
    $query = "UPDATE users SET 
                first_name = '$firstName',
                middle_name = '$middleName',
                last_name = '$lastName',
                email = '$email',
                phone_number = '$phoneNumber',
                purok = '$purok',
                birthday = '$birthday',
                sex = '$sex',
                marital_status = '$maritalStatus',
                has_child = '$hasChild'
              WHERE id = $userId";

    if (mysqli_query($conn, $query)) {
        // Update successful
        $response = array("status" => "success", "message" => "User profile updated successfully.");
        echo json_encode($response);
    } else {
        // Update failed
        $response = array("status" => "error", "message" => "Error updating user profile: " . mysqli_error($conn));
        echo json_encode($response);
    }
} else {
    // Handle invalid request method
    $response = array("status" => "error", "message" => "Invalid request method.");
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
