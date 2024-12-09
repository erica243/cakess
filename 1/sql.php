<?php

$servername = '127.0.0.1'; 
$username = 'u510162695_fos_db'; // Your database username
$password = '1Fos_db_password'; // Your database password
$dbname = 'u510162695_fos_db'; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to describe the table
$sql = "SHOW COLUMNS FROM user_info";

// Execute the query
$result = $conn->query($sql);

// Check if query was successful
if ($result->num_rows > 0) {
    // Output table columns
    while ($row = $result->fetch_assoc()) {
        echo "Field: " . $row['Field'] . "<br>";
        echo "Type: " . $row['Type'] . "<br>";
        echo "Null: " . $row['Null'] . "<br>";
        echo "Key: " . $row['Key'] . "<br>";
        echo "Default: " . $row['Default'] . "<br>";
        echo "Extra: " . $row['Extra'] . "<br><br>";
    }
} else {
    echo "No columns found in the user_info table.";
}

// Close the connection
$conn->close();
?>

