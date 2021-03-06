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
	$query = "SELECT * FROM Property_Type WHERE type_id =".$_GET["typeid"];
	$stmt = oci_parse($conn,$query);
	
	
	
	switch($_GET["Action"]){
		case "Update":
		if(@oci_execute($stmt)){
			$row = oci_fetch_array($stmt);
	?>
	<div class="container">
		<div class="page-header">
			<h3>Property Types Modification</h3>
		  </div>
		<div class="row">
			<div class="col-md-6">
			<div class="form-group">
			<form method="post" action="typeUpdate.php?typeid=<?php echo $_GET["typeid"]; ?>&Action=ConfirmUpdate">
				
			  <table class="table">
				<tbody>
				  <tr>
					<td>Property Type ID</td>
					<td><?php echo $row["TYPE_ID"]; ?></td>
				  </tr>
				  <tr>
					<td colspan="2"><input name="typename" type="text" class="form-control" maxlength="30"
					value="<?php echo $row["TYPE_NAME"]; ?>" required autofocus></td>
				  </tr>
				  <tr>
					<td><button class="btn btn-sm btn-primary " type="submit">Update Property Type</button></td>
					<td><button class="btn btn-sm btn-info " type="button" OnClick="window.location='type.php'">Return to List</button></td>
				  </tr>
				</tbody>
			  </table>
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
					<input  class="btn btn-sm btn-info" type="button" value="Go to Property Types"
						OnClick="window.location='type.php'">
				</div>
				</div>
			</div>
			<?php
		}
			break;
			
			case "ConfirmUpdate":
			$query="UPDATE Property_Type set type_name='$_POST[typename]' 
					WHERE type_id=".$_GET["typeid"];
			$stmt = oci_parse($conn,$query);
			if(!@oci_execute($stmt))
			{
				?>
			<div class="container">
				<div class="row">
				<div class="col-4">
					<p class="text-success bg-danger text-center">Oops there was a problem, please try again later.</p>
					<input  class="btn btn-sm btn-info" type="button" value="Go to Property Types"
						OnClick="window.location='type.php'">
				</div>
				</div>
			</div>
			<?php
			}
			else{
			header("Location: type.php");
			}
			break;
		
	}	
	
		oci_free_statement($stmt);
		oci_close($conn);
	?>	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
    
</body>
</html>
			
		