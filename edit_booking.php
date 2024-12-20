<?php
session_start();
include('dbconnect.php');

// Check if booking ID is provided
if (!isset($_GET['id'])) {
    echo "Booking ID not provided.";
    exit;
}

$booking_id = $_GET['id'];

// Retrieve booking details from the database
$sql_booking_details = "SELECT * FROM bookings WHERE booking_id = $booking_id";
$result_booking_details = $conn->query($sql_booking_details);

if ($result_booking_details->num_rows == 0) {
    echo "Booking not found.";
    exit;
}

$row = $result_booking_details->fetch_assoc();

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve and sanitize form data
    // Note: You should perform proper validation and sanitization here
    $customer_id = $_POST['customer_id'];
    $studio_name = $_POST['studio_name'];
    $equipment_name = $_POST['equipment_name'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $fine_amount = $_POST['fine_amount'];
    $fine_description = $_POST['fine_description']; // Add this line to retrieve fine description

    // Update booking details in the database
    $sql_update_booking = "UPDATE bookings SET 
                            customer_id = '$customer_id',
                            studio_name = '$studio_name',
                            equipment_name = '$equipment_name',
                            booking_date = '$booking_date',
                            booking_time = '$booking_time',
                            fine_amount = '$fine_amount',
                            fine_description = '$fine_description' 
                            WHERE booking_id = $booking_id";

    if ($conn->query($sql_update_booking) === TRUE) {
        echo "Booking updated successfully.";
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}


// Handle remove action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
    // Delete the booking
    $sql_delete_booking = "DELETE FROM bookings WHERE booking_id = $booking_id";

    if ($conn->query($sql_delete_booking) === TRUE) {
        echo "Booking removed successfully.";
        exit; // exit after deleting
    } else {
        echo "Error removing booking: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<body>
    <h1>Edit Booking</h1>

    <form method="post" action="">
        <label for="customer_id">Customer ID:</label><br>
        <input type="text" id="customer_id" name="customer_id" value="<?php echo $row['customer_id']; ?>"><br>
        
        <label for="studio_name">Studio:</label><br>
        <input type="text" id="studio_name" name="studio_name" value="<?php echo $row['studio_name']; ?>"><br>
        
        <label for="equipment_name">Equipment:</label><br>
        <input type="text" id="equipment_name" name="equipment_name" value="<?php echo $row['equipment_name']; ?>"><br>
        
        <label for="booking_date">Date:</label><br>
        <input type="date" id="booking_date" name="booking_date" value="<?php echo $row['booking_date']; ?>"><br>
        
        <label for="booking_time">Time:</label><br>
        <input type="time" id="booking_time" name="booking_time" value="<?php echo $row['booking_time']; ?>"><br>
        
        <label for="fine_amount">Fine Amount:</label><br>
        <input type="text" id="fine_amount" name="fine_amount" value="<?php echo $row['fine_amount']; ?>"><br>
        
        <label for="fine_description">Fine Description:</label><br>
        <input type="text" id="fine_description" name="fine_description" value="<?php echo $row['fine_description']; ?>"><br>
        
        <input type="submit" name="update" value="Update">
        <button type="submit" name="remove" onclick="return confirm('Are you sure you want to remove this booking?')">Remove</button>
    </form>
</body>
</html>
