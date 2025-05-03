<?php
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if appointment ID and reason are provided
    if (isset($_POST["id"]) && isset($_POST["reason"])) {
        $appointmentId = $_POST["id"];
        $rejectionReason = $_POST["reason"];

        // Update the appointment status with rejection reason
        $updateQuery = "UPDATE appointments SET is_approved = false WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "i", $appointmentId);

        if (mysqli_stmt_execute($stmt)) {
            // Rejection successful, now insert rejection reason
            $insertQuery = "INSERT INTO rejection_reasons (appointment_id, reason) VALUES (?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt_insert, "is", $appointmentId, $rejectionReason);

            if (mysqli_stmt_execute($stmt_insert)) {
                // Insertion successful
                echo "success";
            } else {
                // Error occurred during insertion
                echo "error";
            }

            mysqli_stmt_close($stmt_insert);
        } else {
            // Error occurred during rejection
            echo "error";
        }

        mysqli_stmt_close($stmt);
    } else {
        // Missing parameters
        echo "error";
    }
} else {
    // Invalid request method
    echo "error";
}

mysqli_close($conn);
?>
