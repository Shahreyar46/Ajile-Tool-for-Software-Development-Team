<?php 

  session_start();
  include 'config/dbconfig.php';
  include 'lib/function.php';
  include 'helper/helper.php';

  $db = new Database();

  if(!isset($_SESSION["admin_log_status"]))
  {
     header("Location:login.php");
  }

    $tbName = "users";
    $selectArr = array(
      //'select' => array('id','task','time'),
      //'where' => array('id'=>1,'task'=>'task one'),
      //'order_by' => 'id DESC',
      //'limit' => array('0start_index','2how_many'),
      'return_type' => 'all'
    );

    $allUsers = $db->selection($tbName,$selectArr);

   // var_dump($allUsers);



    include 'inc/header.php';

?>



    <div class="container">
        <div class="row">
            
            <div class="col-lg-12">
                <?php 
                    if($_SESSION['admininfo']['role'] == 'admin'){
                ?>
<!--                 <div class="text-right">
    <a class="btn btn-outline-success" href="createproject.html"> <i class="fas fa-plus"></i> Create Project </a>
</div> <br> -->
                <?php
                    }
                ?>
                <div class="card">
                    <div class="card-header">
                    <?php 
                    if(isset($_SESSION["success"]))
                    {
                    ?>
                        <div class="alert alert-success">
                          <strong>Updated!</strong> employee information.
                        </div>
                    <?php
                    }
                    ?>  
                    <!             
                        <h4 class="text-center"> List of Employees </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-light table-sm table-hover text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th> Name </th>
                                    <th> Email </th>
                                    <th> role </th>
                                    <th> Edit </th>
                                </tr>
                            </thead>
                        <?php 
                        foreach ($allUsers as $key => $user) {
                            
                        ?>
                            <tbody>
                                <tr>
                                    <td> <?php echo $user["username"]; ?> </td>
                                    <td> <?php echo $user["email"]; ?> </td>
                                    <td> <?php echo $user["role"]; ?> </td>
                                    <td>
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_<?php echo $user['id']; ?>">Edit</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal_<?php echo $user['id']; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Employee</h4>
        </div>
        <div class="modal-body">
            <form action="edit_role.php" method="POST">
                <div class="form-group">
                    <label for="email">Username:</label>
                    <label class="checkbox-inline"><?php echo $user["username"]; ?></label>
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <label class="checkbox-inline"><?php echo $user["email"]; ?></label>
                    </div>
                <div class="form-group">
                    <label for="email">Designation:</label>
                    <label class="checkbox-inline"><?php echo $user["role"]; ?></label>
                </div>
                <hr>
                <input hidden="hidden" type="text" name="email" value="<?php echo $user["email"]; ?>" >
                <input hidden="hidden" type="text" name="role" value="<?php echo $user["role"]; ?>" >
                <div class="form-group">
                    <label for="sel1">Change Designation:</label>
                    <div class="radio">
                      <label><input type="radio" name="radio" value="project_manager" >Project Manager</label>
                    </div>
                    <div class="radio">
                      <label><input type="radio" name="radio" value="developer">Developer</label>
                    </div>
                </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

                                    </td>
                                </tr>
                            </tbody>
                        <?php 
                            }
                        ?>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>


<?php 

include 'inc/footer.php';


if(isset($_SESSION["success"]))
{
    unset($_SESSION["success"]);
}

?>