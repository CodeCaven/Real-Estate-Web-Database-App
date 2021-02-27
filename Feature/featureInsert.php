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
	if (empty($_POST["featurename"]))
	{
	?>
	<div class="container">
			<div class="page-header">
			<h3>Property Feature Creation</h3>
		  </div>
		<div class="row">
			<div class="col-md-4">
			<div class="form-group">
			<form method="post" action="featureInsert.php">
				
			  <table class="table">
				<tbody>
				  <tr>
					<td colspan="2"><input name="featurename" type="text" class="form-control" maxlength="30"
					placeholder="Enter a Property Feature" required autofocus></td>
				  </tr>
				  <tr>
					<td><button class="btn btn-sm btn-primary btn-block" type="submit">Create Property Feature</button></td>
					<td><button class="btn btn-sm btn-primary btn-block" type="reset">Clear</button></td>
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
		include("../connection.php");
		include("../cleanSQL.php");
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$temp = CleanSQL($_POST["featurename"]);
		$query="INSERT INTO Feature
		VALUES (feature_seq.nextval,'$temp')";
		$stmt = oci_parse($conn,$query);
		if(!@oci_execute($stmt))
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
		
		
		oci_free_statement($stmt);
		oci_close($conn);
		header("location: feature.php");
		
	}
		
	?>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
	
</body>
</html>