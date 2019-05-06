<?php

    session_start();

    //require_once $_SERVER['DOCUMENT_ROOT'].'./config/dbconfig.php';

    require_once '../config/dbconfig.php';

    require '../vendor/autoload.php';

    $db = new Database;

    extract($_POST);

    $isInserted = $db->insertion('msgs',['from'=>$from,'to'=>$to,'msg'=>$msg]);

    $msg = $db->selection("msgs",[
        'where'=>['from'=>$from,'to'=>$to,'msg'=>$msg],
        'return_type' => 'one'
    ]);

    $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '615ab82d58d43b853e3b',
        'e911fa426235d85568ef',
        '646167',
        $options
    );

    $data['message'] = $msg;
    $pusher->trigger('my-channel', 'my-event', $data);

    // echo json_encode($msg); die();

    // if(!$isInserted){
    //     echo json_encode($isInserted);
    //     die();
    // }else{
    //     echo json_encode($isInserted);
    // }