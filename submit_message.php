<?php
// Include the database connection file
include 'dbconnect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the message is set and not empty
    if (isset($_POST["message"]) && !empty($_POST["message"])) {
        // Prepare SQL statement
        $sql = "INSERT INTO messages (message) VALUES (?)";

        // Prepare and bind parameters
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $message);

            // Set parameters
            $message = $_POST["message"];

            // Execute the statement
            if ($stmt->execute()) {
                echo "Message inserted successfully.";
            } else {
                echo "Error: " . $conn->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Message is required.";
    }
} else {
    echo "Invalid request.";
}

// Close connection
$conn->close();
?>
