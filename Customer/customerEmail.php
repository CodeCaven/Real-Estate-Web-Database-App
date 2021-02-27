<?php 
ob_start();
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
    <link href="../Bootstrap-3.3.6/css/bootstrap.css" rel="stylesheet"> 
	<!-- Custom styles for this template -->
    <link href="../ruthless.css" rel="stylesheet">
	
	
	
  </head>
  
  <body>
	<?php
	include("../menu.php");
	include("../connection.php");
	include("customerModals.html");
	$empty = false;
	
	
	
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$empty = false;
	$error = false;
	
	if(isset($_GET["check"])){
		$ids = implode(',',$_GET["check"]);
	}
	else
	{
		$empty = true;
	}
	
	if(!$empty){
		$query = "SELECT customer_email FROM Customer WHERE customer_id IN ($ids)";
		$stmt = oci_parse($conn,$query);
		if(!@oci_execute($stmt))
		{
			$error = true;
		}
		
	}
	if(!$error){
	?>
	<div class="container">
		<div class="page-header">
			<h3>Customer Email</h3>
		  </div>
		  <div class="row">
			<div class="col-md-8">
				<form class="form-horizontal" method="post" action="customerEmailSend.php" onsubmit="return VerifyEmail(this)">
				
				<div class="form-group">
				<label for="email" class="col-sm-2 control-label">To:</label>
				<div class="col-sm-10">
					<input type="text"  class="form-control" id="email" name="email"
						value="<?php
						if(!$empty){
							while($row=oci_fetch_array($stmt))
							{
							echo $row["CUSTOMER_EMAIL"]; 
							echo " , ";
							}
							}
						?>">						
				</div>
			</div>
			
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Subject:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="subject" name="subject" value="">
				</div>
			</div>
			
			
			<div class="form-group">
				<label for="message" class="col-sm-2 control-label">Message:</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="4" id ="message" name="message"></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
				</div>
			</div>
			
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
	<script src="emailValidate.js"></script>
	
</body>
</html>