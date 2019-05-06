<?php 


    session_start();
    include 'config/dbconfig.php';
    include 'lib/function.php';
    include 'helper/helper.php';
    $db = new Database();

    //var_dump($_SESSION);exit();
    $myTasks = $db->fetchPeopleTask($_SESSION["userinfo"]["id"]);
// echo "<pre>";
//     print_r($myTasks);
// echo "</pre>";




    include "inc/header.php";

?>

    <div class="container">
        <div class="row">
        <?php include "inc/sidebar.php" ?>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-info text-center"> My Task </h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="text-muted"> Task Board: </h4>
                                    </div>
                                </div>


                                <table class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <th> Task Name </th>
                                        
                                        <th> Progress </th>
                                        <th> Priority </th>
                                        <th> Deadline </th>
                                        <th> Requirements </th>
                                        
                                    </thead>
                                    <tbody>
                                    <?php if($myTasks){ ?>
<?php 
    foreach ($myTasks as $myTask) {

    ?>
                                        <tr>
                                            <td> <?php echo $myTask["taskName"]; ?> </td>
                                            <td>
                                                <select onchange="changeStatus('taskStatus<?= $myTask["id"  ]; ?>')" class="" id="taskStatus<?= $myTask['id']; ?>">
                                                    <option <?php echo $myTask['progress'] == 'On going' ? ' selected' : ''; ?> value="On going">On going</option>
                                                    <option <?php echo $myTask['progress'] == 'Done' ? ' selected' : ''; ?> value="Done">Done</option>
                                                    <option <?php echo $myTask['progress'] == 'Blocked' ? ' selected' : ''; ?> value="Blocked">Blocked</option>
                                                </select> 
                                                <input type="text" value="<?= $myTask['id']; ?>" hidden name="">
                                            </td>
                                            <td> <?php echo $myTask["priority"]; ?> </td>
                                            <td> <?php echo $myTask["deadline"]; ?>  </td>
                                            <td> <?php echo $myTask["requirement"]; ?> </td>
                                        </tr>
<?php } }else{
    echo "no task assigned yet.";
} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        
<?php 

include "inc/footer.php";

?>