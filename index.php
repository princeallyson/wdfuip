<?php 
require ("config/db_connection.php");
require("config/archive-script.php");
session_start(); 

if (isset($_SESSION['id']))
{ 

    if ($_SESSION['user_level'] == "Admin") {
        header("location: admin/dashboard.php");
    }
    elseif($_SESSION['user_level'] == "Faculty"){
        header("location: faculty/dashboard.php");
    }
    else{
        header("location: student/dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/img/icon.png" />
    <!-- LOCAL STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/toastr.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- LOCAL SCRIPTS -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/toastr.min.js"></script>
    <script type="text/javascript" src="config/toastr_config.js"></script>
    
    <title>Sign In</title>
</head>

<body>
    <main>
        <div class="container-fluid d-flex justify-content-center align-items-center">
            <div class="formBox  d-flex justify-content-center align-items-center flex-column">
                <img class="mb-4" src="assets/img/logo.png" alt="">
                <div class="mb-3">
                    <input class="form-control" type="number" placeholder="ID Number" name="userID" id="userID" autofocus>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                </div>
                <div class="mb-3">
                    <p>Don't have an account? <a href="register.php"> Sign up.</a></p>
                    <button class="submitBtn btn" type="submit" onclick="login()">Sign In</button>
                </div>
            </div>
        </div>
    </main>

    
    <script>
        window.onload = function(){
            document.getElementById("userID").value = '';
            document.getElementById("password").value = '';
        }

        function login() {
            var userID = $('#userID').val();
            var password = $('#password').val();

            if (userID != "" && password != "") {
              $.ajax({
                url: "login.php",
                type: "POST",
                data: {
                  userID: userID,
                  password: password,
              },
              success: function (data, status) {
                  if (data == "Admin") {
                    toastr.success("Login Successful");
                    location.replace("admin/dashboard.php");
                }
                else if (data == "Faculty") {
                    toastr.success("Login Successful");
                    location.replace("faculty/dashboard.php");
                }
                else if (data == "Student") {
                    toastr.success("Login Successful");
                    location.replace("student/dashboard.php");
                }
                else {
                    toastr.error("Incorrect ID Number or password!");
                }
            }
        });
          }
          else {
              toastr.error("Please fill the fields!");
          }
      }
  </script>
  <!-- LOCAL SCRIPTS -->
  <script type="text/javascript" src="assets/bootstrap/js/popper.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>