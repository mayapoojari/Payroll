<?php
include("db.php");
include("auth.php");

// Make sure to establish a database connection
$servername = "localhost";
$username = "root";
$password = "190692";
$database = "payroll";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$lname = $_POST['lname'];
$fname = $_POST['fname'];
$gender = $_POST['gender'];
$division = $_POST['division'];
$emp_type = $_POST['emp_type'];

$stmt = $conn->prepare("UPDATE employee SET emp_type=?, fname=?, lname=?, gender=?, division=? WHERE emp_id=?");
$stmt->bind_param("sssssi", $emp_type, $fname, $lname, $gender, $division, $id);
$result = $stmt->execute();
$stmt->close();

if ($result) {
    ?>
    <script>
        alert('Employee successfully updated.');
        window.location.href = 'home_employee.php';
    </script>
    <?php
} else {
    ?>
    <script>
        alert('Invalid action.');
        window.location.href = 'home_employee.php';
    </script>
    <?php
}
