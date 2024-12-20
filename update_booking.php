<?php
// Include dbconnect.php to establish database connection
include('dbconnect.php');

// Check if booking_id is provided via GET parameter
if(isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

   
     $verification_status = 'Verified';
     $fine_amount = 10.00;
     $fine_description = 'Damaged item';
    
    // SQL query to update the booking with verification status and fines
    $sql = "UPDATE bookings SET item_condition_verification = '$verification_status', fine_amount = $fine_amount, fine_description = '$fine_description' WHERE booking_id = $booking_id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect back to view_bookings.php after verification
        header("Location: view_bookings.php");
        exit();
    } else {
        // Handle database error
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Handle missing booking ID
    echo "Booking ID not provided.";
}

// Close database connection
$conn->close();
?>
