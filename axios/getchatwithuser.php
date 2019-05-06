<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'].'./config/dbconfig.php';

$db = new Database();

extract($_POST);

$chatwithuser = $db->selection('users',[
    'where' => ['id'=>$chatwithid],
    'return_type' => 'one'
]);

echo json_encode($chatwithuser);


//	    $selectArr = array(
//            'where' => array('email'=>$email,'password'=>$password),
//            'return_type' => 'one'
//        );
//	    $userarray = $db->selection($tbName,$selectArr);