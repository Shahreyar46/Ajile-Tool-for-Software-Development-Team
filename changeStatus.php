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

	extract($_POST);

	$updated = $db->update("tasks",
        array('id'=>$taskid),
        array('progress'=>$data)
    );

    if($updated) {
        echo 1;
    }else{
        echo 0;
    }