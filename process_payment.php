<?php
session_start();
include('dbconnect.php');

// Check if booking ID and total cost are provided in the POST data
if(isset($_POST['booking_id']) && isset($_POST['total_cost'])) {
    $booking_id = $_POST['booking_id'];
    $total_cost = $_POST['total_cost'];

    // Insert payment details into the database
    $payment_date = date("Y-m-d H:i:s");
    $sql_insert_payment = "INSERT INTO payments (booking_id, amount, payment_date, payment_status) VALUES (?, ?, ?, 'Unpaid')";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql_insert_payment);
    $stmt->bind_param("ids", $booking_id, $total_cost, $payment_date);

    // Execute the statement
    if ($stmt->execute()) {
        // Payment successfully inserted
        unset($_SESSION['booking_id']); // Unset booking ID from session
        unset($_SESSION['total_cost']); // Unset total cost from session
        header("Location: payment_success.php");
        exit();
    } else {
        // Error inserting payment
        echo "Error inserting payment record: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Error: Booking ID or total cost not provided
    echo "Error: Booking ID or total cost not provided.";
}

$conn->close();
?>
