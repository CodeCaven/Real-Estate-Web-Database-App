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
	
	
	include("customerModals.html");
	include("../menu.php");
	include("../connection.php");
	include("../cleanSQL.php");
	
	
	if (empty($_POST["c_first"]))
	{
	?>
	<div class="container">
		<div class="page-header">
			<h3>Enter Customer Details</h3>
		  </div>
		<div class="row">
			<div class="col-md-4">
			<div class="form-group">
			<form method="post"  action="customerInsert.php"
						onsubmit="return VerifyData(this)">
				
			  <table class="table">
				<tbody>
				  <tr>
					<td><input id="c_first" name="c_first" type="text" class="form-control" placeholder="Enter a First Name" maxlength="50" ></td>
					</tr>
					<tr>
						<td><input id="c_surname" name="c_surname" type="text" class="form-control" placeholder="Enter a Surname" maxlength="50" ></td>
				  </tr>
				  <tr>
					<td><input id="c_address" name="c_address" type="text" class="form-control" placeholder="Enter Customer's Address" maxlength="100" ></td>
					</tr>
				<tr>
					<td><input id="c_suburb" name="c_suburb" type="text" class="form-control" placeholder="Enter Customer's Suburb" maxlength="50"></td>
				  </tr>
				<tr>
					<td><input id="c_state" name="c_state" type="text" class="form-control" placeholder="Enter Customer's State" maxlength="5" ></td>
					</tr>
				<tr>
					<td><input id="c_pc" name="c_pc" type="text" class="form-control" placeholder="Enter Customer's Post Code" maxlength="4"></td>
				  </tr>
				  <tr>
					<td><input id="c_email" name="c_email" type="text" class="form-control" placeholder="Enter Customer's Email" maxlength="50"></td>
				  </tr>
				<tr>
					<td><input id="mobile" name="mobile" type="text" class="form-control" placeholder="Enter Customer's Mobile Number" maxlength="12" ></td>
					</tr>
				<tr>
					<td><select class="form-control" id="c_list" name="c_list">
						<option value="" disabled selected>Mailing List</option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
						</select></td>
				  </tr>
				  <tr>
					<td><button class="btn btn-sm btn-primary " type="submit">Create New Customer</button>
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
	}
	else
	{
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$street = CleanSQL($_POST["c_address"]);
		$surname = CleanSQL($_POST["c_surname"]);
		$query="INSERT INTO Customer
		VALUES (cust_seq.nextval,'$surname','$_POST[c_first]','$street','$_POST[c_suburb]'
				,'$_POST[c_state]', '$_POST[c_pc]', '$_POST[c_email]', '$_POST[mobile]', '$_POST[c_list]')";
		$stmt = oci_parse($conn,$query);
		if(@oci_execute($stmt))
		{
		?>
			<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-success bg-success text-center">The customer was successfully added.</p>
				<input  class="btn btn-sm btn-info" type="button" value="Go to Customer List"
					OnClick="window.location='customer.php'">
				<input  class="btn btn-sm btn-info" type="button" value="Add Another Customer"
					OnClick="window.location='customerInsert.php'">
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
				
				<input  class="btn btn-sm btn-info" type="button" value="Go to Customer List"
					OnClick="window.location='customer.php'">
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
    <script src="customerValidate.js"></script>
</body>
</html>