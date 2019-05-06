<?php 


    session_start();
    include 'config/dbconfig.php';
    include 'lib/function.php';
    include 'helper/helper.php';
    $db = new Database();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){


        extract($_POST);
        $tbName = "projects";
        $cond = array(
            'user_id'=>$_SESSION["userinfo"]["id"],
            'projectName'=>$projectName,
            'customerName'=>$customerName,
            'customerEmail'=>$customerEmail,
            'customerPhone'=>$customerPhone,
            'projectDeadline'=>$projectDeadline,
            'projectDescription'=>$projectDescription
        );
        $isInserted = $db->insertion($tbName,$cond);

        if($isInserted){
            session::setter("success","true");
            //var_dump($_SESSION);exit();
            header("Location:home.php");
        }else{
            session::setter("unsuccess","true");
        }

    }

    include "inc/header.php";


?>


    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="list-group text-success">
                    <a class="list-group-item list-group-item-action" href="home.html"> <i class="fas fa-bezier-curve"></i> All Projects </a>
                    <a class="list-group-item list-group-item-action" href="task.html"> <i class="fas fa-tasks"></i> My Tasks </a>
                    <a class="list-group-item list-group-item-action" href="meeting.html"> <i class="fas fa-mail-bulk"></i> Setup Meeting </a>
                    <a class="list-group-item list-group-item-action" href="advancement.html"> <i class="far fa-hourglass"></i> Show Task Advancement </a>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <?php 
                    if(isset($_SESSION["unsuccess"]))
                    {
                    ?>
                        <div class="alert alert-success">
                          <strong>Project not added!</strong> something went wrong.
                        </div>
                    <?php
                    }
                    ?>
                    <div class="card-header"> CREATE PROJECT </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <label for="projectName"> Project Name: </label>
                                        <input type="text" name="projectName" id="projectName" class="form-control" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="projectDeadline"> Project Deadline: </label>
                                        <input type="date" name="projectDeadline" id="projectDeadline" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <label for="customerName"> Customer Name: </label>
                                        <input type="text" name="customerName" id="customerName" class="form-control" required>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="customerPhone"> Customer Phone: </label>
                                        <input type="text" name="customerPhone" id="customerPhone" class="form-control" required>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="customerEmail"> Customer E-mail: </label>
                                        <input type="email" name="customerEmail" id="customerEmail" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="projectDescription"> Project Description: </label>
                                <textarea class="form-control" name="projectDescription" id="projectDescription" cols="30" rows="3" required></textarea>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-outline-success"> Create Project </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 

<?php 

include "inc/footer.php";

if(isset($_SESSION["unsuccess"]))
{
    unset($_SESSION["unsuccess"]);
}

?>