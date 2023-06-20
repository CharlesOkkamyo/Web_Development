<?php
// Database connection configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bookstore';

// Create a new database connection
$connection = mysqli_connect($host, $username, $password, $database);
if (!$connection) {
    die('Database connection error: ' . mysqli_connect_error());
}
?>