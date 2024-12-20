<?php
session_start();
include('dbconnect.php');

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username_admin'])) {
    header("Location: login_admin.html");
    exit();
}
	

// Retrieve bookings from the database
$sql_bookings = "SELECT * FROM bookings";
$result_bookings = $conn->query($sql_bookings);

// Retrieve equipment details from the database
$sql_equipment = "SELECT * FROM equipment";
$result_equipment = $conn->query($sql_equipment);


// Retrieve payments from the database
$sql_payments = "SELECT * FROM payments";
$result_payments = $conn->query($sql_payments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body background="images/grey orange.png">
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
       
   </header>

    <h1>Admin Panel</h1>

    <h2>Bookings</h2>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Customer ID</th>
            <th>Studio</th>
            <th>Equipment</th>
            <th>Date</th>
            <th>Time</th>
            <th>Fine Amount</th>
            <th>Fine Description</th>
            <th>Edit</th>
        </tr>
        <?php
        if ($result_bookings && $result_bookings->num_rows > 0) {
            while ($row = $result_bookings->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['booking_id'] . "</td>";
                echo "<td>" . $row['customer_id'] . "</td>";
                echo "<td>" . $row['studio_name'] . "</td>";
                echo "<td>" . $row['equipment_name']  . "</td>";
                echo "<td>" . $row['booking_date'] . "</td>";
                echo "<td>" . $row['booking_time'] . "</td>";
                echo "<td>" . $row['fine_amount'] . "</td>"; // Display fine amount
                echo "<td>" . $row['fine_description'] . "</td>"; // Display fine description
                echo "<td><a href='edit_booking.php?id=" . $row['booking_id'] . "'>Edit</a></td>"; // Link to edit_booking.php with booking_id as parameter
                echo "</tr>";
            }
        }
        ?>
    </table>
	
	<h2>Payments</h2>
    <table>
        <tr>
            <th>Payment ID</th>
            <th>Booking ID</th>
            <th>Amount Paid</th>
            <th>Payment Date</th>
            <th>Edit</th>
        </tr>
        <?php
        if ($result_payments && $result_payments->num_rows > 0) {
            while ($row = $result_payments->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['payment_id'] . "</td>";
                echo "<td>" . $row['booking_id'] . "</td>";
                echo "<td>" . $row['payment_status'] . "</td>";
                echo "<td>" . $row['payment_date'] . "</td>";
                echo "<td><a href='edit_payment.php?id=" . $row['payment_id'] . "'>Edit</a></td>"; // Link to edit_payment.php with payment_id as parameter
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No payments found.</td></tr>";
        }
        ?>
    </table>
	

    <h2>Equipment</h2>
    <table>
        <tr>
            <th>Equipment ID</th>
            <th>Name</th>
            <th>Condition</th>
            <th>Edit</th>
        </tr>
        <?php
        if ($result_equipment && $result_equipment->num_rows > 0) {
            while ($row = $result_equipment->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['equipment_id'] . "</td>";
                echo "<td>" . $row['equipment_name'] . "</td>";
                echo "<td>" . $row['equipment_condition'] . "</td>";
                echo "<td><a href='edit_equipment.php?id=" . $row['equipment_id'] . "'>Edit</a></td>"; // Link to edit_equipment.php with equipment_id as parameter
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No equipment found.</td></tr>";
        }
        ?>
    </table>
    
    <div class="link">
        <a href="index.php">Go to Home</a>
    </div>
</body>
</html>
