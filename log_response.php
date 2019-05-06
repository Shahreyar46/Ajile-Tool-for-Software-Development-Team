<?php 
	session_start();
	include 'config/dbconfig.php';
	include 'lib/function.php';
	include 'helper/helper.php';
	$db = new Database();

    extract($_POST);

    $password = md5($password);

    $tbName = "users";
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
	    $userarray = $db->selection($tbName,$selectArr);
	    
    	session::setter("userinfo",$userarray);
    	$_SESSION['user'] = $userarray;
    	session::setter("log_status",true);
        header("Location:home.php");

    }else{

      session::setter("log_prob","Email or password is wrong!!");
      header("Location:home.php");

    }