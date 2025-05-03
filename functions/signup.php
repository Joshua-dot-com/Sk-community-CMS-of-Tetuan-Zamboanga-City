<?php
// Include the database connection file
include_once '../db_conn.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['first-name'];
    $middleName = $_POST['middle-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone-number'];
    $purok = $_POST['purok'];
    $birthday = $_POST['birthday'];
    $sex = $_POST['sex'];
    $maritalStatus = $_POST['marital-status'];
    $hasChild = $_POST['has-child'];

    // Password hashing
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // File upload handling
    $targetDir = "../verificationphoto/"; // Directory where uploaded files will be stored
    $fileName = basename($_FILES["verification-photo"]["name"]); // Get the file name
    $targetFilePath = $targetDir . $fileName; // Path to save the uploaded file

    // Check if file is selected
    if (!empty($fileName)) {
        // Allow certain file formats
        $allowTypes = array('jpg', 'jpeg', 'png');
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["verification-photo"]["tmp_name"], $targetFilePath)) {
                // Insert user data into the database
                $sql = "INSERT INTO users (first_name, middle_name, last_name, email, phone_number, purok, birthday, sex, marital_status, has_child, verification_photo, password) 
                        VALUES ('$firstName', '$middleName', '$lastName', '$email', '$phoneNumber', '$purok', '$birthday', '$sex', '$maritalStatus', '$hasChild', '$fileName', '$hashedPassword')";

                if ($conn->query($sql) === TRUE) {
                    // Signup successful
                    $response["success"] = true;
                    $response["message"] = "Account is being verified. Please wait for 2 to 3 days.";
                } else {
                    // Signup failed
                    $response["success"] = false;
                    $response["error"] = "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                // Error uploading file
                $response["success"] = false;
                $response["error"] = "Error uploading file.";
            }
        } else {
            // File format not supported
            $response["success"] = false;
            $response["error"] = "File format not supported. Please upload a JPG, JPEG, or PNG file.";
        }
    } else {
        // No file selected
        $response["success"] = false;
        $response["error"] = "Please select a file.";
    }

    // Send JSON response
    header("Content-Type: application/json");
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>

