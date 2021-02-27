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
    <link href="../Bootstrap-3.3.6/css/bootstrap.css" rel="stylesheet"> 
	<!-- Custom styles for this template -->
    <link href="../ruthless.css" rel="stylesheet">
	
  </head>
  
  <body>

	<?php
	include("../menu.php");
	include("../connection.php");
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$query = "SELECT * FROM Feature";
	$stmt = oci_parse($conn,$query);
	if(@oci_execute($stmt)){
	?>
	
	<div class ="container">
		<div class="page-header">
			<h3>Property Features</h3>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <table class="table">
				<thead>
				  <tr>
					<th>#</th>
					<th>Feature Name</th>
					<th>Edit</th>
					<th>Delete</th>
				  </tr>
				</thead>
				<tbody>
				<?php
					while ($line = oci_fetch_array($stmt))
					{
					?>
						<tr>
							<td><?php echo $line["FEATURE_ID"]; ?></td>
							<td><?php echo $line["FEATURE_NAME"]; ?></td>
							<td><a href="featureUpdate.php?featureid=<?php echo $line["FEATURE_ID"]; ?>&Action=Update">Update</a></td>
							<td><a href="featureDelete.php?featureid=<?php echo $line["FEATURE_ID"]; ?>&Action=Delete">Delete</a></td>
						</tr>
						<?php
					}
					?> 
				</tbody>
			  </table>
			</div>
		</div>
	</div>
	
	<?php
	
		oci_free_statement($stmt);
		oci_close($conn);
	}
	else
	{
		?>
		<div class="container">
				<div class="row">
				<div class="col-4">
					<p class="text-success bg-danger text-center">Oops there was a problem, please try again later.</p>
					<input  class="btn btn-sm btn-info" type="button" value="Retry"
						OnClick="window.location='feature.php'">
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