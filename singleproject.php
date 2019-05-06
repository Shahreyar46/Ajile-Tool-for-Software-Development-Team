<?php 

    session_start();
    include 'config/dbconfig.php';
    include 'lib/function.php';
    include 'helper/helper.php';
    $db = new Database();

    if(!isset($_SESSION["log_status"]))
    {
        header("Location:login.php");
    }

    if($_SERVER['REQUEST_METHOD'] == "GET"){
       
        extract($_GET);
        $tbName = "projects";
        $selectArr = array(
          'where' => array('id'=>$id),
          'return_type' => 'one'
        );

        $singleProject = $db->selection($tbName,$selectArr);

        if(!$singleProject){
            header("Location:home.php");
        }
      
    }


    $allUsers = $db->selection("users",array(
          'return_type' => 'all'
        )
    );


    $projectProple = $db->fetchProjectPeople($id);


    $allTasks = $db->selection("tasks",array(
          'where' => array('project_id'=>$id),
          'order_by' => 'id',
          'return_type' => 'all'
        )
    );

    $ispm = false;

    if($_SESSION['userinfo']['role'] == 'project_manager'){
        $ispm = true;
    }

    include "inc/header.php";

?>

    <div class="container">
        <div class="row">
<?php include "inc/sidebar.php"; ?>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">

                        <?php 
                        if(isset($_SESSION["peopleadded"]))
                        {
                        ?>
                            <div class="alert alert-success">
                              <strong>People added!</strong> in this project.
                            </div>
                        <?php
                        }
                        ?> 


                        <?php 
                        if(isset($_SESSION["taskAdded"]))
                        {
                        ?>
                            <div class="alert alert-success">
                              <strong>task added!</strong> in this project.
                            </div>
                        <?php
                        }
                        ?> 


                        <?php 
                        if(isset($_SESSION["peopleAddedToTask"]))
                        {
                        ?>
                            <div class="alert alert-success">
                              <strong>People added!</strong> to this task.
                            </div>
                        <?php
                        }
                        ?> 


                        <?php 
                        if(isset($_SESSION["taskDeleted"]))
                        {
                        ?>
                            <div class="alert alert-success">
                              <strong>Task deleted!</strong> of this task.
                            </div>
                        <?php
                        }
                        ?> 

                        <?php 
                        if(isset($_SESSION["taskAddedError"]))
                        {
                        ?>
                            <div class="alert alert-danger">
                              <strong>Error!</strong> task not added, try again.
                            </div>
                        <?php

                        }
                        ?>

                        <h4 class="text-info text-center"> Project Management Tool </h4>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true"> Description </a>
                                <a class="nav-item nav-link" id="nav-board-tab" data-toggle="tab" href="#nav-board" role="tab" aria-controls="nav-board" aria-selected="false"> Board </a>
                                <a class="nav-item nav-link" id="nav-people-tab" data-toggle="tab" href="#nav-people" role="tab" aria-controls="nav-people" aria-selected="false"> People </a>
                            </div>
                        </nav>


                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                                <div class="card">
                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p> <b> Customer Name: </b> <?php echo $singleProject["customerName"]; ?> </p> 
                                            </div>
                                            <div class="col-lg-6">
                                                <p> <b> Customer Phone: </b> <?php echo $singleProject["customerPhone"]; ?> </p> 
                                            </div>
                                        </div>
        
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p> <b> Customer E-mail: </b> <?php echo $singleProject["customerEmail"]; ?> </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p> <b> Project Deadline: </b> <?php echo $singleProject["projectDeadline"]; ?> </p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="text-justify"> <b> Project Description: </b>
                                                  <?php echo $singleProject["projectDescription"]; ?>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>








                            <!-- Board section code start  -->
                            <div class="tab-pane fade" id="nav-board" role="tabpanel" aria-labelledby="nav-board-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4 class="text-muted"> Task Board: </h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php 

                                                if($_SESSION['userinfo']['role'] == 'project_manager'){
                                                ?>
                                                <p class="text-right">
                                                    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addTaskModal">
                                                        <i class="fas fa-plus"></i> Add Task
                                                    </button>
                                                </p>
                                                <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-hover table-sm text-center">
                                            <thead>
                                                <th> Task Name </th>
                                                <th> People </th>
                                                <th> Progress </th>
                                                <th> Priority </th>
                                                <th> Deadline </th>
                                                <th> Edit </th>
                                                <th> Delete </th>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            foreach ($allTasks as $task) {
$allTaskUsers = $db->fetchTaskPeople($task["id"]);
                                            ?>
                                                <tr>
                                                    <td> <?php echo $task["taskName"]; ?> </td>
                                                    <td> 
                                                        
<?php 

    if($allTaskUsers){
        foreach ($allTaskUsers as $key => $allTaskUser) {
            echo $allTaskUser["username"]."  ";
        }
    }else{ 
        if($ispm){
?>
    <a href="" data-toggle="modal" data-target="#addPeopleToTaskModal<?php echo $task["id"]; ?>">
        Add People
    </a>

<?php }
    echo "no people";
} ?>
                                                     
                                                    </td>
                                                    <td> <?php echo $task["progress"]; ?> </td>
                                                    <td> <?php echo $task["priority"]; ?> </td>
                                                    <td> <?php echo $task["deadline"]; ?> </td>
                                                    <td>
                                                        <?php if($ispm) { ?>
                                                        <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editTaskModal<?php echo $task["id"]; ?>" >
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <?php } ?>
                                                    </td>
                                                    <td> 
                                                        <?php if($ispm) { ?>
                                                        <a class="bth btn-sm btn-outline-danger" href="deleteTask.php?project_id=<?php echo $id; ?>&task_id=<?php echo $task["id"]; ?>"> 
                                                            <i class="fas fa-trash-alt"></i> 
                                                            
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                <!-- This below code show madal for add people -->
                                <div class="modal fade" id="addPeopleToTaskModal<?php echo $task["id"]; ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="addPeopleToTask.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Add people to task </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                
                                                <div class="modal-body">
<?php 
foreach ($allUsers as $user) {
    if( $user["role"] != "project_manager" ) {
?>
<div class="checkbox">
    <label class="checkbox-inline">
        <input name="people<?php echo $user["id"]; ?>" type="checkbox" value="<?php echo $user["id"]; ?>"> <?php echo $user["username"]; ?> 
    </label>
</div>
<?php }  } ?>   
                                                </div>

                                                <input type="text" name="project_id" value="<?php echo $singleProject["id"]; ?>" hidden="hidden"> 
                                                <input type="text" name="task_id" value="<?php echo $task["id"]; ?>" hidden="hidden"> 
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-plus"></i> Update Task </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div> 

                                <!-- End of the edadd people modal code -->



                                <!-- This below code show madal for edit task -->
                                <div class="modal fade" id="editTaskModal<?php echo $task["id"]; ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="editTask.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Edit Task </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="taskname"> Task Name: </label>
                                                        <input value="<?php echo $task["taskName"]; ?>" type="text" name="taskName" id="taskname" class="form-control" required>
                                                    </div>
                                                    <input value="<?php echo $task["id"]; ?>" hidden type="text" name="task_id">
                                                    <div class="form-group">
                                                        <label for="requirement"> Requirement: </label>
                                                        <textarea name="requirement" id="requirement" rows="5" class="form-control"><?php echo $task["requirement"]; ?></textarea>
                                                    </div>
                                                    <?php 
                                                        $done = false;
                                                        $ongoing = false;
                                                        if($task["progress"] == "done"){
                                                            $done = true;
                                                        }else{
                                                            $ongoing = true;
                                                        }

                                                        $high = false;
                                                        $middle = false;
                                                        $low = false;
                                                        if($task["priority"] == "high"){
                                                            $high = true;
                                                        }else if($task["priority"] == "middle" ){
                                                            $middle = true;
                                                        }else{
                                                            $low = true;
                                                        }                    

                                                    ?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label for="Progress"> Progress: </label>
                                                                <select name="progress" class="form-control" id="Progress" required>
                                                                    <option <?php if($done){ echo "selected"; } ?>  value="done">Done
                                                                    </option>
                                                                    <option <?php if($ongoing){ echo "selected"; } ?> value="ongoing"> Ongoing 
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="Priority"> Priority: </label>
                                                                <select name="priority" class="form-control" id="Priority" required>
                                                                    <option <?php if($high){ echo "selected"; } ?> value="high">
                                                                     high 
                                                                    </option>
                                                                    <option <?php if($middle){ echo "selected"; } ?> value="middle">
                                                                    Middle 
                                                                    </option>
                                                                    <option <?php if($low){ echo "selected"; } ?> value="low">
                                                                    Low 
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="for-group">
                                                        <label for="deadline"> Deadline: </label>
                                                        <input value="<?php echo $task["deadline"]; ?>" type="date" name="deadline" id="deadline" class="form-control" required>
                                                    </div>
                                                </div>
                                                <input type="text" name="project_id" value="<?php echo $singleProject["id"]; ?>" hidden="hidden"> 
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-plus"></i> Update Task </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- End of the edit task modal code -->                                                
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                <!-- This below code show madal for add task -->
                                <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="addtask.php" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Add Task </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="taskname"> Task Name: </label>                
                                                        <input type="text" name="taskName" id="taskName" class="form-control" required>
                                                    </div>                                                    
                                                    <div class="form-group">
                                                        <label for="requirement"> Requirement: </label>
                                                        <textarea name="requirement" id="requirement" class="form-control" required></textarea>
                                                    </div>                                                 
                                                    <input type="text" name="project_id" value="<?php echo $singleProject["id"]; ?>" hidden="hidden">                   
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label for="Progress"> Progress: </label>
                                                                <select name="progress" class="form-control" id="Progress" required>
                                                                    <option value="done"> Done </option>
                                                                    <option value="ongoing"> Ongoing </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="Priority"> Priority: </label>
                                                                <select name="priority" class="form-control" id="Priority" required>
                                                                    <option value="high"> High </option>
                                                                    <option value="middle"> Middle </option>
                                                                    <option value="low"> Low </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="for-group">
                                                        <label for="deadline"> Deadline: </label>
                                                        <input type="date" name="deadline" id="deadline" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-plus"></i> Add Task </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- End of the add task modal code -->

                            </div> <!-- Board section code end  -->








                            <!-- People section code start  -->
                            <div class="tab-pane fade" id="nav-people" role="tabpanel" aria-labelledby="nav-people-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4 class="text-muted"> List of People: </h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php 

                                                if($_SESSION['userinfo']['role'] == 'project_manager'){
                                                ?>
                                                <p class="text-right">
                                                    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addPeopleModal">
                                                        <i class="fas fa-plus"></i> Add People
                                                    </button>
                                                </p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead>
                                                <th> Name </th>
                                                <th> E-mail </th>
                                            </thead>
                                        <?php foreach ($projectProple as $people) { ?>
                                            <tbody>
                                                <tr>
                                                    <td> <?php echo $people["username"]; ?> </td>
                                                    <td> <?php echo $people["email"]; ?> </td>
                                                </tr>
                                            </tbody>
                                        <?php }  ?>
                                        </table>
                                    </div>
                                </div>

                                <!-- This below code show madal for add people -->
                                <div class="modal fade" id="addPeopleModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Add People </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                
                                            <form action="addPeopleToProject.php" method="POST">
                                                <div class="modal-body">
<?php 
foreach ($allUsers as $user) {
    if( $user["role"] != "project_manager" ) {
?>
<div class="checkbox">
    <label class="checkbox-inline">
        <input name="people<?php echo $user["id"]; ?>" type="checkbox" value="<?php echo $user["id"]; ?>"> <?php echo $user["username"]; ?> 
    </label>
</div>
<?php } } ?>                                              
<input type="text" name="project_id" value="<?php echo $singleProject["id"]; ?>" hidden="hidden">  
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-plus"></i> Add People </button>
                                                </div>                                      
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- End of the add people modal code -->
                            </div> <!-- People section code end  -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 

    include "inc/footer.php";

    if(isset($_SESSION["peopleadded"]))
    {
        unset($_SESSION["peopleadded"]);
    }

    if(isset($_SESSION["taskAdded"]))
    {
        unset($_SESSION["taskAdded"]);
    }

    if(isset($_SESSION["taskAddedError"]))
    {
        unset($_SESSION["taskAddedError"]);
    }

    if(isset($_SESSION["taskDeleted"]))
    {
        unset($_SESSION["taskDeleted"]);
    }
    if(isset($_SESSION["peopleAddedToTask"]))
    {
        unset($_SESSION["peopleAddedToTask"]);
    }

?>