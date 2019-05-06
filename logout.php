<?php 

	session_start();
	unset($_SESSION['log_status']);
	unset($_SESSION['userinfo']);
	header('Location: login.php');

?>