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
	include("checked.php");
	include("select.php");
	include("sequential.php");
	include("modals.html");
	include("../menu.php");
	include("../connection.php");
	include("../cleanSQL.php");
	
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$error = false;
	$query = "SELECT p.property_id,p.property_street, p.property_suburb, p.property_state,
			p.property_pc,t.type_name, p.property_type
			FROM property p, property_type t
			WHERE p.PROPERTY_TYPE=t.TYPE_ID
			AND p.PROPERTY_ID = "."$_GET[propertyid]";
			
	$listquery = "SELECT * FROM Property_Type ORDER BY type_name";
	$featurequery = "SELECT * FROM Feature";
	$featurecheck = "SELECT * FROM Property_Feature WHERE property_id =".$_GET["propertyid"];
	$stmt = oci_parse($conn,$query);
	$liststmt = oci_parse($conn,$listquery);
	$featurestmt = oci_parse($conn,$featurequery);
	$checkstmt = oci_parse($conn,$featurecheck);
	if(!@oci_execute($stmt))
	{
		$error = true;
	}
	
	if(!@oci_execute($liststmt))
	{
		$error = true;
		
	}
	
	if(!@oci_execute($featurestmt))
	{
		$error = true;
	}
	
	if(!@oci_execute($checkstmt))
	{
		$error = true;
	}
	
	
	
	switch($_GET["Action"]){
		case "Update":
		if(!$error){
	$row = oci_fetch_array($stmt);
	
	
	$first = array();
	while($checkrow = oci_fetch_array($checkstmt))
	{
		array_push($first, $checkrow["FEATURE_ID"]);
	}
	$_SESSION["first"] = $first;
	?>
	<div class="container">
		<div class="page-header">
			<h3>Property Update</h3>
		  </div>
		<div class="row">
			<div class="col-md-6">
			<div class="form-group">
			<form method="post"  action="propertyUpdate.php?propertyid=<?php echo $_GET["propertyid"]; ?>&Action=ConfirmUpdate"
						onsubmit="return VerifyDataEntry(this)">
				
			  <table class="table">
				<tbody>
				  <tr>
					<td>Property Street</td>
					<td><input id="street" name="street" type="text" class="form-control" maxlength="100" 
							value="<?php echo $row["PROPERTY_STREET"]; ?>"></td>
					</tr>
					<tr>
						<td>Property Suburb</td>
						<td><input id="suburb" name="suburb" type="text" class="form-control" maxlength="50" 
								value="<?php echo $row["PROPERTY_SUBURB"]; ?>" ></td>
				  </tr>
				  <tr>
					<td>Property State</td>
					<td><input id="state" name="state" type="text" class="form-control" maxlength="5" 
							value="<?php echo $row["PROPERTY_STATE"]; ?>" ></td>
					</tr>
				<tr>
					<td>Property PostCode</td>
					<td><input id="postcode" name="postCode" type="text" class="form-control" maxlength="4"
					value="<?php echo $row["PROPERTY_PC"]; ?>" ></td>
				  </tr>
				  <tr>
					<td>Property Type</td>
					<td>
						<select class="form-control" id="types" name="types">
						<?php
							while($listrow = oci_fetch_array($liststmt))
							{
						?>
								<option value="<?php echo $listrow["TYPE_ID"]; ?>" <?php echo fSelect($listrow["TYPE_ID"],$row["PROPERTY_TYPE"]); ?>>
								<?php echo $listrow["TYPE_NAME"]; ?></option>
							<?php
							}
							?>
						</select>
					</td>
				  </tr>
				  <tr>
					<td>Property Features</td>
					<td>
					<?php
							while($featurerow = oci_fetch_array($featurestmt))
							{
								
								$temp = fCheck($first, $featurerow["FEATURE_ID"]); 
								
						?>
								<div class="checkbox-inline">
									<label class="checkbox-inline">
									<input type="checkbox" name="check[]" value="<?php echo $featurerow["FEATURE_ID"]; ?>"
									<?php
									if($temp)
									{
										echo " checked";
									}
									?>
									>
									<?php echo $featurerow["FEATURE_NAME"]; ?></label>
								</div>
							<?php
							}
							?>
					</td>
				  </tr>
				  
					
				  
				</tbody>
			  </table>
			  <button class="btn btn-sm btn-primary " type="submit">Update Property Type</button>
				<button class="btn btn-sm btn-warning " type="button"
				OnClick="window.location='propertyUpdate.php?Action=ConfirmDelete&propertyid=<?php echo $_GET["propertyid"]; ?>'">Delete Property</button>
				<button class="btn btn-sm btn-info " type="button" OnClick="window.location='property.php'">Return to List</button>
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
					<input  class="btn btn-sm btn-info" type="button" value="Go to Property Search"
						OnClick="window.location='property.php'">
				</div>
				</div>
			</div>
			<?php
		}
			break;
			
			case "ConfirmUpdate":
			$street = CleanSQL($_POST["street"]);
			$suburb = CleanSQL($_POST["suburb"]);
			$query="UPDATE Property set property_street='$street',
					property_suburb ='$suburb', property_pc='$_POST[postCode]',
					property_state='$_POST[state]',property_type='$_POST[types]'
					WHERE property_id=".$_GET["propertyid"];
			$stmt = oci_parse($conn,$query);
			$error = false;
			
			if(!@oci_execute($stmt))
			{
				$error = true;
			}
			
			if(!empty($_POST["check"]))
			{
				$second = $_POST["check"];
			}
			else
			{
				$second = array();
			}

			if(!empty($_SESSION["first"]))
			{
				$first = $_SESSION["first"];
			}
			else
			{
				$first = array();
			}
			
			
			for($i = 0; $i < count($first); $i ++){
				$temp = find($second, $first[$i]);
				if (!$temp)
				{
					$query = "DELETE FROM Property_Feature
								WHERE FEATURE_ID = '$first[$i]' AND PROPERTY_ID=".$_GET["propertyid"];
					$stmt = oci_parse($conn,$query);
					if(!@oci_execute($stmt))
					{
						$error = true;
					}
				}
			}
			
			for($i = 0; $i < count($second); $i ++){
				$temp = find($first, $second[$i]);
				if (!$temp)
				{
					$query = "INSERT INTO Property_Feature 
											VALUES($_GET[propertyid],$second[$i],null)";
					$stmt = oci_parse($conn,$query);
					if(!@oci_execute($stmt))
					{
						$error = true;
					}
				}
			}
			
			If(!$error)
			{
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
						<p class="text-success bg-success text-center">The property was successfully updated.</p>
						<input  class="btn btn-sm btn-info" type="button" value="Go to Property List"
							OnClick="window.location='property.php'">
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
					<input  class="btn btn-sm btn-info" type="button" value="Go to Property List"
						OnClick="window.location='property.php'">
				</div>
				</div>
			</div>
			
			
			<?php
			}
			break;
		case "Delete":
			$row = oci_fetch_array($stmt);
			$query="DELETE FROM Property WHERE property_id=".$_GET["propertyid"];
				$stmt = oci_parse($conn,$query);
				if(@oci_execute($stmt))
				{
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
					<p class="text-success bg-success text-center">
					The following property has successfully been deleted.<?php echo $row["PROPERTY_STREET"]; ?>
				</p>
				<input  class="btn btn-sm btn-info" type="button" value="Return to List"
					OnClick="window.location='property.php'">
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
				<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
				
				<input  class="btn btn-sm btn-info" type="button" value="Return to List"
					OnClick="window.location='property.php'">
				</div>
					</div>
				</div>
				<?php
				}
				break;
				
		case "ConfirmDelete":
		$row = oci_fetch_array($stmt);
				?>
				<div class="container">
			<div class="page-header">
				<h3>Confirm Deletion of Property</h3>
			  </div>
			  <div class="row">
				<div class="col-lg-8">
				  <table class="table">
					<thead>
					  <tr>
						<th>#</th>
						<th>Property Street</th>
						<th>Property Suburb</th>
						<th>Property Postcode</th>
						<th>Property Type</th>
					  </tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $row["PROPERTY_ID"]; ?></td>
							<td><?php echo $row["PROPERTY_STREET"]; ?></td>
							<td><?php echo $row["PROPERTY_SUBURB"]; ?></td>
							<td><?php echo $row["PROPERTY_PC"]; ?></td>
							<td><?php echo $row["TYPE_NAME"]; ?></td>
						</tr>
					</tbody>
				  </table>
				  
				  <input class="btn btn-sm btn-warning " type="button" value ="Confirm Deletion"
				  OnClick="window.location='propertyUpdate.php?Action=Delete&propertyid=<?php echo $_GET["propertyid"]; ?>'">
					<input class="btn btn-sm btn-info " type="button" value ="Return to List" OnClick="window.location='property.php'">
					
				</div>
				</div>
	<?php		
	}		
		oci_close($conn);
	?>
	
				
				
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
    <script src="propertyValidate.js"></script>
</body>
</html>