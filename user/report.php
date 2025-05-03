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
    <link rel="stylesheet" href="css/report.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
body {
    background-image: url('../assets/img/6.png'); /* Specify the path to your image */
    background-size: cover; /* Cover the entire background */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat;
}
.floating-back-btn {
      position: fixed;
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
                    <a href="report.php">Report</a>
                    <a href="appointment.php">Appointment</a>
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
            <h2 style=" font-family: Arial, sans-serif; font-size: 26px; font-weight: bold;">Report Problem</h2>
            <form id="reportForm" enctype="multipart/form-data">
                <div>
                    <label for="problem_description" style=" font-family: Arial, sans-serif; font-size: 18px; font-weight: normal;">Problem Description:</label><br>
                    <textarea id="problem_description" name="problem_description" rows="4" cols="50" placeholder="Describe the problem here..."></textarea>
                </div>
                <div>
                    <label for="problem_image" style=" font-family: Arial, sans-serif; font-size: 15px; font-weight: normal;">Upload Image:</label><br>
                    <input type="file" id="problem_image" name="problem_image">
                </div>
                <br>
                <div>
                <button id="submitBtn" style="background-color: #4CAF50; border: none;
  color: white;
  padding: 10px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 10px;">Submit</button>
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
            var formData = new FormData(document.getElementById("reportForm"));

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "function/submit_report.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle successful response
                    alert(xhr.responseText); // You can display a success message or redirect the user here
                    if (xhr.responseText.includes("successfully")) {
                        window.location.reload(); // Reload the page after successful submission
                    }
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
