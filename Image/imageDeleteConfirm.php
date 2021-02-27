<?php include("../loginCheck.php");?>
<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ruthless Real Estate</title>

    <!-- Bootstrap -->
    <link href="../Bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="../ruthless.css" rel="stylesheet">
	
  </head>
  
  <body>
  
	<?php
		// if no images are selected and the button is pushed an error message will be 
		// displayed on next page as normal behaviour
		include("../menu.php");
		include("../connection.php");
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$images = $_SESSION["images"];
		$error = false;
		foreach($images as $image)
		{
			if(ord($image) > 47 and ord($image) < 58)
			{
				$query2 = "SELECT * FROM Property_Image WHERE image_id = $image"; 
				$stmt2 = oci_parse($conn,$query2);
				if(@oci_execute($stmt2))
				{
					$row = oci_fetch_array($stmt2);
				}
				else
				{
					$error = true;
				}
				if(!$error)
				{
				$query = "DELETE FROM Property_Image WHERE image_id = $image"; 
				$stmt = oci_parse($conn,$query);
				if(!@oci_execute($stmt))
					{
						$error = true;
					}
					
					if(!$error){
					$temp = $row["IMAGE_NAME"];
					$src = "../Images/".$temp;
						
						if (!unlink($src))
						  {
						  $error = true;
						  }
					}
				}
					
			}
			else
			{
				$src = "../Images/".$image;
				if (!unlink($src))
				  {
				  $error = true;
				  }
			}
		}
		
		if($error)
		{
			?>
			<div class="container">
				<div class="row">
				<div class="col-4">
			<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
			
			<input  class="btn btn-sm btn-info" type="button" value="Return to Images"
				OnClick="window.location='image.php'">
			</div>
				</div>
			</div>
						
		<?php
		}
		else
		{
			?>
			<div class="container">
				<div class="row">
				<div class="col-4">
			<p class="text-success bg-success text-center">The images were successfully deleted.</p>
			<input  class="btn btn-sm btn-info" type="button" value="Return to Images"
				OnClick="window.location='image.php'">

				</div>
				</div>
			</div>
			<?php
		}
		?>
		
	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
	
    
</body>
</html>