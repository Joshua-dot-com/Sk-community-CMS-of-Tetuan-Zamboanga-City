<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "sktetuan"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and password are provided
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Retrieve the submitted username and password
        $submitted_username = $_POST["username"];
        $submitted_password = $_POST["password"];

        // Prepare a SQL statement to retrieve user information
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $submitted_username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if the user exists
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify the password
            if (password_verify($submitted_password, $row["password"])) {
                // Set session variables to mark the user as logged in
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $submitted_username;
                // Redirect the user to the dashboard or any other page after successful login
                header("Location: dashboard.php");
                exit;
            } else {
                // If password is incorrect, set an error message
                $_SESSION['error'] = "Incorrect password.";
            }
        } else {
            // If username is incorrect, set an error message
            $_SESSION['error'] = "Username not found.";
        }
        $stmt->close();
    } else {
        // If username or password is not provided, set an error message
        $_SESSION['error'] = "Please provide both username and password.";
    }
} else {
    // If the form is not submitted, redirect back to the login page
    header("Location: login.php");
    exit;
}

// Close database connection
$conn->close();

// Redirect back to the login page
header("Location: login.php");
exit;
?>
