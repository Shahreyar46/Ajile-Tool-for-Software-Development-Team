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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Register </title>
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
        <div class="col-lg-6 offset-lg-3 card-top-position">
            <div class="card bg-light mb-3">
                <div class="card-header"> CREATE ACCOUNT </div>
                <div class="card-body">
                    <form action="reg_response.php" method="POST">
                <div class="error" style="padding: 15px;">
                    <?php 
                        if(isset($_SESSION["email_exist"]))
                        {
                            echo $_SESSION["email_exist"];
                        }
                    ?>                 
                </div>
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="username" required="required">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="E-mail Address" required="required">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-success btn-block"> REGISTER </button>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-lg-6">
                            <a class="btn btn-outline-info btn-sm" href="index.php"> BACK </a>
                        </div>

                        <div class="col-lg-6 text-right">
                            <a class="btn btn-outline-info btn-sm" href="login.php"> LOGIN </a> </span>
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

if(isset($_SESSION["email_exist"]))
{
    unset($_SESSION["email_exist"]);
}

?>