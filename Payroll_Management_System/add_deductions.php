<?php
require("db.php");
$id = $_POST['deduction_id'];
$medical = $_POST['medical'];
$tax = $_POST['tax'];
$refreshments = $_POST['refreshments'];
$house = $_POST['house'];
$loans = $_POST['loans'];
$total = $_POST['total'];

$sql = mysqli_query($conn, "UPDATE deductions SET medical='$medical', tax='$tax', refreshments='$refreshments', house='$house', loans='$loans' WHERE deduction_id='1'");

if ($sql) {
    ?>
    <script>
        alert('Deductions updated!');
        window.location.href = 'home_deductions.php';
    </script>
    <?php
} else {
    echo "Something went wrong, Please try again!";
}

?>
