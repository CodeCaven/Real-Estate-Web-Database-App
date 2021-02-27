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
	include("customerModals.html");
	$ids = explode(',',$_POST["email"]);

	$error = false;
	
	foreach($ids as $email){
		$from = "From: Simon Caven <scav6@student.monash.edu>";
		$to = $email;
		$msg = $_POST["message"];
		$subject = $_POST["subject"];
		if(!@mail($to, $subject, $msg, $from))
		{
			$error = true;
		}
	}
		
		
		
		if(!$error)
		{
		?>
		<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-success bg-success text-center">The email was sent successfully.</p>
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
				<p class="text-warning bg-warning text-center">Oops, there was a problem, please try again later.</p>
				
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
   
	
</body>
</html>