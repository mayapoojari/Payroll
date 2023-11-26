<?php
include 'db.php';

// Assuming $conn is the database connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Call the stored procedure
$result = mysqli_query($conn, "CALL GetEmployeeCount()");

if (!$result) {
    die("Stored Procedure Call Failed: " . mysqli_error($conn));
}

// Fetch the result
$row = mysqli_fetch_row($result);
$count = $row[0];

// Output the result
echo $count;

// Close the connection
mysqli_close($conn);
?>
