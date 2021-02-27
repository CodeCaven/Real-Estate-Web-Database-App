<?php ob_start();
include("../loginCheck.php"); ?>
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
	include("listModal.html");
	include("../menu.php");
	include("../connection.php");
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$query = "SELECT p.property_street, p.property_suburb, l.list_price, p.property_id
				  FROM Property p, Property_Listing l
          WHERE p.PROPERTY_ID = l.PROPERTY_ID";
	$stmt = oci_parse($conn,$query);
	if(empty($_GET["Action"]))
	{
		$_GET["Action"] = "Display"; 
	}
	
	switch($_GET["Action"]){
		case "Display":
		if(@oci_execute($stmt)){
	?>
	
	<div class="container">
		<div class="page-header">
			<h3>Listed Properties</h3>
		  </div>
		<div class="row">
			<div class="col-md-6">
			<form method="post"  action="listing.php?Action=Update" name="listForm" onsubmit="return listCheck()">
				
			  <table class="table">
			  <tr>
			  <th>Property</th>
			  <th>Listed Price</th>
			  </tr>
				<tbody>
				  <?php
				  $count = 1;
				  while($row = oci_fetch_array($stmt))
					
					{
					
					$index = "index".$count;
					$_SESSION["$index"] = $row["PROPERTY_ID"];
					
				?>
					<tr>
						<td><label><?php echo $row["PROPERTY_STREET"]." ".$row["PROPERTY_SUBURB"] ;?>
							</label></td>
						
						<td>
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control" name="<?php echo $count;?>" 
										value="<?php echo $row["LIST_PRICE"];?>" >
							</div>
						</td>
					</tr>
					<?php
					$count = $count + 1;
					}
					$_SESSION["length"]=$count;
					?>
				</tbody>
			  </table>
			  <button class="btn btn-sm btn-primary " type="submit">Update Listings</button>
			  </form>
			  
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
					<input  class="btn btn-sm btn-info" type="button" value="Go to Main"
						OnClick="window.location='../main.php'">
				</div>
				</div>
			</div>
		<?php
	}
	
	
	break;
	case "Update":
			
			$length = $_SESSION["length"];
			$count = 1;
			$error = false;
			while($count < $length){
				
				$temp = "index";
				$temp = $temp.$count;
				if($_POST[$count] < 0)
				{
					$_POST[$count] = 0;
				}
				$query = "UPDATE Property_Listing SET list_price=$_POST[$count]
							WHERE property_id = $_SESSION[$temp]";
				$stmt = oci_parse($conn,$query);
				if(!@oci_execute($stmt))
				{
					$error = true;
					break;
				}
				$count = $count + 1;
			}
			
			
			if($error)
			{
				?>
				<div class="container">
				<div class="row">
				<div class="col-4">
					<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
					
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
					<p class="text-success bg-success text-center">All listings were updated successfully.</p>
				
				</div>
				</div>
				</div>
			<?php
			}
			?>
			<div class="container">
			<div class="row">
			<div class="col-4">
			<input  class="btn btn-sm btn-info" type="button" value="Return to Listings"
					OnClick="window.location='listing.php'">
			<input  class="btn btn-sm btn-info" type="button" value="Go to Properties"
					OnClick="window.location='../Property/property.php'">
					
				
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
	<script src="listValidate.js"></script>

</body>
</html>