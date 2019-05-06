<?php 

	session_start();
	unset($_SESSION['admin_log_status']);
	unset($_SESSION['admininfo']);
	header('Location:index.php');

?>