<?php 

class session{

	public static function setter($session_name,$value)
	{
		$_SESSION["$session_name"] = $value;
		return true;
	}
	
	public static function getter($session_name)
	{
		return $_SESSION["$session_name"];
		return true;
	}

	public static function unseter($session_name)
	{
		unset($_SESSION["$session_name"]);
	}

	public static function destroy()
	{
		session_destroy();
	}

}