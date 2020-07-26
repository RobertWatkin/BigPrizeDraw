<?php
// Connection Details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dbbigprizedraw";

$errorMessage = "";

// Create Connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die ("Connection Failed : ".$conn->connect_error);
}
?>