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
	<!-- Data Tables-->
	<link rel="stylesheet" type="text/css" href="../DataTables-1.10.12/css/dataTables.bootstrap.css"/>
  </head>
  
  <body>
  
	<?php
		include("../menu.php");
		include("../connection.php");
		include("sequential2.php");
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$query = "SELECT * FROM Property_Image";
		$stmt = oci_parse($conn,$query);
		
		if(@oci_execute($stmt)){
		
		$file = dirname($_SERVER["SCRIPT_FILENAME"]);
		
		$dir = opendir("../Images");
		$names = array();
		$image_id = array();
		$property_id = array();
		
		$count = 0;
		while($row = oci_fetch_array($stmt))
		{
			$names[$count] = $row["IMAGE_NAME"];
			$image_id[$count] = $row["IMAGE_ID"];
			$property_id[$count] = $row["PROPERTY_ID"];
			$count = $count + 1;
		}
		?>
			<div class="container">
			<div class="page-header">
				<h3>Image Delete</h3>
		  </div>
		<div class="row">
			<div class="col-lg-8">
			<div class="form-group">
			<form method="post"  action="imageDelete.php"  onsubmit="window.location='imgageDelete.php?Action=Delete">
			<button class="btn btn-sm btn-warning " type="submit">Delete Selected Images</button>
			<br></br>
			<table class="display table" id="imagedelete">
			<thead>
			<tr>
				
				<th>Property Street</th>
				<th>Property Suburb</th>
				<th>Image Name</th>
				<th>Image</th>
				<th>Delete</th>
				
			</tr>
			</thead>
			<tbody>
		<?php
		 
		while($file = readdir($dir))
		{
			if(strlen($file) > 4){
			?>
			<tr>
			
			<?php
			$src = "../Images/".$file;
			$index = find2($names, $file);
			if( $index != -1)
			{
				$pid = $property_id[$index];
				$query2 ="SELECT * FROM PROPERTY WHERE property_id = $pid";
				$stmt2 = oci_parse($conn,$query2);
				if(@oci_execute($stmt2)){
					$row2 = oci_fetch_array($stmt2);
					// no error message here in else due to program flow, for Version2 ;)
				
				?>
				
				<td><?php echo $row2["PROPERTY_STREET"] ;?></td>
				<td><?php echo $row2["PROPERTY_SUBURB"] ;?></td>
				<td><?php echo $file ;?></td>
				<td><a href="<?php echo $src; ?>" class="img-thumbnail" >
				<img src="<?php echo $src; ?>" alt="Missing Property" id="deletedisplay"></a></td>
				<td><input type="checkbox" name="check[]" value="<?php echo $image_id[$index]; ?>"></td>
				<?php
				}
				
			}
			else
			{
			?>
			
			<td><?php echo "Image Not Assigned" ;?></td>
			<td></td>
			<td><?php echo $file ;?></td>
			<td><a href="<?php echo $src; ?>" class="img-thumbnail" >
			<img src="<?php echo $src; ?>" alt="Missing Property" id="deletedisplay"></a></td>
			<td><input type="checkbox" name="check[]"  value="<?php echo $file; ?>" ></td>
			
			<?php
			
			}
			}
		}
		
	?>		
			</tr>
			
			</tbody>
			
			</table>
			<button class="btn btn-sm btn-warning " type="submit">Delete Selected Images</button>
			</form>
			</div>
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
					<input  class="btn btn-sm btn-info" type="button" value="Back to Main"
						OnClick="window.location='../main.php'">
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
	<!-- Data Tables-->
	<script type="text/javascript" src="../DataTables-1.10.12/js/jQuery.dataTables.js"></script> 
	<script type="text/javascript" src="../DataTables-1.10.12/js/dataTables.bootstrap.js"></script> 
	<script src="dataTableImage.js"></script> 
	
    
</body>
</html>