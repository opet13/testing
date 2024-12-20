<?php
include('dbconnect.php');
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_admin = $_POST['username_admin'];
    $password_admin = $_POST['password_admin'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to check if the username and password match
    $sql = "SELECT * FROM admins WHERE username_admin='$username_admin' AND password_admin='$password_admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User is authenticated
        $_SESSION['username_admin'] = $username_admin;
        header("Location: admin.php"); // Redirect to reservation page
        exit();
    } else {
        echo "Invalid username or password";
    }

    $conn->close();
}
?>
