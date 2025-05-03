<?php
session_start();

include ('../db_conn.php'); // Include db_conn.php

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("Location: ../forms/login.php");
    exit;
}

// Logout logic
if(isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: ../home.php");
    exit;
}

// Get the user ID from the session
$userID = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK | tetuan</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/sklogo.png">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="css/appointment.css"> 
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
      body {
    background-image: url('../assets/img/5.png'); /* Specify the path to your image */
    background-size: cover; /* Cover the entire background */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat;
}
.floating-back-btn {
    position: absolute;
    top: 20px; /* Adjust as needed */
    left: 20px; /* Adjust as needed */
    z-index: 999; /* Adjust as needed */
  }
      </style>
</head>

<body>
<a href="landing.php" class="btn btn-primary floating-back-btn">
    <i class="fas fa-arrow-circle-left"></i>
  </a>
<nav class="nav-bar">
    <div class="wrapper">
        <div class="nav-bar__logo-wrapper">
            <img class="nav-bar__logo" src="../assets/img/sklogo.png" alt="logo">
            <p class="nav-bar__logo-abbrev"></p>
            <p class="nav-bar__logo-name"></p>
        </div>

        <div class="nav-link">
            <div class="dropdown">
                <button class="dropbtn">Services</button>
                <div class="adropdown-content" id="servicesDropdown">
                    <a href="report.php">Report</a> <!-- Link to the report page -->
                    <a href="appointment.php">Appointment</a> <!-- Current page -->
                    <a href="items.php">Supplies</a>
                </div>
            </div>
            <!-- Logout dropdown -->
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleLogout()">Welcome, <?php echo isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest'; ?></button>
                <div class="dropdown-content" id="logoutDropdown">
                    <form method="post">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<header>
  
</header>

<main>
    <div class="container">
        <h2 style="font-weight: normal; text-align: center;">Set Appointment</h2><br>
        <form id="appointmentForm">
            <div>
                <label for="appointment_date" style="font-weight: normal;">Appointment Date:</label><br>
                <input type="date" id="appointment_date" name="appointment_date">
            </div>
            <div>
                <label for="appointment_time" style="font-weight: normal;">Appointment Time:</label><br>
                <input type="time" id="appointment_time" name="appointment_time">
            </div>
            <div>
                <label for="appointment_reason" style="font-weight: normal;">Reason for Appointment:</label><br>
                <textarea id="appointment_reason" name="appointment_reason" rows="4" cols="50" placeholder="Enter the reason for your appointment..."></textarea>
            </div>
            <br>
            <div>
    <button id="submitBtn" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Set Appointment</button>
</div>

        </form>
    </div>
</main>


<footer>
    <!-- Your footer content goes here -->
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("submitBtn").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission

            // Create FormData object to store form data
            var formData = new FormData(document.getElementById("appointmentForm"));

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "function/submit_appointment.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle successful response
                    alert(xhr.responseText); // You can display a success message or redirect the user here
                } else {
                    // Handle error
                    alert('Error occurred. Please try again.'); // You can display an error message to the user
                }
            };
            xhr.onerror = function() {
                // Handle network error
                alert('Network error occurred. Please try again.'); // You can display a network error message to the user
            };
            xhr.send(formData); // Send FormData object
        });
    });
</script>

</body>

</html>
