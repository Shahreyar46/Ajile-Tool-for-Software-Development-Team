<?php

session_start();
if(!isset($_SESSION["log_status"]))
{
    header("Location:login.php");
}
include 'config/dbconfig.php';
include 'lib/function.php';
include 'helper/helper.php';

$db = new Database();

require __DIR__ . '/vendor/autoload.php';

$allProject = $db->selection("projects",['return_type' => 'all']);

if(isset($_POST['meeting_setup'])){
    extract($_POST);
    //insertion
    $tbName = "meeting_setup";
    $cond = array(
        "project_id" => "$project_id",
        "meetingDate" => "$meetingDate",
        "meetingTime" => "$meetingTime",
        "meetingDuration" => "$meetingDuration",
        "projectDescription" => "$projectDescription",
    );
    $isInserted = $db->insertion($tbName,$cond);
    if($isInserted){
        $isInserted = "Meeting setup done.";
    }
}

include "inc/header.php";


?>



    <div id="app" class="container-fluid">
        <div class="row">

            <?php include "inc/sidebar.php" ?>



            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header"> SETUP MEETING </div>
                    <div class="card-body">
                        <?php
                        if(isset($isInserted))
                        {
                            ?>
                            <div class="alert alert-success">
                                <strong>New meeting!</strong> setup done.
                            </div>
                            <?php
                        }
                        ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <label for="selectProject"> Project Name: </label>
                                        <select name="project_id" class="form-control" id="selectProject">
                                            <option selected> Choose Project........... </option>
                                        <?php
                                            foreach ($allProject as $project) {
                                        ?>
                                            <option value="<?= $project['id']; ?>"> <?= $project['projectName']; ?> </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <label for="meetingDate"> Meeting Date: </label>
                                        <input type="date" name="meetingDate" id="meetingDate" class="form-control" required>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="meetingTime"> Meeting Time: </label>
                                        <input type="time" name="meetingTime" id="meetingTime" class="form-control" required>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="meetingDuration"> Meeting Duration: </label>
                                        <input type="text" name="meetingDuration" id="meetingDuration" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="projectDescription"> Description: </label>
                                <textarea class="form-control" name="projectDescription" id="projectDescription" cols="30" rows="3" required></textarea>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" name="meeting_setup" class="btn btn-outline-success"> Create Meeting </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>

<?php


include "inc/footer.php";

if(isset($_SESSION["success"]))
{
    unset($_SESSION["success"]);
}

?>