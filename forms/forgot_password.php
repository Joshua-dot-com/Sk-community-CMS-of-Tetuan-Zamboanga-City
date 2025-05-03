<?php
require '../vendor/autoload.php';
// Include PHPMailer library
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include your database connection file
require '../db_conn.php';

// Function to generate 4-digit numerical OTP
function generateOTP() {
    // Generate random 4-digit OTP
    $otp = rand(1000, 9999);
    return $otp;
}

// Function to send OTP to email
function sendOTP($email, $otp, $conn) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'sk.tetuan.0@gmail.com'; // SMTP username
        $mail->Password = 'lvlw lhzl bbdu rbea'; // SMTP password
        $mail->Port = 587; // Port: 587 (recommended), 2525 or 25

        //Recipients
        $mail->setFrom('sk.tetuan.0@gmail.com', 'SKtetuan');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset OTP';
        $mail->Body = 'Your OTP is: ' . $otp;

        // Save OTP and creation time to database
        $timestamp = time();
        $sql = "INSERT INTO otp_data (email, otp, created_at) VALUES ('$email', '$otp', '$created_at)";
        $conn->query($sql);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email address.";
    } else {
        // Check if the email exists in the users table and the approve value is 1
        $sql = "SELECT * FROM users WHERE email = '$email' AND approved = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Generate 4-digit numerical OTP
            $otp = generateOTP();

            // Send OTP to user's email and save it to database
            if (sendOTP($email, $otp, $conn)) {
                // Redirect the user to OTP verification page
                header("Location: verify_otp.php?email=$email");
                exit;
            } else {
                // Error sending OTP
                $error_message = "Failed to send OTP. Please try again later.";
            }
        } else {
            // Email not found or user not approved
            $error_message = "Email not found or user not approved.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SK TETUAN | Forgot Password</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/sklogo.png">
  <link rel="stylesheet" href="../assets/global.css">
  <link rel="stylesheet" href="../assets/fonts.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="styles/forgotpass.css">
</head>
<body>
<form method="post">
<?php if (isset($error_message)): ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
  <?php endif; ?>
  <label for="email">Enter your email:</label>
  <input type="email" id="email" name="email" required>
  <button type="submit">Send OTP</button>

</form>
</body>
</html>
