<?php
include('dbconnect.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize flag for successful registration
$registration_successful = false;

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert user data into the database
    $sql = "INSERT INTO customers (customer_name, customer_email, customer_phone) VALUES ('$name', '$email', '$phone')";
    if ($conn->query($sql) === TRUE) {
        $customer_id = $conn->insert_id;
        $sql_login = "INSERT INTO login (username, password, customer_id) VALUES ('$username', '$password', '$customer_id')";
        if ($conn->query($sql_login) === TRUE) {
            // Set flag for successful registration
            $registration_successful = true;
        } else {
            echo "Error: " . $sql_login . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <script>
        // JavaScript function to display alert message after page load
        window.onload = function() {
            <?php
            // Check if registration was successful
            if ($registration_successful) {
                echo "alert('Registration successful!');";
                echo "window.location.href = 'login.html';";
            }
            ?>
        };
    </script>
</head>

</html>
