<?php
include("auth.php");
require("db.php");

// Fetch overtime rate
$query = "SELECT * FROM overtime";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$rate = $row['rate'];

// Fetch total deductions
$sql = "SELECT * FROM deductions";
$sqlresult = $conn->query($sql);

$total = 0; // Initialize total outside the loop

if ($sqlresult->num_rows > 0) {
    while ($drow = $sqlresult->fetch_assoc()) {
        $id = $drow['deduction_id'];
        $medical = $drow['medical'];
        $tax = $drow['tax'];
        $refreshments = $drow['refreshments'];
        $house = $drow['house'];
        $loans = $drow['loans'];
        $total = $medical + $tax + $refreshments + $house + $loans;
    }
}

// Close the SQL result set
$sqlresult->close();

// Fetch data from the 'employee' table
$empquery = "SELECT * FROM employee";
$empresult = mysqli_query($conn, $empquery);

if (!$empresult) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Payroll Management System">
    <meta name="keywords" content="payroll, management, system, income, overtime, salary">
    <meta name="author" content="Your Name">
    <title>Payroll Management System</title>
    <script>
        var ScrollMsg = "Payroll Management System - ";
        var CharacterPosition = 0;
        function StartScrolling() {
            document.title = ScrollMsg.substring(CharacterPosition, ScrollMsg.length) +
                ScrollMsg.substring(0, CharacterPosition);
            CharacterPosition++;
            if (CharacterPosition > ScrollMsg.length) CharacterPosition = 0;
            window.setTimeout("StartScrolling()", 150);
        }
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
                <a data-toggle="modal" href="#colins" class="pull-right"><b><?php echo $_SESSION['username']; ?></b></a>
            </h3>
            <nav>
                <ul class="nav nav-justified">
                    <li>
                        <a href="home_employee.php">Employee<span class="label label-primary"><?php include 'total_count.php'?></span></a>
                    </li>
                    <li>
                        <a href="home_deductions.php">Deduction/s</a>
                    </li>
                    <li class="active">
                        <a href="home_salary.php">Income</a>
                    </li>
                </ul>
            </nav>
        </div>
        <br>
        <div class="well bs-component">
            <form class="form-horizontal">
                <fieldset>
                    <button type="button" data-toggle="modal" data-target="#overtime" class="btn btn-success">Modify Overtime Rate</button>
                    <p class="pull-right">Overtime rate per hour: <big><b><?php echo $rate; ?>.00</b></big></p><br>
                    <p align ="center"><big><b>Account</b></big></p>
                    <div class="table-responsive">
                        <form method="post" action="">
                            <table class="table table-bordered table-hover table-condensed" id="myTable">
                                <thead>
                                    <tr class="info">
                                        <th><p align="center">Name</p></th>
                                        <th><p align="center">Basic Salary</p></th>
                                        <th><p align="center">Deduction</p></th>
                                        <th><p align="center">Overtime</p></th>
                                        <th><p align="center">Bonus</p></th>
                                        <th><p align="center">Net Pay</p></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($row = mysqli_fetch_assoc($empresult)) {
                                            $fname = $row['fname'];
                                            $lname = $row['lname'];
                                            $salary = $row['salary'];
                                            $overtime = $row['overtime'];
                                            $bonus = $row['bonus'];
                                            $over = $overtime * $rate;
                                            $income = $over + $bonus + $salary;
                                            $netpay = $income - $total;
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $fname ?> <?php echo $lname ?></td>
                                        <td align="center"><big><b><?php echo $salary ?></b></big>.00</td>
                                        <td align="center"><big><b><?php echo $total ?></b></big>.00</td>
                                        <td align="center"><big><b><?php echo $overtime ?></b></big> hrs</td>
                                        <td align="center"><big><b><?php echo $bonus ?></b></big>.00</td>
                                        <td align="center"><big><b><?php echo $netpay ?></b></big>.00</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- OVERTIME Modal -->
        <div class="modal fade" id="overtime" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="padding:20px 50px;">
                        <button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
                        <h3 align="center">Enter the amount of <big><b>Overtime</b></big> rate per hour.</h3>
                    </div>
                    <div class="modal-body" style="padding:40px 50px;">
                        <form class="form-horizontal" action="update_overtime.php" name="form" method="post">
                            <div class="form-group">
                                <input type="text" name="rate" class="form-control" value="<?php echo $rate; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-success" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Admin Modal -->
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Update total when any input field changes
            $('input[name="medical"], input[name="tax"], input[name="refreshments"], input[name="house"], input[name="loans"]').on('input', function () {
                updateTotal();
            });

            // Function to calculate and update total
            function updateTotal() {
                var medical = parseFloat($('input[name="medical"]').val()) || 0;
                var tax = parseFloat($('input[name="tax"]').val()) || 0;
                var refreshments = parseFloat($('input[name="refreshments"]').val()) || 0;
                var house = parseFloat($('input[name="house"]').val()) || 0;
                var loans = parseFloat($('input[name="loans"]').val()) || 0;

                var total = medical + tax + refreshments + house + loans;

                // Update the total field
                $('#total').val(total.toFixed(2));
            }

            // Call updateTotal initially
            updateTotal();
        });
    </script>
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
