<?php 

	session_start();
	include 'config/dbconfig.php';
	include 'lib/function.php';
	include 'helper/helper.php';

	$db = new Database();

	extract($_POST);

	$cond = array(
	  "user_id" => $_SESSION["userinfo"]["id"],
	  "project_id" => $project_id,
	  "taskName" => $taskName,
	  "requirement" => $requirement,
	  "progress" => $progress,
	  "priority" => $priority,
	  "deadline" => $deadline
	);

	$isInserted = $db->insertion("tasks",$cond);

	if($isInserted){
	    session::setter("taskAdded",true);
	    header("Location:singleproject.php?id=".$project_id);
	}else{
	    session::setter("taskAddedError",true);
	    header("Location:singleproject.php?id=".$project_id);
	}