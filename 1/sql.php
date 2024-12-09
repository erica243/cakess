<?php
$servername = '127.0.0.1'; // Typically 'localhost' or '127.0.0.1' for local servers
$username = 'u510162695_fos_db'; // Your database username
$password = '1Fos_db_password'; // Your database password
$dbname = 'u510162695_fos_db'; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all data from the user_info table
$sql = "SELECT * FROM user_info";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'>
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Profile Picture</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["user_id"]. "</td>
                <td>" . $row["first_name"]. "</td>
                <td>" . $row["last_name"]. "</td>
                <td>" . $row["email"]. "</td>
                <td>" . $row["mobile"]. "</td>
                <td>" . $row["address"]. "</td>
                <td><img src='" . $row["profile_picture"] . "' width='50' height='50'></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
