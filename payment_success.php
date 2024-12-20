<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Success</title>
</head>
<body>
    <h1>Reservation Successful</h1>
    
	<a href="index.html"><button>Go to Homepage</button></a>
<script>
        // Display alert for successful reservation
        alert("Reservation Successfully");
    </script>
    <?php
    // Include dbconnect.php to establish database connection
    include('dbconnect.php');

    // Retrieve booking information for the customer
    // Assuming you have stored booking_id in session or passed it via GET/POST parameter

    if(isset($_SESSION['booking_id'])) {
        $booking_id = $_SESSION['booking_id'];
        
        // Retrieve booking details from the database
        $sql = "SELECT * FROM bookings WHERE booking_id = $booking_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output booking details and notify customer about fines
            while ($row = $result->fetch_assoc()) {
                echo "<p>Booking ID: " . $row["booking_id"] . "</p>";
                echo "<p>Studio: " . $row["studio_name"] . "</p>";
                echo "<p>Date: " . $row["booking_date"] . "</p>";
                echo "<p>Time: " . $row["booking_time"] . "</p>";
                // Check if fine_amount is not null and notify customer about fines
                if($row["fine_amount"] != null) {
                    echo "<p>Additional Charges: RM " . $row["fine_amount"] . " (" . $row["fine_description"] . ")</p>";
                    // Send notification email to customer about fines
                    // You can use PHP's mail function or a library like PHPMailer for sending emails
                }
            }
        } else {
            echo "<p>No booking found.</p>";
        }
    }

    // Close database connection
    $conn->close();
    ?>
	

    
</body>
</html>
