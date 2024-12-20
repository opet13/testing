<?php
session_start();
include('dbconnect.php');

// Check if total_cost and booking_id are provided in the URL parameters
if(isset($_GET['total_cost']) && isset($_GET['booking_id'])) {
    $total_cost = $_GET['total_cost'];
    $booking_id = $_GET['booking_id'];
} else {
    echo "Debugging: Error - Total cost or booking ID not provided.";
    exit();
}

// Debug: Output values of $booking_id and $total_cost
echo "Booking ID: " . $booking_id . "<br>";
echo "Total Cost: " . $total_cost . "<br>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <h1>Payment</h1>
    <p>Total Cost: RM <?php echo $total_cost; ?></p>
    <form action="process_payment.php" method="post">
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        <input type="hidden" name="total_cost" value="<?php echo $total_cost; ?>">
        <button type="submit">Pay with Cash</button>
    </form>
</body>
</html>
