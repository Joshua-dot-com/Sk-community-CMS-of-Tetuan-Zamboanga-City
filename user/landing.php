<?php
session_start();

require_once '../db_conn.php'; // Include db_conn.php


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
  <link rel="stylesheet" href="../landing.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    /* Style for the floating button */
    .floating-btn {
      position: fixed;
      font-size: 30px;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      background-color: green;
      border-radius: 50px;
      
    }

    .floating-btn:hover {
     color: darkgreen;
     background-color: white;
    }

    .floating-button {
  display: inline-block;
  background-color: red; /* Change to your desired background color */
  color: #fff; /* Change to your desired text color */
  padding: 10px 20px;
  border-radius: 30px; /* Adjust to change button shape */
  text-decoration: none;
  position: fixed;
  margin-right: 80px;
  margin-bottom: 7px;
  bottom: 20px; /* Adjust to change button position */
  right: 20px; /* Adjust to change button position */
  z-index: 1000; /* Ensure button is on top of other elements */
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
  transition: all 0.3s ease; /* Add smooth transition effect */
}

.floating-button:hover {
  background-color: maroon; /* Change to your desired hover background color */
  transform: translateY(-5px); /* Add slight lift on hover */
  text-decoration: none;
  color: black; 
}


.profile-link {
        display: block;
        padding: 12px 16px;
        text-decoration: none;
        color: #333; /* Adjust color as needed */
    }
 .profile-link:hover {
        background-color: #f9f9f9; /* Adjust color as needed */
    }

  </style>

</head>
<body>
<a href="emergency.html" class="floating-button">Emergency Hotline</a>


<nav class="nav-bar">
    <div class="wrapper">
        <div class="nav-bar__logo-wrapper">
            <img class="nav-bar__logo" src="../assets/img/sklogo.png" alt="logo">
            <p class="nav-bar__logo-abbrev"></p>
            <p class="nav-bar__logo-name"></p>
        </div>

        <div class="nav-link">
            <a class="nav-link__about" href="#about-us">About us</a>
            <a class="nav-link__message-us" href="#" onclick="toggleChatBox()">Message us</a>

            
            <!-- Chat Box Container -->
            <div id="chat-box-container" class="chat-box-container" style="display: none;">
                <div id="chat-messages" class="chat-messages">
                    <!-- Messages will be displayed here -->
                </div>
                <div class="chat-input-container">
                    <input type="text" id="message-input" class="message-input" placeholder="Type your message...">
                    <button id="send-btn" class="send-btn" onclick="sendMessage()">Send</button>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onmouseenter="showServices()">Services</button>
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
                <a href="profile.php" class="profile-link">Profile</a>
                    <form method="post">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>



  <header>
  <div class="splash">
  <div class="splash-inner">
    <img class="splash-image" src="../assets/img/2.png" alt="Image 1">
    <img class="splash-image" src="../assets/img/bg2.png" alt="Image 2">
    <img class="splash-image" src="../assets/img/bg3.png" alt="Image 3">
    <img class="splash-image" src="../assets/img/1.png" alt="Image 4">
    <img class="splash-image" src="../assets/img/2.png" alt="Image 5">
    <img class="splash-image" src="../assets/img/bg2.png" alt="Image 6">
    <img class="splash-image" src="../assets/img/bg3.png" alt="Image 7">
    <img class="splash-image" src="../assets/img/1.png" alt="Image 8">
    <img class="splash-image" src="../assets/img/2.png" alt="Image 9">
    <img class="splash-image" src="../assets/img/bg2.png" alt="Image 10">
    
  </div>
</div>
  </header>

  <div class="container">
  <h2 class="mb-4" style="display: flex; align-items: center; color:white; padding: 5px; background-image: url('../assets/img/c.png'); background-size: cover; background-position: center;"><span style="color: white; font-family: 'Pacifico', cursive; font-size: 2rem;">&nbsp;N</span>ews & Announcements</h2>
<hr style="background-color: black; margin-left: 10px; margin-bottom: 10px; flex: 1; height: 3px;">
    <div class="row">
        <?php
        // Include database connection
        include '../db_conn.php';

        // Fetch announcements from the database
        $query = "SELECT * FROM announcement ORDER BY created_at DESC";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $post_title = $row['caption'];
                $post_description = $row['description'];
                $post_image = $row['image_path'];
                $post_date = $row['created_at'];

                // Check if the image path starts with the correct directory structure
                // Check if the image path contains the 'upload/' directory
                if (strpos($post_image, 'upload/') === 0) {
                    $image_path = "../admin/$post_image"; // Use the image path directly
                } else {
                    $image_path = "../admin/upload/$post_image"; // Prepend 'upload/' directory
                }
                ?>
                <div class="col-md-4">
    <div class="card announcement-card">
        <img src="<?php echo $image_path; ?>" class="card-img-top" alt="Announcement Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $post_title; ?></h5>
            <p class="card-text" id="postDescription"><?php echo $post_description; ?></p>
            <p class="card-text"><small class="text-muted">Posted on <?php echo $post_date; ?></small></p>
            <a href="https://web.facebook.com/sktetuan2023" onclick="toggleDescription()">Visit our page</a>

        </div>
    </div>
</div>

                <?php
            }
        } else {
            echo "<div class='col'><p>No announcements found.</p></div>";
        }
        ?>
    </div>
</div>

<div class="container">
    <div class="location-description">
    <h2 style="color: white; background-image: url('../assets/img/D.png'); padding: 5px; background-size: cover; background-position: center;"><i class="fas fa-map-marker-alt" style="color: black; margin-left: 20px; font-size: 29px; "></i><span style="color: white; font-family: 'Pacifico', cursive; font-size: 2rem;">&nbsp;L</span>ocation</h2>
        <p>Tetuan is situated at approximately 6.9180, 122.0901, in the island of Mindanao. Elevation at these coordinates is estimated at 11.7 meters or 38.4 feet above mean sea level.</p>
    </div>
    <div id="mapid"></div>
</div>


  <main>
  <div class="sk-members-container">
  <h2 style= "background: linear-gradient(to bottom, #007bff, #0056b3); font-family: Arial, sans-serif; padding: 10px; color: white; font-size: 24px; text-align: center;">Sangguniang Kabataan ng Tetuan</h2>
        <hr class="separator">
        <div class="skrow">
            <?php
            include_once "../db_conn.php";

            // Query to select all SK members
            $sql = "SELECT * FROM sk_kagawads";
            $result = mysqli_query($conn, $sql);

            // Display SK members
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col">';
                    echo '<div class="card sk-member-card">';
                    echo '<img src="../admin/'. $row["profile_picture"] . '" class="card-img-top profile-picture" alt="Profile Picture">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title member-name">' . $row["name"] . '</h5>';
                    echo '<p class="card-text member-info">Position: ' . $row["position"] . '</p>';
                    echo '<p class="card-text member-info">Barangay: ' . $row["barangay"] . '</p>';
                    echo '<p class="card-text member-info">Municipality: ' . $row["municipality"] . '</p>';
                    echo '<p class="card-text member-info">Email: ' . $row["email"] . '</p>';
                    echo '<p class="card-text member-info">Contact Number: ' . $row["contact_number"] . '</p>';
                    echo '<p class="card-text member-info">About Me: ' . $row["about_me"] . '</p>';
                    // Add more fields as needed
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-md-12">';
                echo '<p>No SK members found.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

  </main>



  
  <footer>
    
    <div class="wrapper">
      <h2 class="about-us" id="about-us">About Us</h2>
      <p class="about-us-content">
      Welcome to a website of the SK Tetuan! We are dedicated to serving our community with integrity, compassion, and dedication. Through our various initiatives and programs, we strive to create a vibrant and inclusive environment where every member can thrive. Explore our website to learn more about our projects, events, and how you can get involved. Together, let's make a positive difference in our barangay!
      </p>
      <h2 class="about-us" id="about-us">Mission</h2>
      <p class="about-us-content">
      Our mission is to enable the young people of 
            Tetuan, Zamboanga City, by offering an innovative 
            digital platform that encourages their active 
            involvement, promotes transparency, and ensures
            inclusivity in barangay activities. Through this 
            platform, we aim to cultivate a lively and 
            connected community. </p>

            <h2 class="about-us" id="about-us">Vision</h2>
      <p class="about-us-content">
            Our vision is to transform youth engagement in 
            barangay affairs through our SK Website, making
            it the central hub for dynamic communication and 
            collaboration. We strive to create an environment 
            where every youth voice is recognized, valued, and
            actively contributes to the progress and advancement
            of Tetuan. </p>
    </div>
</footer>


 <!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
  // Define Tetuan's coordinates
  var tetuanCoords = [6.9158, 122.0897];

  // Initialize the map centered on Tetuan
  var map = L.map('mapid', {
    center: tetuanCoords,
    zoom: 14,
    maxBounds: [tetuanCoords, tetuanCoords], // Lock the map within Tetuan's bounds
    maxZoom: 18, // Set maximum zoom level
    scrollWheelZoom: false // Disable zooming with mouse scroll
  });

  // Add OpenStreetMap tiles to the map
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Create custom zoom control with only zoom in button
  var zoomControl = L.control.zoom({
    position: 'topright' // Position the zoom control in the top right corner
  });
  map.addControl(zoomControl);

  // Add a marker for Tetuan
  L.marker(tetuanCoords).addTo(map)
    .bindPopup('Tetuan, Zamboanga city, Philippines')
    .openPopup();
</script>

<script>
  // Define the fetchMessages function to retrieve messages from the server
  function fetchMessages() {
    // Your code to fetch messages from the server goes here
    // For example, you might use AJAX or fetch API to make a request to your server
  }

  // Function to toggle the chat box visibility
  function toggleChatBox() {
    var chatBoxContainer = document.getElementById("chat-box-container");
    if (chatBoxContainer.style.display === "none") {
      chatBoxContainer.style.display = "block";
      fetchMessages(); // Call the fetchMessages function when the chat box is shown
    } else {
      chatBoxContainer.style.display = "none";
    }
  }

  // Event listener to toggle chat box when "Message us" option is clicked
  document.addEventListener("DOMContentLoaded", function() {
    var messageUsLink = document.querySelector(".nav-link__message-us");
    if (messageUsLink) {
      messageUsLink.addEventListener("click", function(event) {
        event.preventDefault();
        toggleChatBox();
      });
    }
  });

  // Other JavaScript code...
</script>
<script>
  function showServices() {
    var servicesDropdown = document.getElementById("servicesDropdown");
    servicesDropdown.classList.toggle("show");
  }

  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("adropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
</script>


</body>
</html>
