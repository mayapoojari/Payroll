<?php
require("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @$id = $_POST['ot_id'];
    @$overtime = $_POST['rate'];

    $sql = "UPDATE overtime SET rate=? WHERE ot_id=1";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "d", $overtime);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            // Set alert message in session
            session_start();
            $_SESSION['alert_message'] = "Overtime Rate has been updated!";

            // Redirect after updating overtime rate
            header("Location: home_salary.php");
            exit();
        } else {
            echo '<script>alert("Something went wrong!");</script>';
            header("Location: home_salary.php");
            exit();
        }
    } else {
        echo "Statement preparation failed: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method.";
}
?>
