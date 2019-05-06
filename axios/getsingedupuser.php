<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'].'./config/dbconfig.php';
//include $_SERVER['DOCUMENT_ROOT'].;
$db = new Database();


echo json_encode($_SESSION['user']);