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

    $allUsers = $db->fetchuserlist('users');

//    echo "<pre>";
//    var_dump($allUsers);
//    echo "</pre>";
//    die();

    include "inc/header.php";


?>



    <div id="app" class="container-fluid">
        <div class="row">

        <?php include "inc/sidebar.php" ?>

            <div class="col-lg-7">
                <?php 

                if($_SESSION['userinfo']['role'] == 'project_manager'){
                ?>
                <div class="text-right">
                    <a class="btn btn-outline-success" href="createproject.php"> <i class="fas fa-plus"></i> Create Project </a>
                </div> <br>
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
                              <strong>New project!</strong> added to project list.
                            </div>
                        <?php
                        }
                        ?>
                        <h4 class="text-center"> List of Projects </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-light table-sm table-hover text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th> ID </th>
                                    <th> PROJECT NAME </th>
                                    <th> CUSTOMER NAME </th>
                                    <th> DEADLINE </th>
                                    <?php if($_SESSION['userinfo']['role'] == 'project_manager'){ ?>
                                    <th> Delete </th>
                                    <?php } ?>

                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 0;
                                    foreach ($allProject as $key => $project) {
                                    $datetime = explode(" ",$project["projectDeadline"]);
                                ?>
                                <tr>
                                    <td> <?php echo ++$i; ?> </td>
                                    <td> 
                                        <a class="btn" href="singleproject.php?id=<?php echo $project["id"]; ?>">
                                            <?php echo $project["projectName"]; ?>
                                        </a> 
                                    </td>
                                    <td> <?php echo $project["customerName"]; ?> </td>
                                    <th> <?php echo $datetime[0]; ?> </th>
                                    <?php if($_SESSION['userinfo']['role'] == 'project_manager'){ ?>
                                    <th> 
                                        <a href="deleteProject.php?project_id=<?= $project["id"]; ?>">
                                            delete
                                        </a>
                                    </th>
                                    
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                       
                    </div>
                </div>
            </div>


            <div class="col-lg-2 chat-list" >
                <div class="card">
                    <div class="card-header">
                        Employee list
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php if(!empty($allUsers)){
                            foreach ($allUsers as $user) {
                        ?>
                            <li v-on:click.prevent="chatpopup(event)" data-chatwithid="<?= $user['id']; ?>" class="list-group-item singlechat" >
                                <?= $user['username']; ?>
                            </li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>

            <div id="chat_box">
                <div class="card">
                    <div class="card-header">
                        <h4>{{chatwithname}} <span @click="hidechatbox" style="margin-left: 50%;cursor: pointer;">x</span></h4>
                    </div>
                    <div class="msgfeed">
                        <ul v-chat-scroll>
                            <li :class="msg.to==signedupuser.id ? 'rcv' : 'sent' " v-for="msg in messages">
                                <div class="text">
                                    <p>{{msg.msg}}</p>
                                </div>
                                <div class="by">
                                    by {{ msg.to == signedupuser.id ? chatwithuser.username : "you" }} - {{msg.created_at | momentdate}}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <input @keydown.enter="sendingmsg" v-model="msg" name="msg" type="text" placeholder="type here" class="msgsentbtn">
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