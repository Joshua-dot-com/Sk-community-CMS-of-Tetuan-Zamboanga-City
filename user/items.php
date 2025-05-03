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

// Check if the user already has a borrowed item
$borrowCheckSql = "SELECT * FROM borrow WHERE user_id = ?";
$borrowCheckStmt = $conn->prepare($borrowCheckSql);
$borrowCheckStmt->bind_param('i', $userID);
$borrowCheckStmt->execute();
$borrowResult = $borrowCheckStmt->get_result();
$borrowedItemExists = $borrowResult->num_rows > 0;
// Close the prepared statement
$borrowCheckStmt->close();
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
    <link rel="stylesheet" href="css/item.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
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
                    <a href="report.php">Appointment</a>
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
    <div class="item-container">
    <?php
// SQL query to retrieve items from the database
$query = "SELECT items.id, items.name AS itemName, items.quantity, categories.name AS categoryName, items.photo_path
          FROM items
          INNER JOIN categories ON items.category_id = categories.id
          WHERE items.quantity > 0"; // Filter out items with quantity 0
$result = mysqli_query($conn, $query);

// Check if there are any items
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='col-md-4'>";
        echo "<div class='card item-card'";
        echo " onclick='openModal(" . $row['id'] . ", \"" . $row['itemName'] . "\")'>"; // Pass the item ID and name here
        echo "<img src='../admin/" . $row["photo_path"] . "' class='card-img-top' alt='Item Photo'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row["itemName"] . "</h5>";
        echo "<p class='card-text'>Quantity: " . $row["quantity"] . "</p>";
        echo "<p class='card-text'>Category: " . $row["categoryName"] . "</p>";
        // Add more details if needed
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No items available</p>";
}
?>

    </div>

</main>

<footer>
    <!-- Your footer content goes here -->
</footer>


<!-- Borrow Modal -->
<div id="borrowModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="borrowTitle">Borrow Item</h2>
        <form id="borrowForm"> <!-- Remove action attribute -->
            <!-- Hidden input to store the item ID -->
            <input type="hidden" id="selectedItemId" name="item_id">
            <!-- Display the selected item name -->
            <label for="selectedItem">Selected Item:</label>
            <input type="text" id="selectedItem" name="selectedItem" readonly>
            <!-- Quantity input -->
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" required>
            <!-- Borrow Date input -->
            <label for="borrowDate">Borrow Date:</label>
            <input type="date" id="borrowDate" name="borrowDate" required>
            <!-- Return Date input -->
            <label for="returnDate">Return Date:</label>
            <input type="date" id="returnDate" name="returnDate" required>
            <!-- Submit button -->
            <input type="button" value="Submit" onclick="submitForm()">
        </form>
    </div>
</div>


<script>
  function openModal(itemId, itemName) {
    console.log("Opening modal for item ID:", itemId);
    console.log("Item Name:", itemName);
    
    // Populate hidden input field with item ID
    document.getElementById('selectedItemId').value = itemId;
    // Populate input field with item name
    document.getElementById('selectedItem').value = itemName;
    // Set the item name in the modal title
    document.getElementById('borrowTitle').innerText = "Borrow Item: " + itemName;
    // Display the modal
    document.getElementById('borrowModal').style.display = 'block';
}

    // Function to close the modal
    function closeModal() {
        // Hide the modal
        document.getElementById('borrowModal').style.display = 'none';
    }

    // Function to toggle logout dropdown
    function toggleLogout() {
        var dropdownContent = document.getElementById("logoutDropdown");
        dropdownContent.classList.toggle("show");
    }

    // Function to submit the borrowing form via AJAX
    function submitForm() {
    // Display a confirmation dialog
    var confirmation = confirm("Are you sure you want to borrow this item?");
    if (!confirmation) {
        return; // Cancel submission if the user cancels the confirmation
    }


        var itemId = document.getElementById('selectedItemId').value;
        var quantity = document.getElementById('quantity').value;
        var borrowDate = document.getElementById('borrowDate').value;
        var returnDate = document.getElementById('returnDate').value;

        var formData = new FormData();
        formData.append('item_id', itemId);
        formData.append('quantity', quantity);
        formData.append('borrowDate', borrowDate);
        formData.append('returnDate', returnDate);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'function/borrow_item.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Item borrowed successfully!');  
                    closeModal();
                    location.reload();  
                } else {
                    alert(response.error);
                }
            }
        };
        xhr.send(formData);
    }

</script>

</body>

</html>
