<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SK | tetuan</title>
  <link rel="icon" type="image/x-icon" href="assets/img/sklogo.png">
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="fonts.css">
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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


  </style>
  </head>
<body>
<a href="user/emergency.html" class="floating-button">Emergency Hotline</a>

<nav class="nav-bar">

    <div class="wrapper">
      <div class="nav-bar__logo-wrapper">
        <img class="nav-bar__logo" src="assets/img/sklogo.png" alt="logo">
        <p class="nav-bar__logo-abbrev"></p>
        <p class="nav-bar__logo-name"></p>
      </div>

    <!-- Your HTML -->
<!-- Your HTML -->
<div class="nav-link">
    <a class="nav-link__about" href="#about-us">About us</a>
    <a class="nav-link__submit" href="#" id="submitLink">
        <i class="fas fa-comment"></i> <!-- Font Awesome comment icon -->
    </a>
    <a class="nav-link__explore" href="forms/login.php">Log in</a>
</div>

<div class="modal" id="submissionModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit your comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="submissionModalBody">
                <!-- Your submission form here -->
                <form id="commentForm" action="process_submission.php" method="post">
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>




      
    </div>
  </nav>

  <header>
  <div class="splash">
  <div class="splash-inner">
    <img class="splash-image" src="assets/img/2.png" alt="Image 1">
    <img class="splash-image" src="assets/img/bg2.png" alt="Image 2">
    <img class="splash-image" src="assets/img/bg3.png" alt="Image 3">
    <img class="splash-image" src="assets/img/1.png" alt="Image 4">
    <img class="splash-image" src="assets/img/2.png" alt="Image 5">
    <img class="splash-image" src="assets/img/bg2.png" alt="Image 6">
    <img class="splash-image" src="assets/img/bg3.png" alt="Image 7">
    <img class="splash-image" src="assets/img/1.png" alt="Image 8">
    <img class="splash-image" src="assets/img/2.png" alt="Image 9">
    <img class="splash-image" src="assets/img/bg2.png" alt="Image 10">
    
  </div>
</div>
        
  </header>

  <div class="container">
  <h2 class="mb-4" style="display: flex; align-items: center; color:white; padding: 5px; background-image: url('assets/img/c.png'); background-size: cover; background-position: center;"><span style="color: white; font-family: 'Pacifico', cursive; font-size: 2rem;">&nbsp;N</span>ews & Announcements</h2>
<hr style="background-color: black; margin-left: 10px; margin-bottom: 10px; flex: 1; height: 3px;">


  <div class="row">
        <?php
        // Include database connection
        include 'db_conn.php';

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
                    $image_path = "admin/$post_image"; // Use the image path directly
                } else {
                    $image_path = "admin/upload/$post_image"; // Prepend 'upload/' directory
                }
                ?>
                <div class="col-md-4">
                    <div class="card announcement-card">
                        <img src="<?php echo $image_path; ?>" class="card-img-top" alt="Announcement Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $post_title; ?></h5>
                            <p class="card-text"><?php echo $post_description; ?></p>
                            <p class="card-text"><small class="text-muted">Posted on <?php echo $post_date; ?></small></p>
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
      <br><br><br><br>
      <div class="location-description">
    <h2 style="color: white; background-image: url('assets/img/D.png'); padding: 5px; background-size: cover; background-position: center;"><i class="fas fa-map-marker-alt" style="color: black; margin-left: 10px; font-size: 29px; "></i><span style="color: white; font-family: 'Pacifico', cursive; font-size: 2rem;">&nbsp;L</span>ocation</h2>
        <p>Tetuan is situated at approximately 6.9180, 122.0901, in the island of Mindanao. Elevation at these coordinates is estimated at 11.7 meters or 38.4 feet above mean sea level.</p>
    </div>
    <div id="mapid"></div>
</div>
<br><br><br><br><br>

<main>
  <div class="sk-members-container">
        <h2 style= "background: linear-gradient(to bottom, #007bff, #0056b3); font-family: Arial, sans-serif; padding: 10px; color: white; font-size: 24px; text-align: center;">Sangguniang Kabataan ng Tetuan</h2>
        <hr class="separator">
        <div class="skrow">
            <?php
            include_once "db_conn.php";

            // Query to select all SK members
            $sql = "SELECT * FROM sk_kagawads";
            $result = mysqli_query($conn, $sql);

            // Display SK members
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col">';
                    echo '<div class="card sk-member-card">';
                    echo '<img src="admin/'. $row["profile_picture"] . '" class="card-img-top profile-picture" alt="Profile Picture">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title MEMBER-NAME">' . strtoupper($row["name"]) . '</h5>';
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
      <br><br><br><br>
      <h2 class="about-us" id="about-us">About Us</h2>
      <p class="about-us-content" style="margin-bottom: 110px;">
      Welcome to a website of the SK Tetuan! We are dedicated to serving our community with integrity, compassion, and dedication. Through our various initiatives and programs, we strive to create a vibrant and inclusive environment where every member can thrive. Explore our website to learn more about our projects, events, and how you can get involved. Together, let's make a positive difference in our barangay!
      </p>
    </div>
</footer>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var submitLink = document.getElementById('submitLink');
        var modal = document.getElementById('submissionModal');
        var closeButton = modal.querySelector('.close');

        submitLink.addEventListener('click', function() {
            modal.style.display = 'block';
        });

        // Close modal when clicking on the close button
        closeButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside the modal
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });

        // Submit the form via AJAX when submitted
        $('#commentForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var confirmSubmit = confirm("Are you sure you want to submit this ?");

            var comment = $('#comment').val(); // Get the comment from the form

            $.ajax({
                type: 'POST',
                url: 'process_submission.php',
                data: {comment: comment},
                success: function(response) {
                    alert(response); // Display the response message
                    modal.style.display = 'none'; // Close the modal
                    $('#comment').val(''); // Clear the comment textarea
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


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


</body>
</html>