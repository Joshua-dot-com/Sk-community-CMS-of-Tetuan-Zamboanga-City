<?php
session_start();

// Check if the form data is received via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include('../../db_conn.php');

    // Check if the user is logged in
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        echo "You are not logged in.";
        exit;
    }

    // Get user ID from session
    $userID = $_SESSION['user_id'];

    // Retrieve form data
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_reason = $_POST['appointment_reason'];

    // Calculate end time for the appointment (2-hour interval)
    $appointment_end_time = date('H:i:s', strtotime($appointment_time . ' + 2 hours'));

    // Check if there are any appointments within a 2-hour range of the selected time
    $sql_check_interval = "SELECT * FROM appointments WHERE appointment_date = '$appointment_date' 
                           AND status = 'approved' 
                           AND (
                                (appointment_time < '$appointment_end_time' AND '$appointment_time' < appointment_end_time)
                                OR 
                                (appointment_time < '$appointment_end_time' AND '$appointment_end_time' < appointment_end_time)
                                OR 
                                (appointment_time >= '$appointment_time' AND appointment_time < '$appointment_end_time')
                           )";
    $result_check_interval = mysqli_query($conn, $sql_check_interval);

    if ($result_check_interval) {
        // If there are appointments within the 2-hour interval, suggest choosing another time
        if (mysqli_num_rows($result_check_interval) > 0) {
            echo "There are appointments already scheduled during this time. Please choose another time.";
        } else {
            // Insert the appointment data into the database
            $sql_insert = "INSERT INTO appointments (user_id, appointment_date, appointment_time, appointment_end_time, reason, status) 
                           VALUES ('$userID', '$appointment_date', '$appointment_time', '$appointment_end_time', '$appointment_reason', 'pending')";

            if (mysqli_query($conn, $sql_insert)) {
                echo "Request Appointment Succesfully. ";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If the request method is not POST, redirect to the appointment page
    header("Location: appointment.php");
    exit;
}
?>
