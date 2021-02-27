<?php include("../loginCheck.php");?>
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
	
	<script>
		function confirm_delete()
		{
			window.location='typeDelete.php?typeid=<?php echo $_GET["typeid"];?>&Action=ConfirmDelete'; 
		}
		
		function confirm_delete2()
		{
			window.location='typeDelete.php?typeid=<?php echo $_GET["typeid"];?>&Action=ConfirmDelete2'; 
		}
	</script>
	
	
    
  </head>
  
  <body>
  
	<?php
	include("../menu.php");
	include("../connection.php");
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$query = "SELECT * FROM Property_Type WHERE type_id =".$_GET["typeid"];
	$stmt = oci_parse($conn,$query);
	
	
	
	
	switch($_GET["Action"]){
		case "Delete":
		if(@oci_execute($stmt)){
			$row = oci_fetch_array($stmt);
	?>
		<div class="container">
			<div class="page-header">
				<h3>Confirm Deletion of Property Type</h3>
			  </div>
			  <div class="row">
				<div class="col-md-6">
				  <table class="table">
					<thead>
					  <tr>
						<th>#</th>
						<th>Type Name</th>
					  </tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $row["TYPE_ID"]; ?></td>
							<td><?php echo $row["TYPE_NAME"]; ?></td>
						</tr>
						
						<tr>
							<td><input class="btn btn-sm btn-warning btn-block" type="button" value ="Confirm Deletion" OnClick="confirm_delete();"></td>
							<td><input class="btn btn-sm btn-info btn-block" type="button" value ="Return to List" OnClick="window.location='type.php'"></td>
						</tr>
					  
					</tbody>
				  </table>
				  
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
					<input  class="btn btn-sm btn-info" type="button" value="Return to Property Types"
						OnClick="window.location='type.php'">
				</div>
				</div>
			</div>
			<?php
			}
				break;
			case "ConfirmDelete":
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
					<p class="text-warning bg-warning text-center">Deleting a Property Type will also delete Properties from the list.</p>
					<input class="btn btn-sm btn-warning" type="button" value ="Confirm Deletion" OnClick="confirm_delete2();">
					<input  class="btn btn-sm btn-info" type="button" value="Return to List"
					OnClick="window.location='type.php'">
					</div>
				</div>
				</div>
					
				<?php
					break;
				case "ConfirmDelete2";
				$query="DELETE FROM Property_Type WHERE type_id=".$_GET["typeid"];
				$stmt = oci_parse($conn,$query);
				
				if(@oci_execute($stmt))
				{ 
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-success bg-success text-center">
					The property type has been successfully deleted.
				</p>
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
					<p class="text-success bg-success text-center">Oops, there was a problem, please try again later.</p>
				</div>
				</div>
				</div>
				<?php
				}
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
				<input  class="btn btn-sm btn-info" type="button" value="Return to List"
					OnClick="window.location='type.php'">;
				</div>
				</div>
				</div>
				<?php
				break;
			
		}	
		
			oci_free_statement($stmt);
			oci_close($conn);
		
		?>
	</div>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
	
</body>
</html>