<?php
include("auth.php"); // Include auth.php file on all secure pages
require("db.php"); // Use the database conn file

// Initialize variables
$medical = 0;
$tax = 0;
$refreshments = 0;
$house = 0;
$loans = 0;

// Fetch deduction data
$sql = "SELECT * FROM deductions WHERE deduction_id = 1";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $medical = isset($row['medical']) ? $row['medical'] : 0;
        $tax = isset($row['tax']) ? $row['tax'] : 0;
        $refreshments = isset($row['refreshments']) ? $row['refreshments'] : 0;
        $house = isset($row['house']) ? $row['house'] : 0;
        $loans = isset($row['loans']) ? $row['loans'] : 0;
    }
} else {
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
    <meta name="description" content="Bootstrap, a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, bootstrap, front-end, frontend, web development">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">

    <title></title>

    <script>
      <!--
        var ScrollMsg= "Payroll Management System - "
        var CharacterPosition=0;
        function StartScrolling() {
        document.title=ScrollMsg.substring(CharacterPosition,ScrollMsg.length)+
        ScrollMsg.substring(0, CharacterPosition);
        CharacterPosition++;
        if(CharacterPosition > ScrollMsg.length) CharacterPosition=0;
        window.setTimeout("StartScrolling()",150); }
        StartScrolling();
      // -->
    </script>

    <link href="assets/must.png" rel="shortcut icon">
    <link href="assets/css/justified-nav.css" rel="stylesheet">


    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="data:text/css;charset=utf-8," data-href="assets/css/bootstrap-theme.min.css" rel="stylesheet" id="bs-theme-stylesheet"> -->
    <!-- <link href="assets/css/docs.min.css" rel="stylesheet"> -->
    <link href="assets/css/search.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="assets/css/styles.css" /> -->
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
            <li class="active">
              <!-- <a href="">Employee</a> -->
              <a href="">Employee<span class="label label-primary"><?php include 'total_count.php'?></span></a>

            </li>
            <li>
              <a href="home_deductions.php">Deduction/s</a>
            </li>
            <li>
              <a href="home_salary.php">Income</a>
            </li>
          </ul>
        </nav>
      </div>

        <br>
          <div class="well bs-component">
            <form class="form-horizontal">
              <fieldset>
                <button type="button" data-toggle="modal" data-target="#addEmployee" class="btn btn-success">Add New</button>
                <p align="center"><big><b>List of Employees</b></big></p>
                <div class="table-responsive">
                  <form method="post" action="" >
                    <table class="table table-bordered table-hover table-condensed" id="myTable">
                      <!-- <h3><b>Ordinance</b></h3> -->
                      <thead>
                        <tr class="info">
                          <th><p align="center">Name</p></th>
                          <th><p align="center">Gender</p></th>
                          <th><p align="center">Employee Type</p></th>
                          <th><p align="center">Department</p></th>
                          <th><p align="center">Action</p></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        require('db.php'); // Use the database conn file

                        $query = "SELECT * FROM employee ORDER BY emp_id ASC";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            die("Database query failed: " . mysqli_error($conn));
                        }

                        while ($row = mysqli_fetch_array($result)) {
                            $id = $row['emp_id'];
                            $fname = $row['fname'];
                            $lname = $row['lname'];
                            $type = $row['emp_type'];
                            $salary = $row['salary'];
                            $deduction = $row['deduction'];
                            $overtime = $row['overtime'];
                            $bonus = $row['bonus'];
                            $gender = $row['gender'];
                            $division = $row['division'];
                            ?>

                            <tr>
                              <td align="center"><a href="view_employee.php?emp_id=<?php echo $row["emp_id"]; ?>" title="Update"><?php echo $fname ?>  <?php echo $lname ?></a></td>
                              <td align="center"><a href="view_employee.php?emp_id=<?php echo $row["emp_id"]; ?>" title="Update"><?php echo $gender ?></a></td>
                              <td align="center"><a href="view_employee.php?emp_id=<?php echo $row["emp_id"]; ?>" title="Update"><?php echo $type ?></a></td>
                              <td align="center"><a href="view_employee.php?emp_id=<?php echo $row["emp_id"]; ?>" title="Update"><?php echo $division ?></a></td>
                              <td align="center">
                                <a class="btn btn-primary" href="view_account.php?emp_id=<?php echo $row["emp_id"]; ?>">Account</a>
                                <a class="btn btn-danger" href="delete.php?emp_id=<?php echo $row["emp_id"]; ?>">Delete</a>
                              </td>
                            </tr>

                            <?php
                        }
                        ?>

                      </tbody>
                      
                        <tr class="info">
                          <th><p align="center">Name</p></th>
                          <th><p align="center">Gender</p></th>
                          <th><p align="center">Employee Type</p></th>
                          <th><p align="center">Department</p></th>
                          <th><p align="center">Action</p></th>
                        </tr>
                    </table>
                  </form>
                </div>
              </fieldset>
            </form>
          </div>

          <!-- this modal is for ADDING an EMPLOYEE -->
          <!-- Add New Employee Modal -->
         <div class="modal fade" id="addEmployee" role="dialog">
         <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding: 20px 50px;">
                <button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
                <h3 align="center"><b>Add Employee</b></h3>
            </div>
            <div class="modal-body" style="padding: 40px 50px;">

                <!-- Employee Information Form -->
                <form class="form-horizontal" action="add_employee.php" method="post">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">First Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="fname" class="form-control" placeholder="First Name" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Last Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="lname" class="form-control" placeholder="Last Name" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Gender</label>
                        <div class="col-sm-8">
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Employee Type</label>
                        <div class="col-sm-8">
                            <select name="emp_type" class="form-control" required>
                                <option value="">Select Employee Type</option>
                                <option value="FullTime">Full-Time</option>
                                <option value="PartTime">Part-Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Division</label>
                        <div class="col-sm-8">
                            <select name="division" class="form-control" required>
                                <option value="">Select Division</option>
                                <option value="Human Resource">Human Resource</option>
                                <option value="Accountant">Accountant</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="col-sm-4 control-label">Salary</label>
                        <div class="col-sm-8">
                            <input type="text" name="salary" class="form-control" placeholder="Salary" required="required">
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="submit" name="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>
                </form>
                <!-- End of Employee Information Form -->

            </div>
        </div>
    </div>
</div>

      <!-- this modal is for my Colins -->
      <div class="modal fade" id="colins" role="dialog">
        <div class="modal-dialog modal-sm">
              
          <!-- Modal content-->
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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- <script src="assets/js/docs.min.js"></script> -->
    <script src="assets/js/search.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/dataTables.min.js"></script>

    <!-- FOR DataTable -->
    <script>
      {
        $(document).ready(function()
        {
          $('#myTable').DataTable();
        });
      }
    </script>

    <!-- this function is for modal -->
    <script>
      $(document).ready(function()
      {
        $("#myBtn").click(function()
        {
          $("#myModal").modal();
        });
      });
    </script>

  </body>
</html>