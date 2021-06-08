<?php
/**
 * Connect to the Database
 */
$servername = "localhost";
$username = "root";
$password = "";
$db = "forum";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// please write
// $conn->close();
// to the end of all files, which includes this file
?>
