<?php ob_start(); 

 include("../loginCheck.php");?>
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
	include("customerModals.html");
	include("../menu.php");
	include("../connection.php");
	include("../cleanSQL.php");
	
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	
	$query = "SELECT * FROM Customer WHERE customer_id="."$_GET[customerid]";	
	$stmt = oci_parse($conn,$query);
	
	$check = false;
	if(@oci_execute($stmt))
	{
		$row = oci_fetch_array($stmt);
	}
	else
	{
		$check = true;
	}
	
	if(!$check){
	switch($_GET["Action"]){
		case "Update":
	?>
	<div class="container">
		<div class="page-header">
			<h3>Customer Update</h3>
		  </div>
		<div class="row">
			<div class="col-md-6">
			<div class="form-group">
			<form method="post"  action="customerUpdate.php?customerid=<?php echo $_GET["customerid"]; ?>&Action=ConfirmUpdate"
						onsubmit="return VerifyData(this)">
				
			  <table class="table">
				<tbody>
				  <tr>
					<td>Surname</td>
					<td><input id="c_surname" name="c_surname" type="text" class="form-control" maxlength="50" 
							value="<?php echo $row["CUSTOMER_SURNAME"]; ?>"></td>
					</tr>
					<tr>
						<td>FirstName</td>
						<td><input id="c_first" name="c_first" type="text" class="form-control" maxlength="50" 
								value="<?php echo $row["CUSTOMER_FNAME"]; ?>" ></td>
				  </tr>
				  <tr>
					<td>Address</td>
					<td><input id="c_address" name="c_address" type="text" class="form-control" maxlength="100" 
							value="<?php echo $row["CUSTOMER_STREET"]; ?>" ></td>
					</tr>
				<tr>
					<td>Suburb</td>
					<td><input id="c_suburb" name="c_suburb" type="text" class="form-control" maxlength="50"
					value="<?php echo $row["CUSTOMER_SUBURB"]; ?>" ></td>
				  </tr>
				  <tr>
					<td>State</td>
					<td><input id="c_state" name="c_state" type="text" class="form-control" maxlength="5" 
							value="<?php echo $row["CUSTOMER_STATE"]; ?>"></td>
					</tr>
				<tr>
					<td>PostCode</td>
					<td><input id="c_pc" name="c_pc" type="text" class="form-control" maxlength="4"
							value="<?php echo $row["CUSTOMER_PC"]; ?>" ></td>
				  </tr>
				  <tr>
					<td>Email</td>
					<td><input id="c_email" name="c_email" type="text" class="form-control" maxlength="50" 
							value="<?php echo $row["CUSTOMER_EMAIL"]; ?>"></td>
					</tr>
				<tr>
					<td>Mobile</td>
					<td><input id="mobile" name="mobile" type="text" class="form-control" maxlength="12" 
							value="<?php echo $row["CUSTOMER_MOBILE"]; ?>" ></td>
				  </tr>
				  <tr>
					<td>Mailing List</td>
					<td>
					<?php
						if($row["CUSTOMER_MAILINGLIST"] == 'Y'){
					?>
						<select class="form-control" id="c_list" name="c_list">
						<option value="" disabled selected>Mailing List</option>
						<option value="Y" selected>Yes</option>
						<option value="N">No</option>
						</select>
					<?php
					}
					else
					{
						?>
							<select class="form-control" id="c_list" name="c_list">
						<option value="" disabled selected>Mailing List</option>
						<option value="Y">Yes</option>
						<option value="N" selected>No</option>
						</select>
						
						<?php
					}
					?>
					</td>
				  </tr>
				  
					
				  
				</tbody>
			  </table>
			  <button class="btn btn-sm btn-primary " type="submit">Update Customer</button>
				<button class="btn btn-sm btn-warning " type="button"
				OnClick="window.location='customerUpdate.php?Action=ConfirmDelete&customerid=<?php echo $_GET["customerid"]; ?>'">Delete Customer</button>
				<button class="btn btn-sm btn-info " type="button" OnClick="window.location='customer.php'">Return to List</button>
			  </form>
			  </div>
			</div>
		</div>
	</div>
		
	<?php
	break;
	case "ConfirmUpdate":
			$surname = CleanSQL($_POST["c_surname"]);
			$query="UPDATE Customer set customer_surname='$surname',
					customer_fname ='$_POST[c_first]', customer_street='$_POST[c_address]',
					customer_suburb ='$_POST[c_suburb]', customer_state='$_POST[c_state]',
					customer_pc ='$_POST[c_pc]', customer_email='$_POST[c_email]',
					customer_mobile ='$_POST[mobile]', customer_mailinglist='$_POST[c_list]'
					WHERE customer_id=".$_GET["customerid"];
					
			$stmt = oci_parse($conn,$query);
			$error = false;
			
			if(!@oci_execute($stmt))
			{
				$error = true;
			}
			
			If(!$error)
			{
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
						<p class="text-success bg-success text-center">The customer was successfully updated.</p>
						<input  class="btn btn-sm btn-info" type="button" value="Go to Customer List"
							OnClick="window.location='customer.php'">
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
					<input  class="btn btn-sm btn-info" type="button" value="Go to Customer List"
						OnClick="window.location='customer.php'">
				</div>
				</div>
			</div>
			
			
			<?php
			}
			break;
		case "Delete":
			$query="DELETE FROM Customer WHERE customer_id=".$_GET["customerid"];
				$stmt = oci_parse($conn,$query);
				if(@oci_execute($stmt))
				{
				?>
				<div class="container">
					<div class="row">
					<div class="col-4">
					<p class="text-success bg-success text-center">
					The following customer has successfully been deleted.<?php echo $row["CUSTOMER_FNAME"]." ".$row["CUSTOMER_SURNAME"]; ?>
				</p>
				<input  class="btn btn-sm btn-info" type="button" value="Return to List"
					OnClick="window.location='customer.php'">
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
					OnClick="window.location='customer.php'">
				</div>
					</div>
				</div>
				<?php
				}
			break;
			case "ConfirmDelete":
			?>
				<div class="container">
			<div class="page-header">
				<h3>Confirm Deletion of Customer</h3>
			  </div>
			  <div class="row">
				<div class="col-lg-12">
				  <table class="table">
					<thead>
					  <tr>
						<th>#</th>
						<th>Surname</th>
						<th>First Name</th>
						<th>Address</th>
						<th>Suburb</th>
						<th>State</th>
						<th>Post Code</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Mailing List</th>
					  </tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $row["CUSTOMER_ID"]; ?></td>
							<td><?php echo $row["CUSTOMER_SURNAME"]; ?></td>
							<td><?php echo $row["CUSTOMER_FNAME"]; ?></td>
							<td><?php echo $row["CUSTOMER_STREET"]; ?></td>
							<td><?php echo $row["CUSTOMER_SUBURB"]; ?></td>
							<td><?php echo $row["CUSTOMER_STATE"]; ?></td>
							<td><?php echo $row["CUSTOMER_PC"]; ?></td>
							<td><?php echo $row["CUSTOMER_EMAIL"]; ?></td>
							<td><?php echo $row["CUSTOMER_MOBILE"]; ?></td>
							<td><?php echo $row["CUSTOMER_MAILINGLIST"]; ?></td>
						</tr>
					</tbody>
				  </table>
				  
				  <input class="btn btn-sm btn-warning " type="button" value ="Confirm Deletion"
				  OnClick="window.location='customerUpdate.php?Action=Delete&customerid=<?php echo $_GET["customerid"]; ?>'">
					<input class="btn btn-sm btn-info " type="button" value ="Return to List" OnClick="window.location='customer.php'">
					
				</div>
				</div>
				
		<?php
	 }
	 oci_close($conn);
	}
	else
	{
		?>
			<div class="container">
				<div class="row">
				<div class="col-4">
					<p class="text-success bg-danger text-center">Oops there was a problem, please try again later.</p>
					<input  class="btn btn-sm btn-info" type="button" value="Go to Customer List"
						OnClick="window.location='customer.php'">
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
    <script src="customerValidate.js"></script>
</body>
</html>