<?php
include('dbconnect.php');
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to check if the username and password match
    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // User is authenticated
        $row = $result->fetch_assoc(); // Fetch the first row from the result set
        $_SESSION['username'] = $username;
        $_SESSION['customer_id'] = $row['customer_id']; // Assuming 'customer_id' is the column name in your login table
       
        echo '<script>alert("Login successful.");';
        echo 'window.location.href = "index.html";</script>'; // Redirect to booking info page
        exit();
    } else {
        // Invalid username or password, redirect back to login page
        echo '<script>alert("Invalid username or password.");';
        echo 'window.location.href = "login.html";</script>';
        exit(); 
    }

    $conn->close(); // Close the database connection
}
?>
