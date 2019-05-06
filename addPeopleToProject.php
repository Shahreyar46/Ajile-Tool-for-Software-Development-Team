<?php

	session_start();
	include 'config/dbconfig.php';
	include 'lib/function.php';
	include 'helper/helper.php';

	$db = new Database();
	
	$selectedPeoples = $_POST;




	foreach ($selectedPeoples as $key => $peopleId) {


		//selection
		$tbName = "projectpeoples";
		$selectArr = array(
		  'where' => array('user_id'=>$peopleId,'project_id'=>$selectedPeoples["project_id"]),
		  'return_type' => 'all'
		);

		$hasRow = $db->selection($tbName,$selectArr);

		if(!$hasRow){
			if($key != "project_id"){
				//insertion
				$cond = array(
				  "user_id" => $peopleId,
				  "project_id" => $selectedPeoples["project_id"]
				);
				$isInserted = $db->insertion($tbName,$cond);
			}
		}

		
	}

    session::setter("peopleadded",true);
    header("Location:singleproject.php?id=".$selectedPeoples["project_id"]);
    
//echo "string";exit();