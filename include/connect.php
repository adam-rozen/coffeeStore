<?php
/**
 * File:		connect.php
 * Author:		Adam Rozen
 * Purpose:		Connect to database
 **/
$servername = "localhost";
$username = "root";
$dbname = "coffee";

// Create connection
$conn = new mysqli($servername, $username, /*$password*/NULL, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
