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
	
	
	include("modals.html");
	include("../menu.php");
	include("../connection.php");
	include("../cleanSQL.php");
	
	
	if (empty($_POST["street"]))
	{
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$listquery = "SELECT * FROM Property_Type ORDER BY type_name";
	$liststmt = oci_parse($conn,$listquery);
	if(@oci_execute($liststmt)){
	?>
	<div class="container">
		<div class="page-header">
			<h3>Create a Property</h3>
		  </div>
		<div class="row">
			<div class="col-md-4">
			<div class="form-group">
			<form method="post"  action="propertyInsert.php"
						onsubmit="return VerifyDataEntry(this)">
				
			  <table class="table">
				<tbody>
				  <tr>
					<td><input id="street" name="street" type="text" class="form-control" placeholder="Enter a Property Street" maxlength="100" ></td>
					</tr>
					<tr>
						<td><input id="suburb" name="suburb" type="text" class="form-control" placeholder="Enter a Property Suburb" maxlength="50" ></td>
				  </tr>
				  <tr>
					<td><input id="state" name="state" type="text" class="form-control" placeholder="Enter a Property State" maxlength="5" ></td>
					</tr>
				<tr>
					<td><input id="postcode" name="postCode" type="text" class="form-control" placeholder="Enter a Postcode" maxlength="4"></td>
				  </tr>
				  <tr>
					<td>
						<select class="form-control" id="proptypes" name="proptypes">
						<option value="" disabled selected>Property Type</option>
						<?php
							while($listrow = oci_fetch_array($liststmt))
							{
						?>
								<option value="<?php echo $listrow["TYPE_ID"]; ?>" >
								<?php echo $listrow["TYPE_NAME"]; ?></option>
							<?php
							}
							?>
						</select>
					</td>
				  </tr>
				  <tr>
					<td><button class="btn btn-sm btn-primary " type="submit">Create New Property</button>
					<button class="btn btn-sm btn-info " type="reset" >Clear All Fields</button></td>
				  </tr>
				</tbody>
			  </table>
			  </form>
			  <p id="test"></p>
			  </div>
			</div>
		</div>
	</div>
		
		<?php
		oci_free_statement($liststmt);
		oci_close($conn);
		}
		else
		{
			?>
			<div class="container">
				<div class="row">
				<div class="col-4">
					<p class="text-success bg-danger text-center">Oops there was a problem, please try again later.</p>
					<input  class="btn btn-sm btn-info" type="button" value="Return to Property Search"
						OnClick="window.location='property.php'">
				</div>
				</div>
			</div>
			<?php
		}
		
	}
	else
	{
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$street = CleanSQL($_POST["street"]);
		$suburb = CleanSQL($_POST["suburb"]);
		$query="INSERT INTO Property
		VALUES (prop_seq.nextval,'$street','$suburb','$_POST[state]','$_POST[postCode]','$_POST[proptypes]')";
		$stmt = oci_parse($conn,$query);
		if(@oci_execute($stmt))
		{
		?>
			<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-success bg-success text-center">The property was successfully added.</p>
				<input  class="btn btn-sm btn-info" type="button" value="Go to Property List"
					OnClick="window.location='property.php'">
				<input  class="btn btn-sm btn-info" type="button" value="Create Another Property"
					OnClick="window.location='propertyInsert.php'">
					</div>
					</div>
				</div>
		
		<?php
		}
		else{
		?>
		<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
				
				<input  class="btn btn-sm btn-info" type="button" value="Go to Property List"
					OnClick="window.location='property.php'">
				</div>
					</div>
				</div>
		<?php
		}
		

		oci_free_statement($stmt);
		oci_close($conn);
		
	}
		
	?>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
    <script src="propertyValidate.js"></script>
</body>
</html>