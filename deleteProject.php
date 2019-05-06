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

	extract($_GET);

	$deleted = $db->delete("projects",array('id'=>$project_id));
	if($deleted){
		session::setter('projectDeleted',true);
		header("Location:home.php");
	}