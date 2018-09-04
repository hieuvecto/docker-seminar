<?php
$servername = "192.168.33.26";
$username = "vagrant";
$password = "vagrant"

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully\n";
?>