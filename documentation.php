<?php
include("loginCheck.php");  

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ruthless Real Estate</title>
	<!-- Bootstrap -->
    <link href="Bootstrap-3.3.6/css/bootstrap.css" rel="stylesheet"> 
	<!-- Custom styles for this template -->
    <link href="ruthless.css" rel="stylesheet">
    
	
  </head>
  
  <body>
	<?php
	include("menu.php");
  ?>
	<div class="container">
		<div class="page-header">
			<h3>Site Documentation</h3>
		  </div>
		<div class="row">
			<div class="col-md-8">
			<table class="table">
				<thead>
				  <tr>
					<th>Name</th>
					<th>Student ID</th>
				  </tr>
				  
				</thead>
				<tbody>
					<tr>
						<td>Simon Caven</td>
						<td>11966939</td>
					</tr>
					<tr>
						<td>Kabir Gill</td>
						<td>25990837</td>
					</tr>
				</tbody>
			  </table>
			  <h5><strong>Monash DB:</strong> s11966939, monash00</h5>
			  <div class="container">
				<div class="row">
				<div class="col-4">
				
					<form action="Documentation/A2_Ruthless_Tables.txt" target="_blank">
						<button class="btn btn-sm btn-success " type="submit">SQL Create Tables</button>
					</form>
					<p></p>
					<form action="Documentation/SiteDocumentation.pdf" target="_blank">
						<button class="btn btn-sm btn-primary " type="submit">Student Breakdown</button>
					</form>
					<p></p>
					<form action="Documentation/DBtables.htm" target="_blank">
						<button class="btn btn-sm btn-success " type="submit">DataBase</button>
					</form>
					<p></p>
					<form action="Documentation/FUNCTIONALITY.pdf" target="_blank">
						<button class="btn btn-sm btn-primary " type="submit">Functionality</button>
					</form>
					
				
				</div>
				</div>
				</div>
		</div>
		</div>
		</div>
		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Bootstrap-3.3.6/js/bootstrap.js"></script>
	
</body>
</html>