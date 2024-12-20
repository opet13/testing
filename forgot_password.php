<?php
// Include your database connection file
include 'dbconnect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username from the form
    $username = $_POST['username'];
    // Get the entered new password from the form
    $new_password = $_POST['password']; // Corrected to 'password'

    // Query to check if the username exists in the database
    $query = "SELECT * FROM login WHERE username = '$username'";
    
    // Check if the connection is successful
    if ($conn) { // Ensure $conn is defined and not null
        $result = mysqli_query($conn, $query); // Use $conn for connection

        // Check if there's an error in the query execution
        if (!$result) {
            die("Error: " . mysqli_error($conn)); // Use $conn for connection
        }

        // Check if the query returned any rows
        if (mysqli_num_rows($result) == 1) {
            // Update the user's password in the database
            $update_query = "UPDATE login SET password = '$new_password' WHERE username = '$username'";
            mysqli_query($conn, $update_query); // Use $conn for connection

            // Display a success message to the user
            echo '<script>alert("Your password has been updated successfully.");</script>';
        } else {
            // If the username does not exist in the database
            echo '<script>alert("Username does not exist.");</script>';
        }
    } 
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
	
	<div class="container">
    <h1>Forgot Password</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
            <input type="text" name="username" id="username" aria-label="Username" required><br>
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" aria-label="Password" required><br>
            <input type="submit" value="Reset Password">
        
    </form>
	
	
    <div class="link">
    <a href="login.html">Login</a>
</div>
	</div>
	
	<footer>
        &copy; 2024 1DANCE STUDIO. All rights reserved.
    </footer>
	
</body>
</html>
