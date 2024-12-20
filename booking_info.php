<?php
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.html");
    exit;
}

include('dbconnect.php');

// Initialize variables
$error_message = "";
$booking = null;

// Get customer ID from session
$customer_id = $_SESSION['customer_id'];

// Retrieve the latest booking for the specified customer from the database
if (!empty($customer_id)) {
    $sql_latest_booking = "SELECT * FROM bookings WHERE customer_id = '$customer_id' ORDER BY booking_id DESC LIMIT 1";
    $result_latest_booking = $conn->query($sql_latest_booking);

    if ($result_latest_booking) {
        if ($result_latest_booking->num_rows > 0) {
            $booking = $result_latest_booking->fetch_assoc();
        } else {
            $error_message = "No bookings found for the specified customer.";
        }
    } else {
        $error_message = "Error retrieving latest booking: " . $conn->error;
    }
} else {
    $error_message = "Please provide a customer ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Booking Information</title>
    <link rel="stylesheet" href="style1.css">
	
	<header class="header">
       <nav class="navbar">
           <a href="index.html">Home</a>
		   <a href="login.html">Log In</a>
		   <a href="equipment.php">Reserve A Studio</a>
		   <a href="booking_info.php">Booking Info</a>
           <a href="about.html">About</a>
           <a href="contact.html">Contact</a>
           <a href="location.html">Location</a>
           <a href="admin.php">Admin</a>
		   <a href="logout.php">Log Out</a>

		   
       </nav>
       
   </header>
	
</head>
<body background="images/grey orange.png">

    <div class="container">
        <h1>Latest Booking Information</h1>

        <?php if ($booking): ?>
            <!-- Display latest booking information -->
            <div class="booking-details">
                <p><strong>Booking ID:</strong> <?php echo $booking['booking_id']; ?></p>
                <p><strong>Studio:</strong> <?php echo $booking['studio_name']; ?></p>
                <p><strong>Date:</strong> <?php echo $booking['booking_date']; ?></p>
                <p><strong>Time:</strong> <?php echo $booking['booking_time']; ?></p>
                <p><strong>Equipment:</strong> <?php echo $booking['equipment_name']; ?></p>
                <p><strong>Total Cost:</strong> RM <?php echo $booking['total_cost']; ?></p>
                <!-- You can add more details here if needed -->
            </div>
        <?php elseif ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>

</body>
</html>
