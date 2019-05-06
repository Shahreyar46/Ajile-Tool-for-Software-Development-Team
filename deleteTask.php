<?php 

	session_start();
	include 'config/dbconfig.php';
	include 'lib/function.php';
	include 'helper/helper.php';

	$db = new Database();

	extract($_GET);

/*	echo $task_id;
	echo $project_id;
exit();*/
	$deleted = $db->delete("tasks",array('id'=>$task_id));
	if($deleted){
	    session::setter("taskDeleted",true);
	    header("Location:singleproject.php?id=".$project_id);	
	}