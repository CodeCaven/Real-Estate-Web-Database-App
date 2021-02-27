<?php

session_start();

if (isset($_SESSION["login"]))
{	
	if(!$_SESSION["login"])
	{
		$_SESSION["server"] = $_SERVER["PHP_SELF"];
		header("Location: /FIT2076_11966939/ass2/RuthlessRealEstate/login.php?PHPSESSID=".session_id());
	}
	
}
else
{
	$_SESSION["login"] = false;
	$_SESSION["server"] = $_SERVER["PHP_SELF"];
	header("Location: /FIT2076_11966939/ass2/RuthlessRealEstate/login.php?PHPSESSID=".session_id());
}


?>

