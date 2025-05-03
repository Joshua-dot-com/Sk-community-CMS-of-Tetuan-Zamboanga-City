<?php
// Include database connection file
include_once "../db_conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $position = $_POST["position"];
    $barangay = $_POST["barangay"];
    $municipality = $_POST["municipality"];
    $email = $_POST["email"];
    $contact_number = $_POST["contact_number"];
    $about_me = $_POST["about_me"];

    // Handle file upload for profile picture
    $profile_picture = "";
    if ($_FILES["profile_picture"]["name"]) {
        $target_dir = "sk_profile_picture/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    // Insert data into database
    $sql = "INSERT INTO sk_kagawads (name, position, barangay, municipality, email, contact_number, about_me, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql); // Change $mysqli to $conn
    $stmt->bind_param("ssssssss", $name, $position, $barangay, $municipality, $email, $contact_number, $about_me, $profile_picture);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error; // Use $stmt->error instead of $mysqli->error
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close(); // Change $mysqli to $conn
?>
