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
	$query = "SELECT * FROM Feature WHERE feature_id =".$_GET["featureid"];
	$stmt = oci_parse($conn,$query);
	
	
	switch($_GET["Action"]){
		case "Update":
		if(@oci_execute($stmt)){
		$row = oci_fetch_array($stmt);
	?>
	<div class="container">
		<div class="page-header">
			<h3>Property Feature Modification</h3>
		  </div>
		<div class="row">
			<div class="col-md-6">
			<div class="form-group">
			<form method="post" action="featureUpdate.php?featureid=<?php echo $_GET["featureid"]; ?>&Action=ConfirmUpdate">
				
			  <table class="table">
				<tbody>
				  <tr>
					<td>Feature Type ID</td>
					<td><?php echo $row["FEATURE_ID"]; ?></td>
				  </tr>
				  <tr>
					<td colspan="2"><input name="featurename" type="text" class="form-control" maxlength="30"
					value="<?php echo $row["FEATURE_NAME"]; ?>" required autofocus></td>
				  </tr>
				  <tr>
					<td><button class="btn btn-sm btn-primary " type="submit">Update Feature</button></td>
					<td><button class="btn btn-sm btn-info " type="button" OnClick="window.location='feature.php'">Return to List</button></td>
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
					<p class="text-success bg-success text-center">Oops, there was a problem, please try again later.</p>
					<button class="btn btn-sm btn-info " type="button" OnClick="window.location='feature.php'">Return to List</button>
				</div>
				</div>
				</div>
		<?php
		}
			break;
			
			case "ConfirmUpdate":
			$query="UPDATE FEATURE set feature_name='$_POST[featurename]' 
					WHERE feature_id=".$_GET["featureid"];
			$stmt = oci_parse($conn,$query);
			if(!@oci_execute($stmt)){
			?>
			<div class="container">
					<div class="row">
					<div class="col-4">
					<p class="text-success bg-success text-center">Oops, there was a problem, please try again later.</p>
					<button class="btn btn-sm btn-info " type="button" OnClick="window.location='feature.php'">Return to List</button>
				</div>
				</div>
				</div>
		<?php
		}
			header("Location: feature.php");
	
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
			
		