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

$allMeeting = $db->selection("meeting_setup",['return_type' => 'all']);

//echo "<pre>";
//print_r($allMeeting);
//echo "</pre>";

include "inc/header.php";


?>



    <div id="app" class="container-fluid">
        <div class="row">

            <?php include "inc/sidebar.php" ?>



            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header"> All MEETING </div>
                    <div class="card-body">
                        <table class="table table-bordered table-light table-sm table-hover text-center">
                            <thead class="bg-light">
                            <tr>
                                <th> ID </th>
                                <th> Project Name </th>
                                <th> Meeting Description </th>
                                <th> Meeting Date </th>
                                <th> Meeting Time </th>
                                <th> Meeting Duration </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($allMeeting as $key => $meeting) {
                                //$datetime = explode(" ",$meeting["projectDeadline"]);
                                ?>
                                <tr>
                                    <td> <?php echo ++$i; ?> </td>
                                    <td>
                                        <a class="" href="singleproject.php?id=<?php echo $meeting["id"]; ?>">
                                            <?php
                                                $singleproject = $db->selection("projects",['where' => array('id'=>$meeting["id"]),'return_type' => 'one']);
                                                echo $singleproject["projectName"];
                                            ?>
                                        </a>
                                    </td>
                                    <td> <?php echo $meeting["projectDescription"]; ?> </td>
                                    <td> <?php echo $meeting["meetingDate"]; ?> </td>
                                    <td> <?php echo $meeting["meetingTime"]; ?> </td>
                                    <td> <?php echo $meeting["meetingDuration"]; ?> </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
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