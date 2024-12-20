<?php
session_start();
include('dbconnect.php');

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Function to check availability of a date
function checkAvailability($date, $conn) {
    $sql_check = "SELECT * FROM bookings WHERE booking_date = '$date'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        return false; // Date not available
    } else {
        return true; // Date available
    }
}

// Initialize the error message variable
$error_message = "";

// Fetch available dates
$sql_available_dates = "SELECT DISTINCT booking_date FROM bookings";
$result_available_dates = $conn->query($sql_available_dates);
$available_dates = array();
if ($result_available_dates->num_rows > 0) {
    while ($row = $result_available_dates->fetch_assoc()) {
        $available_dates[] = $row['booking_date'];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $studio = $_POST['studio'];
    $equipment = isset($_POST['equipment']) ? $_POST['equipment'] : array();

    // Calculate extra fee based on selected equipment
    $extra_fee = 0;
    foreach ($equipment as $item) {
        if ($item === "Speaker" || $item === "Mirror") {
            $extra_fee += 15.00; // Extra fee for Speaker and Mirror
        } elseif ($item === "Tap Shoes" || $item === "Hard Shoes") {
            $extra_fee += 100.00; // Extra fee for Tap Shoes and Hard Shoes
        } elseif ($item === "Clogging Shoes") {
            $extra_fee += 120.00; // Extra fee for Clogging Shoes
        }
    }

    // Calculate price based on studio selected
    switch ($studio) {
        case "Tap Dance":
        case "Irish Dance":
            $price = 40.00;
            break;
        case "Clogging Dance":
            $price = 50.00;
            break;
        default:
            $price = 0.00; // Default price if studio not recognized
    }

    // Calculate total cost based on studio price and extra fee
    $total_cost = $price + $extra_fee;

    // Get customer ID based on username
    $username = $_SESSION['username'];
    $sql_customer = "SELECT customer_id FROM login WHERE username='$username'";
    $result_customer = $conn->query($sql_customer);

    if ($result_customer->num_rows > 0) {
        $row_customer = $result_customer->fetch_assoc();
        $customer_id = $row_customer['customer_id'];

        // Check availability of selected date
        if (!checkAvailability($date, $conn)) {
            $error_message = "The selected date is not available. Please choose a different date.";
        } else {
            // Insert reservation into database with extra fee
            $sql_reserve = "INSERT INTO bookings (customer_id, studio_name, equipment_name, extra_fee, total_cost, booking_date, booking_time) VALUES ('$customer_id', '$studio', '" . implode(',', $equipment) . "', '$extra_fee', '$total_cost', '$date', '$time')";

            if ($conn->query($sql_reserve) === TRUE) {
                // Reservation successfully inserted
                $booking_id = $conn->insert_id;
                $_SESSION['booking_id'] = $booking_id;
                header("Location: payment.php?total_cost=" . urlencode($total_cost) . "&booking_id=" . urlencode($booking_id));
                exit();
            } else {
                // Check if the error is due to duplicate entry
                if ($conn->errno == 1062) {
                    $error_message = "The selected date is already booked. Please choose a different date.";
                } else {
                    $error_message = "Error: " . $conn->error;
                }
                error_log("Error inserting reservation record: " . $conn->error);
            }
        }
    } else {
        // Customer ID not found
        $error_message = "Error: Customer ID not found.";
        error_log("Error: Customer ID not found for username: $username");
    }
}

?>

<html>

<head>
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
    <title>Make a Reservation</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body background="images/grey orange.png">

    <!-- Display table of availability dates -->
    <h2>Availability Dates</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($available_dates as $date): ?>
            <tr>
                <td class="date"><?php echo $date; ?></td>
                <td class="status">
                    <div class="<?php echo checkAvailability($date, $conn) ? '' : 'not-available'; ?>">
                        <?php echo checkAvailability($date, $conn) ? 'Available' : 'Not Available'; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Display error message if exists -->
    <?php if (!empty($error_message)): ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form id="reservationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table>
        <tr>
            <td><label for="date">Date:</label></td>
            <td><input type="date" name="date" id="date" required></td>
        </tr>
        <tr>
            <td><label for="time">Time:</label></td>
            <td><input type="time" name="time" id="time" required></td>
        </tr>
        <tr>
            <td><label for="studio">Select Studio:</label></td>
            <td>
                <select type="studio" name="studio" id="studio" required>
                    <option value="Tap Dance">Tap Dance</option>
                    <option value="Irish Dance">Irish Dance</option>
                    <option value="Clogging Dance">Clogging Dance</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Select Equipment:</label></td>
            <td>
                <div id="equipmentContainer" class="checkbox-group">
                    <input type="checkbox" id="speaker" name="equipment[]" value="Speaker">
                    <label class="checkbox-label" for="speaker">Speaker (Extra Fee: RM 15.00)</label><br>
                    <input type="checkbox" id="mirror" name="equipment[]" value="Mirror">
                    <label class="checkbox-label" for="mirror">Mirror (Extra Fee: RM 15.00)</label><br>
                    <input type="checkbox" id="tap_shoes" name="equipment[]" value="Tap Shoes">
                    <label class="checkbox-label" for="tap_shoes">Tap Shoes For 15 Person (Extra Fee: RM 100.00)</label><br>
                    <input type="checkbox" id="hard_shoes" name="equipment[]" value="Hard Shoes">
                    <label class="checkbox-label" for="hard_shoes">Hard Shoes For 15 Person (Extra Fee: RM 100.00)</label><br>
                    <input type="checkbox" id="clogging_shoes" name="equipment[]" value="Clogging Shoes">
                    <label class="checkbox-label" for="clogging_shoes">Clogging Shoes For 15 Person (Extra Fee : RM 120.00)</label><br>
                </div>
            </td>
        </tr>
    </table>
	
    <div class="total-cost-container">
        <h2>Total Cost: RM <span id="totalCost">0.00</span></h2>
    </div>
	
	
    <div class="form-container">
        <input type="submit" value="Reserve">
    </div>
</form>


    <script src="total_cost1.js"></script>


</body>

<footer>
    &copy; 2024 1DANCE STUDIO. All rights reserved.
</footer>

</html>

