<?php
include("loginCheck.php");  
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ruthless Real Estate</title>

    
	
  </head>
  
  <body>
 
	<?php
	if (isset($_GET["file"]))
	{
		$filename = $_GET["file"];
		echo "<h1>Source Code for: ".$filename."</h1>";
		highlight_file($filename);
	}
	else
	{
		$filename = $_SERVER["SCRIPT_FILENAME"];
		echo "<h1>Source Code for: ".$filename."</h1>";
		highlight_file($filename);
	}
	?>
    
    
</body>
</html>