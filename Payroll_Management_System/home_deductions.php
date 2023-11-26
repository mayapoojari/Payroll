<?php
include("auth.php"); //include auth.php file on all secure pages
include("add_employee.php");

$conn = new mysqli('localhost', 'root', '190692', 'payroll');
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$query = "SELECT * FROM deductions";
$result = $conn->query($query);

$total = 0; // Initialize total outside the loop

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['deduction_id'];
        $medical = $row['medical'];
        $tax = $row['tax'];
        $refreshments = $row['refreshments'];
        $house = $row['house'];
        $loans = $row['loans'];
        $total = $medical + $tax + $refreshments + $house + $loans;
    }
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

    <title>Payroll System</title>


    <link href="assets/css/justified-nav.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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
        <b><a href="index.php" style="text-decoration:none; color:#d9534f;">Payroll Management System</a></b>
            <a data-toggle="modal" style="text-decoration:none; color:#3fb1d4;" href="#colins" class="pull-right"><b><button class="btn btn-danger" style="border-radius: 0%;"><i class="fas fa-sign-out-alt"></i> Exit</button></b></a>
        </h3>
        <nav>
          <ul class="nav nav-justified" style="border-radius:0%">
            <li>
              <a href="home_employee.php">Employee Section <span class="label label-primary"><?php include 'total_count.php'?></span></a>
            </li>
            <li class="active">
              <a data-toggle="modal" href="#deductions">Manage Deductions</a>
            </li>
            <li>
              <a href="home_salary.php">Payroll Section</a>
            </li>
          </ul>
        </nav>
      </div><br><br>

              <form class="form-horizontal" action="#" name="form">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th><p align="center">Medical:</p></th>
                      <th><p align="center">Tax:</p></th>
                      <th><p align="center">Refreshments:</p></th>
                      <th><p align="center">House:</p></th>
                      <th><p align="center">Loans:</p></th>
                    </tr>
                    
                  </thead>

                  <tbody>
                    <tr>
                      <td align="center"><?php echo $medical; ?>.00</td>
                      <td align="center"> <?php echo $tax; ?>.00</td>
                      <td align="center"><?php echo $refreshments; ?>.00</td>
                      <td align="center"><?php echo $house; ?>.00</td>
                      <td align="center"><?php echo $loans; ?>.00</td>
                    </tr>
                  </tbody>
                </table>
                <br>

                <div class="form-group">
                  <h4><label class="col-lg-12 control-label">Total Deductions : <?php echo $total; ?>.00</label></h4>
                </div>

                <div class="form-group">
                  <label class="col-lg-12 control-label"><button type="button" data-toggle="modal" data-target="#deductions" class="btn btn-danger" style="border-radius:0%"> <i class="fa fa-edit"></i> Update Deduction Details</button></label>
                </div>
              </form>

      <!-- this modal is for update an DEDUCTIONS -->
      <div class="modal fade" id="deductions" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="padding:20px 50px;">
              <button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
              <h3 align="center"><b>Payroll Deduction List</b></h3>
            </div>
            <div class="modal-body" style="padding:40px 50px;">

              <form class="form-horizontal" action="add_deductions.php" name="form" method="post">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Medical</label>
                  <div class="col-sm-8">
                    <input type="text" name="medical" class="form-control" required="required" value="<?php echo $medical; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Tax</label>
                  <div class="col-sm-8">
                    <input type="text" name="tax" class="form-control" value="<?php echo $tax; ?>" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Refreshments</label>
                  <div class="col-sm-8">
                    <input type="text" name="refreshments" class="form-control" value="<?php echo $refreshments; ?>" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">House</label>
                  <div class="col-sm-8">
                    <input type="text" name="house" class="form-control" value="<?php echo $house; ?>" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Loans</label>
                  <div class="col-sm-8">
                    <input type="text" name="loans" class="form-control" value="<?php echo $loans; ?>" required="required">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Total Deductions</label>
                  <div class="col-sm-8">
                    <input type="text" name="total"  class="form-control" value="<?php echo $total; ?>" required="required"> 
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label"></label>
                  <div class="col-sm-8">
                    <input type="submit" name="submit" class="btn btn-primary" style="border-radius:0%" value="Make Changes">
                  </div>
                </div>
              </form>

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function() {
        // Update total when any input field changes
        $('input[name="medical"], input[name="tax"], input[name="refreshments"], input[name="house"], input[name="loans"]').on('input', function() {
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