<?php
// Include database connection file
include '../db_conn.php';

// Fetch search term from GET request
$searchTerm = $_GET['search'];

// Prepare SQL query to search for users based on the search term
$query = "SELECT * FROM users 
          WHERE approved = 1 
          AND (first_name LIKE '%$searchTerm%' 
               OR last_name LIKE '%$searchTerm%' 
               OR email LIKE '%$searchTerm%' 
               OR phone_number LIKE '%$searchTerm%'
               OR purok LIKE '%$searchTerm%'
               OR sex LIKE '%$searchTerm%')";

$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Display the filtered table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['first_name']} {$row['middle_name']} {$row['last_name']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>{$row['phone_number']}</td>";
    echo "<td>{$row['purok']}</td>";
    // Calculate age based on birthdate
    $birthdate = new DateTime($row['birthday']);
    $today = new DateTime();
    $age = $birthdate->diff($today)->y;
    echo "<td>{$age}</td>";
    echo "<td>{$row['gender']}</td>";
    echo "</tr>";
}

// Close database connection
mysqli_close($conn);
?>
