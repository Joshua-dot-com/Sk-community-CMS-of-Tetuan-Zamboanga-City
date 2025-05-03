<?php
session_start();

include ('../../db_conn.php'); // Include db_conn.php

// Check if the user is not logged in
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    // Return error response if user is not logged in
    http_response_code(401); // Unauthorized
    exit(json_encode(["success" => false, "message" => "Unauthorized access"]));
}

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are present
    if (isset($_POST['problem_description'])) {
        // Sanitize the problem description input
        $problemDescription = mysqli_real_escape_string($conn, $_POST['problem_description']);
        
        // Check if an image is uploaded
        if (isset($_FILES['problem_image']) && $_FILES['problem_image']['error'] === UPLOAD_ERR_OK) {
            // File upload handling
            $targetDir = "../reportpicture/";
            $targetFile = $targetDir . basename($_FILES["problem_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["problem_image"]["tmp_name"]);
            if ($check !== false) {
                // File is an image
                $uploadOk = 1;
            } else {
                // File is not an image
                http_response_code(400); // Bad Request
                exit(json_encode(["success" => false, "message" => "File is not an image."]));
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                // File already exists
                http_response_code(400); // Bad Request
                exit(json_encode(["success" => false, "message" => "Sorry, file already exists."]));
            }

            // Check file size
            if ($_FILES["problem_image"]["size"] > 5000000) {
                // File size exceeds limit
                http_response_code(400); // Bad Request
                exit(json_encode(["success" => false, "message" => "Sorry, your file is too large."]));
            }

            // Allow only certain file formats
            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                // Invalid file format
                http_response_code(400); // Bad Request
                exit(json_encode(["success" => false, "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]));
            }

            // Attempt to move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["problem_image"]["tmp_name"], $targetFile)) {
                // File uploaded successfully, insert data into database
                $userID = $_SESSION['user_id'];
                $insertSql = "INSERT INTO reports (user_id, problem_description, problem_image) VALUES (?, ?, ?)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param('iss', $userID, $problemDescription, $targetFile);
                if ($insertStmt->execute()) {
                    // Data inserted successfully
                    exit(json_encode(["success" => true, "message" => "Problem reported successfully."]));
                } else {
                    // Failed to insert data
                    http_response_code(500); // Internal Server Error
                    exit(json_encode(["success" => false, "message" => "Failed to report problem. Please try again later."]));
                }
            } else {
                // Error uploading file
                http_response_code(500); // Internal Server Error
                exit(json_encode(["success" => false, "message" => "Sorry, there was an error uploading your file."]));
            }
        } else {
            // No image uploaded, insert data into database without image path
            $userID = $_SESSION['user_id'];
            $insertSql = "INSERT INTO reports (user_id, problem_description) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param('is', $userID, $problemDescription);
            if ($insertStmt->execute()) {
                // Data inserted successfully
                exit(json_encode([ "Problem reported successfully."]));
            } else {
                // Failed to insert data
                http_response_code(500); // Internal Server Error
                exit(json_encode(["success" => false, "message" => "Failed to report problem. Please try again later."]));
            }
        }
    } else {
        // Required fields are missing
        http_response_code(400); // Bad Request
        exit(json_encode(["success" => false, "message" => "Please provide problem description."]));
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    exit(json_encode(["success" => false, "message" => "Method not allowed."]));
}
?>
