<?php
session_start();

// Check if the booking information is stored in the session
if (!isset($_SESSION['booking_info'])) {
    // If not, redirect the user to the reservation page
    header("Location: reservation.php");
    exit();
}

// Retrieve booking information from session
$booking_info = $_SESSION['booking_info'];

// Clear booking information from session
unset($_SESSION['booking_info']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
</head>

<body>
    <h1>Confirmation</h1>
    <p>Your booking details:</p>
    <div>
        <?php echo $booking_info; ?>
    </div>
    <p>Your reservation is confirmed. Thank you!</p>
</body>

</html>
