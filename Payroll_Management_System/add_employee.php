<?php
$servername = 'localhost';
$username = 'root';
$password = '190692';
$database = 'payroll';

// Create a conn to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the conn
if ($conn->connect_error) {
    die('Database conn Failed: ' . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $emp_type = $_POST['emp_type'];
    $division = $_POST['division'];

    $sql = "INSERT INTO employee (fname, lname, gender, emp_type, division) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $fname, $lname, $gender, $emp_type, $division);

    if ($stmt->execute()) {
        ?>
        <script>
            alert('Employee has been successfully added.');
            window.location.href = 'home_employee.php?page=emp_list';
        </script>
        <?php
    } else {
        ?>
        <script>
            alert('Invalid.');
            window.location.href = 'index.php';
        </script>
        <?php
    }

    $stmt->close();
}


$conn->close();
?>
