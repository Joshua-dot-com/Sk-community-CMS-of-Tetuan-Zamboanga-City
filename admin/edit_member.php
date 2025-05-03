<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the member ID is provided
    if (isset($_POST['edit_member_id'])) {
        
       include('../db_conn.php');
        // Sanitize member ID to prevent SQL injection
        $edit_member_id = mysqli_real_escape_string($conn, $_POST['edit_member_id']);

        // Construct the update query
        $update_query = "UPDATE sk_kagawads SET ";

        // Check and add fields to update if they are provided
        if (isset($_POST['edit_name'])) {
            $edit_name = mysqli_real_escape_string($conn, $_POST['edit_name']);
            $update_query .= "name='$edit_name', ";
        }
        if (isset($_POST['edit_position'])) {
            $edit_position = mysqli_real_escape_string($conn, $_POST['edit_position']);
            $update_query .= "position='$edit_position', ";
        }
        if (isset($_POST['edit_barangay'])) {
            $edit_barangay = mysqli_real_escape_string($conn, $_POST['edit_barangay']);
            $update_query .= "barangay='$edit_barangay', ";
        }
        if (isset($_POST['edit_municipality'])) {
            $edit_municipality = mysqli_real_escape_string($conn, $_POST['edit_municipality']);
            $update_query .= "municipality='$edit_municipality', ";
        }
        if (isset($_POST['edit_email'])) {
            $edit_email = mysqli_real_escape_string($conn, $_POST['edit_email']);
            $update_query .= "email='$edit_email', ";
        }
        if (isset($_POST['edit_contact_number'])) {
            $edit_contact_number = mysqli_real_escape_string($conn, $_POST['edit_contact_number']);
            $update_query .= "contact_number='$edit_contact_number', ";
        }
        if (isset($_POST['edit_about_me'])) {
            $edit_about_me = mysqli_real_escape_string($conn, $_POST['edit_about_me']);
            $update_query .= "about_me='$edit_about_me', ";
        }

        // Handle photo upload
        if (isset($_FILES['edit_profile_picture']['name']) && !empty($_FILES['edit_profile_picture']['name'])) {
            $target_dir = "sk_profile_picture/"; // Directory where the file will be stored
            $target_file = $target_dir . basename($_FILES['edit_profile_picture']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['edit_profile_picture']['tmp_name']);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['edit_profile_picture']['size'] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                // If everything is ok, try to upload file
                if (move_uploaded_file($_FILES['edit_profile_picture']['tmp_name'], $target_file)) {
                    // Update the photo path in the database
                    $update_query .= "profile_picture='$target_file', ";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        // Remove the trailing comma and space
        $update_query = rtrim($update_query, ", ");

        // Add WHERE clause for the member ID
        $update_query .= " WHERE id='$edit_member_id'";

        // Execute the update query
        if (mysqli_query($conn, $update_query)) {
            // If the query was successful, return success message
            echo "success";
        } else {
            // If there was an error with the query, return the error message
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        // If the member ID is not provided, return an error message
        echo "Member ID is missing.";
    }
} else {
    // If the request method is not POST, return an error message
    echo "Invalid request method.";
}
?>
