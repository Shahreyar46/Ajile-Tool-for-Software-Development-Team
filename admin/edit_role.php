<?php 

	session_start();
	include 'config/dbconfig.php';
	include 'lib/function.php';
	include 'helper/helper.php';

	$db = new Database();
	//echo $_POST['radio'];exit();
	//var_dump($_POST); exit();

	extract($_POST);

	$tbName = "users";
	$selectArr = array(
	  'where' => array('email'=>$email),
	  'return_type' => 'rowCount'
	); 
	$hasRow = $db->selection($tbName,$selectArr);

	if($hasRow){


		//update
		$updated = $db->update("users",
		  array('email'=>$email)/*cond*/,
		  array('role'=>$radio)/*data*/
		);

		if($updated){
	    	session::setter("success","updated");
	      	header("Location:home.php");			
	      				
		}

	}


