<?php
include("db.php"); // include auth.php file on all secure pages
include("auth.php");

$mysqli = new mysqli("localhost", "root", "190692", "payroll");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = $mysqli->query("SELECT * from deductions WHERE deduction_id='1'");
while ($row = $sql->fetch_assoc()) {
    $medical = $row['medical'];
    $tax = $row['tax'];
    $refreshments = $row['refreshments'];
    $house = $row['house'];
    $loans = $row['loans'];
    $total = $medical + $tax + $refreshments + $house + $loans;
}

// Fetch the total deduction from the deductions table
$query = $conn->query("SELECT total FROM deductions WHERE deduction_id = 1"); // Assuming deduction_id is 1, adjust if needed
$row = $query->fetch_assoc();
$totalDeduction = $row['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap, a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, bootstrap, front-end, frontend, web development">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title></title>
    <script>
        var ScrollMsg = "Payroll and Management System - "
        var CharacterPosition = 0;

        function StartScrolling() {
            document.title = ScrollMsg.substring(CharacterPosition, ScrollMsg.length) +
                ScrollMsg.substring(0, CharacterPosition);
            CharacterPosition++;
            if (CharacterPosition > ScrollMsg.length) CharacterPosition = 0;
            setTimeout(StartScrolling, 150);
        }

        StartScrolling();
    </script>
    <link href="assets/must.png" rel="shortcut icon">
    <link href="assets/css/justified-nav.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/search.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.min.css">
</head>
<body>
<div class="container">
    <div class="masthead">
        <h3>
            <b><a href="index.php">Payroll Management System</a></b>
            <a data-toggle="modal" href="#colins" class="pull-right"><b>Admin</b></a>
        </h3>
        <nav>
            <ul class="nav nav-justified">
                <li class="active">
                    <a href="">Employee</a>
                </li>
                <li>
                    <a href="home_deductions.php">Deduction/s</a>
                </li>
                <li>
                    <a href="home_salary.php">Income</a>
                </li>
            </ul>
        </nav>
    </div><br><br>

    <?php
    $id = $_REQUEST['emp_id'];
    $query = "SELECT * from employee where emp_id='" . $id . "'";
    $result = $mysqli->query($query) or die($mysqli->error);

    $query = "SELECT * from overtime";
    $overtimeResult = $mysqli->query($query);
    $rate = 0;


    if ($overtimeResult->num_rows > 0) {
        $row = $overtimeResult->fetch_assoc();
        $rate = $row['rate'];
    }

    while ($row = $result->fetch_assoc()) {
        $overtime = $row['overtime'] * $rate;
        $salary = $row['salary'];
        $bonus = $row['bonus'];
        $deduction = $totalDeduction;
        $income = $overtime + $bonus + $salary;
        $netpay = $income - $deduction;
        ?>
        <form class="form-horizontal" action="update_account.php" method="post" name="form">
            <input type="hidden" name="new" value="1"/>
            <input name="id" type="hidden" value="<?php echo $row['emp_id']; ?>"/>
            <div class="form-group">
                <label class="col-sm-5 control-label"></label>
                <div class="col-sm-4">
                    <h2><?php echo $row['fname']; ?>  <?php echo $row['lname']; ?></h2>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label">Salary:</label>
                <div class="col-sm-4">
                    <input type="text" name="salary" class="form-control" value="<?php echo $row['salary']; ?>"required="required">
                </div>
            </div>

            <div class="form-group">
               <label class="col-sm-5 control-label">Deduction/s :</label>
               <div class="col-sm-4">
                        <!-- <input type="text" name= "deduction" class="form-control" value="Default"required="required"> -->
                        <select name="tdeductions" class="form-control" required>
                            <option value="selded">Select Deductions</option>
                            <option value="default">Default</option>
                        </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label">Overtime :</label>
                <div class="col-sm-4">
                    <input type="text" name="overtime" class="form-control" value="<?php echo $row['overtime']; ?>"required="required">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label">Bonus :</label>
                <div class="col-sm-4">
                    <input type="text" name="bonus" class="form-control" value="<?php echo $row['bonus']; ?>"required="required">
                </div>
            </div><br><br>

            <div class="form-group">
                <label class="col-sm-5 control-label">Netpay :</label>
                <div class="col-sm-4">
                    <?php echo $netpay; ?>.00
                </div>
            </div><br><br>
            <div class="form-group">
                <label class="col-sm-5 control-label"></label>
                <div class="col-sm-4">
                    <input type="submit" name="submit" value="Update" class="btn btn-danger">
                    <a href="home_employee.php" class="btn btn-primary">Cancel</a>
                </div>
            </div>
        </form>
        <?php
    }
    ?>
    <div class="modal fade" id="colins" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="padding:20px 50px;">
                    <button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
                    <h3 align="center">You are logged in as <b><?php echo $_SESSION['username']; ?></b></h3>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <div align="center">
                        <a href="logout.php" class="btn btn-block btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/search.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
<script>
    $(document).ready(function () {
        $("#myBtn").click(function () {
            $("#myModal").modal();
        });
    });
</script>
</body>
</html>
