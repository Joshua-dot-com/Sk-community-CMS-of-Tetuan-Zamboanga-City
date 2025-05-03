<?php
// Include your database connection file
require '../db_conn.php';

// Handle password reset
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate passwords
    if ($new_password != $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Update the password in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        if ($conn->query($sql) === TRUE) {
            // Password reset successful
            $success_message = "Password reset successfully!";
            echo "<script>alert('$success_message'); window.location.replace('login.php');</script>";
            exit;
        } else {
            // Error updating password
            $error_message = "Failed to reset password. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SK TETUAN | Reset Password</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/sklogo.png">
  <link rel="stylesheet" href="../assets/global.css">
  <link rel="stylesheet" href="../assets/fonts.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="styles/verify.css">
</head>
<body>

<?php if (isset($success_message)): ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php else: ?>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Reset Password</button>
    </form>
<?php endif; ?>
</body>
</html>
