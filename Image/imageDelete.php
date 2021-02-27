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
		
		?>
		<div class="container">
			<div class="page-header">
				<h3>Confirm Image Deletion</h3>
		  </div>
		<div class="row">
			<div class="col-md-6">
			<table class="display table" id="imagedelete">
			<thead>
			<tr>
				<th>Property</th>
				<th>Image Name</th>
				<th>Image</th>
			</tr>
			</thead>
			<tbody>
		
		<?php
		$error = false;
		$images = array();
		if(!empty($_POST["check"])){
		foreach($_POST["check"] as $image)
		{
			array_push($images, $image);
			
			if(ord($image) > 47 and ord($image) < 58){
			
				$query = "SELECT * FROM Property_Image WHERE image_id = '$image'"; 
				$stmt = oci_parse($conn,$query);
				
				
				if(@oci_execute($stmt))
				{
					$row = oci_fetch_array($stmt);
					$src = "../Images/".$row["IMAGE_NAME"];
					$query2 = "SELECT * FROM Property WHERE property_id = ".$row["PROPERTY_ID"];
					$stmt2 = oci_parse($conn,$query2);
					if(@oci_execute($stmt2))
					{
						$row2 = oci_fetch_array($stmt2);
					
					?>
					<tr>
						<td><?php echo $row2["PROPERTY_STREET"]." ".$row2["PROPERTY_SUBURB"]; ?></td>
						<td><?php echo $row["IMAGE_NAME"]; ?></td>
						<td><img src="<?php echo $src; ?>" alt="Missing Property" id="deletedisplay"></td>
					</tr>
					
					<?php
					}
					else
					{
						$error = true;
					}
					
				}
				else
				{
					$error = true;
				}
				
			}
			else if (!$error)
			{
				$src = "../Images/".$image;
				?>
						<tr>
							<td>Not Assigned</td>
							<td><?php echo $image ?></td>
							<td><img src="<?php echo $src; ?>" alt="Missing Property" id="deletedisplay"></td>
						</tr>
				<?php
			
			}
			
		}
		$_SESSION["images"] = $images;
		
		
		?>
			</tbody>
			</table>
		<?php
		}
		else
		{
			$error = true;
		}
		if($error)
		{
		?>
		<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
							<input  class="btn btn-sm btn-info" type="button" value="Return to Images"
								OnClick="window.location='image.php'">
		
		<?php
			
		}
		else
		{
		?>
			
			<button class="btn btn-sm btn-warning " type="button" 
			OnClick="window.location='imageDeleteConfirm.php'">Delete Images</button>
			<input  class="btn btn-sm btn-info" type="button" value="Return to Images"
								OnClick="window.location='image.php'">
								
		<?php
			}
		?>
			</div>
			</div>
		</div>
	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
	
    
</body>
</html>