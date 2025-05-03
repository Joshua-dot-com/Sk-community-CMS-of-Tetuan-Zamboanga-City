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
    <link rel="stylesheet" href="css/item.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .floating-back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
        }

        .container {
            display: flex;
            margin-top: 20px;
        }

        .user-container {
            flex: 1;
            margin-right: 10px;
            display: flex;
            flex-direction: column;
        }

        .status-container {
            flex: 1;
            margin-left: 10px;
            display: flex;
            flex-direction: column;
        }

        .user_card,
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%; /* Adjust width as needed */
            max-width: 400px; /* Adjust maximum width as needed */
        }

        /* Style for user card */
        .user-card {
            background-color: #f5f5f5;
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

<div class="user-container">
    <div class="user_card">
        <div class="user-header">
            User Information
        </div>
        <div class="user-body">
            <p><strong>User ID:</strong> <?php echo $userID; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
            <p><strong>Name:</strong> <?php echo isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest'; ?></p>
            <?php
                // Fetch additional user information from the database
                $sql = "SELECT * FROM users WHERE id = $userID";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p><strong>Middle Name:</strong> " . $row['middle_name'] . "</p>";
                    echo "<p><strong>Last Name:</strong> " . $row['last_name'] . "</p>";
                    echo "<p><strong>Phone Number:</strong> " . $row['phone_number'] . "</p>";
                    echo "<p><strong>Purok:</strong> " . $row['purok'] . "</p>";
                    echo "<p><strong>Birthday:</strong> " . $row['birthday'] . "</p>";
                    echo "<p><strong>Sex:</strong> " . ucfirst($row['sex']) . "</p>";
                    echo "<p><strong>Marital Status:</strong> " . ucfirst($row['marital_status']) . "</p>";
                    echo "<p><strong>Has Child:</strong> " . ucfirst($row['has_child']) . "</p>";
                } else {
                    echo "<p>No additional information found.</p>";
                }
            ?>
        </div>
    </div>
</div>

<!-- Status Card -->
<div class="card-status">
    <div class="status-header">
        Status
    </div>
    <div class="status-body">
        <!-- Display items borrowed -->
        <?php
    $itemsQuery = "SELECT b.*, i.name AS item_name
                   FROM borrow b 
                   JOIN items i ON b.item_id = i.id
                   WHERE b.user_id = $userID";
    $itemsResult = mysqli_query($conn, $itemsQuery);
    
    if (!$itemsResult) {
        // Query failed, display error message
        echo "Error: " . mysqli_error($conn);
    } else {
        // Query executed successfully, check if any rows are returned
        if (mysqli_num_rows($itemsResult) > 0) {
            echo "<p><strong>Items Borrowed:</strong></p>";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($itemsResult)) {
                echo "<li>" . $row['item_name'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No items borrowed.</p>";
        }
    }
?>


        
        <!-- Display total number of reports sent -->
        <?php
            $reportsQuery = "SELECT COUNT(*) AS total_reports FROM reports WHERE user_id = $userID";
            $reportsResult = mysqli_query($conn, $reportsQuery);
            $reportsRow = mysqli_fetch_assoc($reportsResult);
            $totalReports = $reportsRow['total_reports'];
            
            echo "<p><strong>Total Reports Sent:</strong> $totalReports</p>";
        ?>
        
        <!-- Display status of appointment -->
        <?php
    $appointmentQuery = "SELECT status FROM appointments WHERE user_id = $userID";
    $appointmentResult = mysqli_query($conn, $appointmentQuery);
    
    if (mysqli_num_rows($appointmentResult) > 0) {
        $row = mysqli_fetch_assoc($appointmentResult);
        $appointmentStatus = $row['status']; // Fetch status from the 'status' column
        echo "<p><strong>Appointment Status:</strong> $appointmentStatus</p>";
    } else {
        echo "<p>No appointment scheduled.</p>";
    }
?>

    </div>
</div>

</body>
</html>