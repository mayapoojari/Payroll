<?php
$servername = "localhost";
$username = "root";
$password = "190692";
$database = "payroll";

// Create a conn to the database
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database conn Failed: " . $conn->connect_error);
}
