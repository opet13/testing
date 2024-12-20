<?php
session_start();
include('dbconnect.php');

// Check if payment ID is provided
if (!isset($_GET['id'])) {
    echo "Payment ID not provided.";
    exit;
}

$payment_id = $_GET['id'];

// Retrieve payment details from the database
$sql_payment_details = "SELECT * FROM payments WHERE payment_id = $payment_id";
$result_payment_details = $conn->query($sql_payment_details);

if ($result_payment_details->num_rows == 0) {
    echo "Payment not found.";
    exit;
}

$row = $result_payment_details->fetch_assoc();

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve and sanitize form data
    // Note: You should perform proper validation and sanitization here
    $payment_status = $_POST['payment_status'];
    $payment_date = $_POST['payment_date'];

    // Update payment details in the database
    $sql_update_payment = "UPDATE payments SET 
                            payment_status = '$payment_status',
                            payment_date = '$payment_date'
                            WHERE payment_id = $payment_id";

    if ($conn->query($sql_update_payment) === TRUE) {
        echo "Payment updated successfully.";
    } else {
        echo "Error updating payment: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment</title>
</head>
<body>
    <h1>Edit Payment</h1>

    <form method="post" action="">
        <label for="payment_status">Payment Status:</label><br>
        <input type="text" id="payment_status" name="payment_status" value="<?php echo $row['payment_status']; ?>"><br>
        
        <label for="payment_date">Payment Date:</label><br>
        <input type="date" id="payment_date" name="payment_date" value="<?php echo $row['payment_date']; ?>"><br>
        
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
