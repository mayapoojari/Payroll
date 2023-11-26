<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <script>
    <!--
    var ScrollMsg = "Payroll Management System - ";
    var CharacterPosition = 0;
    function StartScrolling() {
      document.title = ScrollMsg.substring(CharacterPosition, ScrollMsg.length) +
        ScrollMsg.substring(0, CharacterPosition);
      CharacterPosition++;
      if (CharacterPosition > ScrollMsg.length) CharacterPosition = 0;
      window.setTimeout("StartScrolling()", 150);
    }
    StartScrolling();
    // -->
  </script>
  <link href="assets/must.png" rel="shortcut icon">
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="hold-transition login-page">
<?php
  require('db.php');
  session_start();
    // If form submitted, insert values into the database.
    if (isset($_POST['username']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prevent SQL injection by using mysqli_real_escape_string
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        //Checking if the user exists in the database or not
        $query = "SELECT * FROM `user` WHERE username='$username' and password='$password'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $rows = mysqli_num_rows($result);

        if($rows == 1)
        {
          $_SESSION['username'] = $username;
          header("Location: index.php");
        }
        else
        {
          echo '<script>
            alert("Invalid Keyword, please try again.");
            window.location.href = "login.php";
          </script>';
        }
    }
    else
    {
?>
<br><br><br><br><br><br><br><br>
<div class="container">
  <section id="content">
    <form action="" method="post">
      <h1>Login Form</h1>
      <div>
        <input name="username" type="text" placeholder="Enter Username" required>
      </div>
      <div>
        <input name="password" type="password" placeholder="Enter Password" required>
      </div>
      <div>
        <input type="submit" value="Log in" />
      </div>
    </form>
  </section>
</div>
<?php
}
?>
</body>
</html>
