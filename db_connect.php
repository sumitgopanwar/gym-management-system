<?php
$servername = "localhost";  // Database server
$username = "root";         // MySQL username
$password = "root75";             // MySQL password (default is empty for localhost)
$dbname = "gym_website";    // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
