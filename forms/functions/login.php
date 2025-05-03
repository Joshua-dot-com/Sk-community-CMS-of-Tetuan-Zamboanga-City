<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    include('../../db_conn.php');

    // Retrieve email and password from the AJAX request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Construct SQL query to fetch user data
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if a user with the provided email exists
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Check if the user's account is approved
                if ($row['approved'] == 1) {
                    // Set session variables
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $email;
                    $_SESSION['first_name'] = $row['first_name']; // Store first name in session

                    // You can add more session variables if needed

                    // Return success response
                    echo json_encode(['success' => true, 'user_id' => $row['id']]);
                    exit();
                } else {
                    // Return error response - account not approved
                    echo json_encode(['error' => 'Your account is not yet approved. Please wait for approval.']);
                    exit();
                }
            } else {
                // Return error response - invalid email or password
                echo json_encode(['error' => 'Invalid email or password.']);
                exit();
            }
        } else {
            // Return error response - invalid email or password
            echo json_encode(['error' => 'Invalid email or password.']);
            exit();
        }
    } else {
        // Return error response - database error
        echo json_encode(['error' => 'An error occurred. Please try again later.']);
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Return error response - invalid request method
    echo json_encode(['error' => 'Invalid request method.']);
    exit();
}
?>
