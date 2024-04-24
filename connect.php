<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attmgsystem";

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_errno) {
    die("Failed to connect to MySQL: " . $connect->connect_error);
}

echo "Connected successfully to MySQL database: " . $dbname;
?>
