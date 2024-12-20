<?php
session_start();
include('dbconnect.php');

// Check if equipment ID is provided
if (!isset($_GET['id'])) {
    echo "Equipment ID not provided.";
    exit;
}

$equipment_id = $_GET['id'];

// Retrieve equipment details from the database
$sql_equipment_details = "SELECT * FROM equipment WHERE equipment_id = $equipment_id";
$result_equipment_details = $conn->query($sql_equipment_details);

if ($result_equipment_details->num_rows == 0) {
    echo "Equipment not found.";
    exit;
}

$row = $result_equipment_details->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    // Note: You should perform proper validation and sanitization here
    $equipment_name = $_POST['equipment_name'];
    $equipment_condition = $_POST['equipment_condition'];

    // Update equipment details in the database
    $sql_update_equipment = "UPDATE equipment SET 
                                equipment_name = '$equipment_name',
                                equipment_condition = '$equipment_condition'
                                WHERE equipment_id = $equipment_id";

    if ($conn->query($sql_update_equipment) === TRUE) {
        // Redirect back to admin.php after successful update
        header("Location: admin.php");
        exit;
    } else {
        echo "Error updating equipment: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Equipment</title>
</head>
<body>
    <h1>Edit Equipment</h1>

    <form method="post" action="">
        <label for="equipment_name">Name:</label><br>
        <input type="text" id="equipment_name" name="equipment_name" value="<?php echo $row['equipment_name']; ?>"><br>
        
        <label for="equipment_condition">Condition:</label><br>
        <input type="text" id="equipment_condition" name="equipment_condition" value="<?php echo $row['equipment_condition']; ?>"><br>
        
        <input type="submit" value="Submit">
		
    </form>
	
	
	
</body>
</html>
