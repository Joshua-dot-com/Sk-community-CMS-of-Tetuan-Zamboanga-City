<?php
// Include your database connection file
require '../db_conn.php';

// Handle OTP verification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $otp_entered = $_POST["otp"];

    // Fetch the OTP and its creation time from the database for the given email address
    $sql = "SELECT otp, created_at FROM otp_data WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $otp_saved = $row["otp"];
        $created_at = $row["created_at"];

        // Check if OTP is expired (30 minutes expiration time)
        $current_time = time();
        $expiration_time = $created_at + (30 * 60); // 30 minutes in seconds
        if ($current_time > $expiration_time) {
            // OTP expired
            $error_message = "OTP has expired. Please request a new one.";
        } else {
            // Compare the entered OTP with the saved OTP
            if ($otp_entered == $otp_saved) {
                // OTP verification successful
                // Redirect the user to password reset page or any other action
                header("Location: reset_password.php?email=$email");
                exit;
            } else {
                // Incorrect OTP
                $error_message = "Incorrect OTP. Please try again.";
            }
        }
    } else {
        // No OTP found for the given email address
        $error_message = "No OTP found for this email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SK TETUAN | OTP Verification</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/sklogo.png">
  <link rel="stylesheet" href="../assets/global.css">
  <link rel="stylesheet" href="../assets/fonts.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="styles/verify.css">
</head>
<body>
<form method="post">
  <label for="otp">Enter the 4-digit OTP you received:</label>
  <input type="text" id="otp" name="otp" pattern="[01]{4}" title="Please enter a 4-digit binary OTP." required>
  <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
  <button type="submit">Verify OTP</button>
  <?php if (isset($error_message)): ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
  <?php endif; ?>
</form>
</body>
</html>
    