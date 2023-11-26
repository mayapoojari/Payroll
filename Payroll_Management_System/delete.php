<?php
require('db.php');

// Make sure to establish a database conn
$servername = "localhost";
$username = "root";
$password = "190692";
$database = "payroll";

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("connection failed: " . $mysqli->connect_error);
}

if (isset($_GET['emp_id'])) {
    $id = $_GET['emp_id'];
    
    $stmt = $mysqli->prepare("DELETE FROM employee WHERE emp_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: home_employee.php");
        exit();
    } else {
        die("Deletion failed: " . $stmt->error);
    }
} else {
    die("Invalid input.");
}
