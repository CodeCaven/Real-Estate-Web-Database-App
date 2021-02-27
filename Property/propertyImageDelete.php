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
		include("../menu.php");
		include("../connection.php");
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$query = "DELETE FROM Property_Image WHERE image_id =".$_GET["imageid"];
		$stmt = oci_parse($conn,$query);
		$error = false;
		$file = $_GET["imagename"];
		$file = "../Images/".$file;
		switch($_GET["Action"]){
			case "Delete":	
				if($_GET["imagemain"] == 'y')
				{
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-warning bg-warning text-center">This is a Main Photo, deleting will remove the property from the Home page.</p>
				
				<input  class="btn btn-sm btn-warning" type="button" value="Continue Deletion"
					OnClick="window.location='propertyImageDelete.php?imagename=<?php echo $_GET["imagename"]; ?>&propertyid=<?php echo $_GET["propertyid"]; ?>
				 &imagemain=<?php echo $_GET["imagemain"]; ?>&imageid=<?php echo $_GET["imageid"]; ?>&Action=Confirm'">
				 <input  class="btn btn-sm btn-info" type="button" value="Return to Property List"
							OnClick="window.location='property.php'">
				</div>
					</div>
				</div>
				
				<?php
				}
				else
				{
					if(!@oci_execute($stmt))
					{
						$error = true;
					}
					
					if(!$error){
						if (!unlink($file))
						  {
						  $error = true;
						  }
					}
					
					if(!$error)
						{
						?>
							<div class="container">
								<div class="row">
								<div class="col-4">
							<p class="text-success bg-success text-center">The image was successfully deleted.</p>
							<input  class="btn btn-sm btn-info" type="button" value="Return to List"
								OnClick="window.location='property.php'">

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
							<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
							
							<input  class="btn btn-sm btn-info" type="button" value="Return to List"
								OnClick="window.location='property.php'">
							</div>
								</div>
							</div>
							
						<?php
						}
				}
			break;
			case "Confirm":
					
					if(!@oci_execute($stmt))
					{
						$error = true;
					}
					
					if(!$error){
						if (!unlink($file))
						  {
						  $error = true;
						  }
					}
					
					if(!$error)
					{
					?>
						<div class="container">
							<div class="row">
							<div class="col-4">
						<p class="text-success bg-success text-center">The image was successfully deleted.</p>
						<input  class="btn btn-sm btn-info" type="button" value="Return to List"
							OnClick="window.location='property.php'">

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
						<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
						
						<input  class="btn btn-sm btn-info" type="button" value="Return to List"
							OnClick="window.location='property.php'">
						</div>
							</div>
						</div>
						
					<?php
					}
				break;
		}
		?>
		
		
	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
    
</body>
</html>