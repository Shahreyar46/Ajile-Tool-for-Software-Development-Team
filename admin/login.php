<?php 

  session_start();
  include 'config/dbconfig.php';
  include 'lib/function.php';
  include 'helper/helper.php';

  $db = new Database();

  if(isset($_SESSION["admin_log_status"]))
  {
     header("Location:home.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Login </title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body{
            background-color: #85d3c0;
        }
        .card-top-position{
            margin-top: 120px;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-lg-4 offset-lg-4 card-top-position">
            <div class="card bg-light mb-3">
                <div class="card-header"> LOGIN </div>
                <div class="card-body">
                    <form action="log_response.php" method="POST">
                <div class="error" style="padding: 15px;">
                  <?php 
                      if(isset($_SESSION["log_prob"]))
                      {
                          echo $_SESSION["log_prob"];
                      }
                  ?>                 
                </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Enter email please">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Enter password please">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-success btn-block"> LOGIN </button>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-6">
                            <a class="btn btn-outline-info btn-sm" href="index.php"> BACK </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.js"> </script>
</body>
</html>

<?php 

if(isset($_SESSION["log_prob"]))
{
    unset($_SESSION["log_prob"]);
}

?>
