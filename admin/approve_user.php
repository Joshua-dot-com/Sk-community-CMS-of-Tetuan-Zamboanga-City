<?php
// Include database connection
include('../db_conn.php');

// Include PHPMailer autoload file
require '../vendor/autoload.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user_id is set and not empty
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        // Sanitize user_id to prevent SQL injection
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

        // Retrieve the user's email address from the database
        $sql_email = "SELECT email FROM users WHERE id = '$user_id'";
        $result_email = mysqli_query($conn, $sql_email);

        // Check if the query was successful and if there is a user with the specified ID
        if ($result_email && mysqli_num_rows($result_email) > 0) {
            $row = mysqli_fetch_assoc($result_email);
            $user_email = $row['email'];

            // Create a new PHPMailer instance
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            // Set up SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'sk.tetuan.0@gmail.com'; // Your SMTP username
            $mail->Password = 'lvlw lhzl bbdu rbea'; // Your SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587; // TCP port to connect to

            // Set up email content
            $mail->setFrom('sk.tetuan.0@gmail.com', 'SKtetuan'); // Sender's email and name
            $mail->addAddress($user_email); // Receiver's email
            $mail->isHTML(true);
            $mail->Subject = 'Your account has been approved';
            $mail->Body = 'Dear User, <br>Your account has been approved by the admin. You can now log in to your account.';

            // Send the email
            if (!$mail->send()) {
                // Return error message if unable to send email notification
                echo "Error: Unable to send email notification.";
            } else {
                // Update the 'approved' column to true for the specified user_id
                $sql_update = "UPDATE users SET approved = TRUE WHERE id = '$user_id'";
                $result_update = mysqli_query($conn, $sql_update);

                if ($result_update) {
                    // Return success message if both email sending and database update were successful
                    echo "User approved successfully and email notification sent.";
                } else {
                    // Return error message if there was an issue with updating the database
                    echo "Error: Unable to approve user. Database update failed.";
                }
            }
        } else {
            // Return error message if no user found with the specified ID
            echo "Error: No user found with the specified ID.";
        }
    } else {
        // Return error message if user_id is not set or empty
        echo "Error: Invalid user ID.";
    }
} else {
    // Return error message if the request method is not POST
    echo "Error: Invalid request method.";
}

// Close database connection
mysqli_close($conn);
?>
