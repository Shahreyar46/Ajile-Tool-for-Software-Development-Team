<?php

  session_start();
  include 'config/dbconfig.php';
  include 'helper/helper.php';
  $db = new Database();

  if(isset($_SESSION["log_status"]))
  {
     header("Location:home.php");
  }
    
?>

<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Projects Tool </title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body{
            background-color: #85d3c0;
        }
        .account-mangage-position{
            margin-top: 70px;
        }
        .welcome-title-position{
            margin-top: 140px;
        }
    </style>
</head>
<body>

      <div class="container">
          <div class="text-right account-mangage-position">
              <a class="btn btn-outline-success" href="reg.php"> CREATE AN ACCOUNT </a>
              <span> &nbsp; &nbsp; &nbsp; &nbsp; </span>
              <a class="btn btn-outline-success" href="login.php"> LOGIN </a>
          </div>
      </div>

      <div class="row">
          <div class="col-lg-6 offset-3 welcome-title-position">
              <h3 class="text-center"> WELCOME TO </h3>
              <h1 class="text-center text-success"> AJILA </h1>
          </div>
      </div>
   

    

    <script src="js/jquery.min.js"> </script>
    <script src="js/bootstrap.js"> </script>
</body>
</html>



