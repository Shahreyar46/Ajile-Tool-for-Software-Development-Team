<?php 

	session_start();
	include 'config/dbconfig.php';
	include 'lib/function.php';
	include 'helper/helper.php';

	$db = new Database();
	
	$selectedPeoples = $_POST;

	//var_dump($_POST);

	foreach ($selectedPeoples as $key => $peopleId) {


		//selection
		$tbName = "tasktopeople";

		$hasRow = $db->selection($tbName,array(
			  'where' => array('user_id'=>$peopleId,'task_id'=>$selectedPeoples["task_id"]),
			  'return_type' => 'rowCount'
			)
		);		

		if(!$hasRow){
			if( $key != "task_id" && $key != "project_id" ){
				//insertion
				$cond = array(
				  "user_id" => $peopleId,
				  "task_id" => $selectedPeoples["task_id"],
				  "project_id" => $selectedPeoples["project_id"]
				);
				$isInserted = $db->insertion($tbName,$cond);
			}
		}

		
	}

    session::setter("peopleAddedToTask",true);
    header("Location:singleproject.php?id=".$selectedPeoples["project_id"]);