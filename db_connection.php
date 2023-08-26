<?php
// Replace the connection details with your actual database configuration
$hostname = 'localhost:3307';
$username = 'root';
$password = '';
$dbname = 'eclaim_db';

// Create a new mysqli connection
$connection = new mysqli($hostname, $username, $password, $dbname);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
