<?php
// Include dbconnect.php to establish database connection
include('dbconnect.php');

// Retrieve pending bookings from the database
$sql = "SELECT * FROM bookings WHERE item_condition_verification IS NULL";
$result = $conn->query($sql);

// Check if there are pending bookings
if ($result->num_rows > 0) {
    // Display table header
    echo "<table>";
    echo "<tr><th>Booking ID</th><th>Customer ID</th><th>Studio</th><th>Date</th><th>Time</th><th>Action</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["booking_id"] . "</td>";
        echo "<td>" . $row["customer_id"] . "</td>";
        echo "<td>" . $row["studio_name"] . "</td>";
        echo "<td>" . $row["booking_date"] . "</td>";
        echo "<td>" . $row["booking_time"] . "</td>";
        // Provide a button or link to update_booking.php for verification
        echo "<td><a href='update_booking.php?booking_id=" . $row["booking_id"] . "'>Verify Items</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No pending bookings.";
}

// Close database connection
$conn->close();
?>
