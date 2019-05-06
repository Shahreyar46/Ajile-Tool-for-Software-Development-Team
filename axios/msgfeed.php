<?php

    session_start();

    //require_once $_SERVER['DOCUMENT_ROOT'].'./config/dbconfig.php';

    require_once '../config/dbconfig.php';

    $db = new Database;

    extract($_POST);

    $msgs = $db->fetchmsgs('msgs',$from,$to);

    echo json_encode($msgs);