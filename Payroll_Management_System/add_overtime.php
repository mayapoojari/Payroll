<?php
require("db.php");

@$id = $_POST['ot_id'];
@$overtime = $_POST['rate'];

if (!is_numeric($overtime)) {
    echo "Invalid input for the overtime rate.";
} else {
    // Use a prepared statement to update the overtime rate
    $stmt = $mysqli->prepare("UPDATE overtime SET rate = ? WHERE ot_id = 1");
    $stmt->bind_param("d", $overtime);

    if ($stmt->execute()) {
        ?>
        <script>
            alert('Overtime rate per hour successfully changed...');
            window.location.href = 'home_salary.php';
        </script>
        <?php
    } else {
        echo "Not Successful!";
    }
}
?>
