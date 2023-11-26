<?php
include("db.php");
include("auth.php");

$id = $_POST['id'];
$overtime = $_POST['overtime'];
$bonus = $_POST['bonus'];
$salary = $_POST['salary'];

// Fetch the total deduction from the deductions table
$query = $conn->query("SELECT total FROM deductions WHERE deduction_id = 1"); // Assuming deduction_id is 1, adjust if needed
$row = $query->fetch_assoc();
$totalDeduction = $row['total'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("UPDATE employee SET salary=? , deduction=?, overtime=?, bonus=? WHERE emp_id=?");
$stmt->bind_param("iiiii",$salary, $totalDeduction, $overtime, $bonus, $id); // Assuming deduction is an integer, adjust if needed
$result = $stmt->execute();
$stmt->close();

if ($result) {
  ?>
  <script>
    alert('Account successfully updated.');
    window.location.href='home_employee.php';
  </script>
  <?php
} else {
  echo "Invalid";
}
?>
