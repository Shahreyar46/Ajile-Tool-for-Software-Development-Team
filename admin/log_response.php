<?php 
	session_start();
	include 'config/dbconfig.php';
	include 'lib/function.php';
	include 'helper/helper.php';
	$db = new Database();

    extract($_POST);

    $password = md5($password);

    $tbName = "admin";
    $selectArr = array(
      'where' => array('email'=>$email,'password'=>$password),
      'return_type' => 'rowCount'
    );

    $hasRow = $db->selection($tbName,$selectArr);
    
    if($hasRow){

	    $selectArr = array(
	      'where' => array('email'=>$email,'password'=>$password),
	      'return_type' => 'one'
	    ); 
	    $adminarray = $db->selection($tbName,$selectArr);
	    
    	session::setter("admininfo",$adminarray);
    	session::setter("admin_log_status",true);
      header("Location:home.php");

    }else{

      session::setter("admin_log_prob","Email or password is wrong!!");
      header("Location:home.php");

    }