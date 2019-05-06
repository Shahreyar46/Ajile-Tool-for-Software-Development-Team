<?php 
    session_start();
    include 'config/dbconfig.php';
    include 'helper/helper.php';
    $db = new Database();

    extract($_POST);

    $password = md5($password);


    $tbName = "users";
    $selectArr = array(
      'where' => array('email'=>$email),
      'return_type' => 'rowCount'
    );

    $hasRow = $db->selection($tbName,$selectArr);

     if(!$hasRow){

          $tbName = "users";
          $cond = array(
            'username'=>$username,
            'email'=>$email,
            'password'=>$password,
            'role'=>"employee"
          );
          $isInserted = $db->insertion($tbName,$cond);

          if($isInserted){          
              session::setter("reg_suc","registration successfull, please login");
              header("Location:login.php");
          }else{
             header("Location:reg.php");
          }

     }else{
        session::setter("email_exist","Email exist already");
        header("Location:reg.php");
     }


?>