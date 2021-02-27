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
		
		$error = false;
		$query = "SELECT * FROM Property_Image WHERE property_id =".$_GET["propertyid"];
		$headerquery = "SELECT * FROM Property WHERE property_id =".$_GET["propertyid"];
		$headerstmt = oci_parse($conn,$headerquery);
		$stmt = oci_parse($conn,$query);
		
		if(!@oci_execute($headerstmt))
		{
			$error = true;
		}
		if(!@oci_execute($stmt))
		{
			$error = true;
		}
		if(!$error){
		$headerrow = oci_fetch_array($headerstmt);
		
		?>
		
		<div class="container">
		<div class="row">
		<h3><?php echo $headerrow["PROPERTY_STREET"] ;?></h3>
		<h5><?php echo $headerrow["PROPERTY_SUBURB"]." ".$headerrow["PROPERTY_STATE"] ;?></h5>
		<?php
		while($row = oci_fetch_array($stmt))
		
		{
			
			
			$temp = $row["IMAGE_NAME"];
			$src = "../Images/".$temp;
			if($row["IMAGE_MAIN"] == 'y'){
			?>
			
			<div class="col-md-4">
				<p></p>
				<a href="<?php echo $src; ?>" class="img-thumbnail" id="mainimage" >
				  <img src="<?php echo $src; ?>" alt="Missing Property" id="display">
				</a>
				<p></p>
				
				<input class="btn btn-sm btn-warning " value="Delete Photo" type="button"
				 onclick="window.location='propertyImageDelete.php?imagename=<?php echo $temp; ?>&propertyid=<?php echo $_GET["propertyid"]; ?>
				 &imagemain=<?php echo $row["IMAGE_MAIN"]; ?>&imageid=<?php echo $row["IMAGE_ID"]; ?>&Action=Delete'">
			
			</div>
			<?php
			}
			else
			{
			?>
			<div class="col-md-4">
				<p></p>
				<a href="<?php echo $src; ?>" class="img-thumbnail" >
				  <img src="<?php echo $src; ?>" alt="Missing Property" id="display">
				</a>
				<p></p>
				
				<input class="btn btn-sm btn-warning " value="Delete Photo" type="button"
				 onclick="window.location='propertyImageDelete.php?imagename=<?php echo $temp; ?>&propertyid=<?php echo $_GET["propertyid"]; ?>
				 &imagemain=<?php echo $row["IMAGE_MAIN"]; ?>&imageid=<?php echo $row["IMAGE_ID"]; ?>&Action=Delete'">
			
			</div>
			
			
			
			<?php
			}
			
		
		}				
	?>
	 </div>
	 </div>
		</br>
	
	<div class="container">
		<div class="row">
		<div class="col-md-4">
	<button class="btn btn-sm btn-info " type="button" OnClick="window.location='property.php'">Return to List</button>
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
					<p class="text-success bg-danger text-center">Oops there was a problem, please try again later.</p>
					<input  class="btn btn-sm btn-info" type="button" value="Retirn to Property Search"
						OnClick="window.location='property.php'">
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