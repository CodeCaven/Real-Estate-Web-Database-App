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
	<!-- Data Tables-->
	<link rel="stylesheet" type="text/css" href="../DataTables-1.10.12/css/dataTables.bootstrap.css"/>
	
	<!-- confirm update case, delete, rest js constraints-->
	<!-- no connect error,db monash set up-->
  </head>
  
  <body>
	<?php
	include("../menu.php");
	include("../connection.php");
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$query = "SELECT p.property_id,p.property_street, p.property_suburb, p.property_state,
			p.property_pc,t.type_name
			FROM property p, property_type t
			WHERE p.PROPERTY_TYPE=t.TYPE_ID"; 
	$stmt = oci_parse($conn,$query);
	if(@oci_execute($stmt)){
	?>
	<div class="container">
		<div class="page-header">
			<h3>Property Search</h3>
		  </div>
		  <div class="row">
			<div class="col-lg-12">
			  <table class="table"  id="property">
				<thead>
				<tr>
					<th colspan="6"></th>
					<th></th>
					<th colspan="2"></th>
				</tr>
				  <tr>
					<th>#</th>
					<th>Street</th>
					<th>Suburb</th>
					<th>State</th>
					<th>PostCode</th>
					<th>Type</th>
					<th></th>
					<th></th>
					<th></th>
				  </tr>
				</thead>
				<tbody>
				<?php
					while ($line = oci_fetch_array($stmt))
					{
					?>
						<tr>
							<td><?php echo $line["PROPERTY_ID"]; ?></td>
							<td><?php echo $line["PROPERTY_STREET"]; ?></td>
							<td><?php echo $line["PROPERTY_SUBURB"]; ?></td>
							<td><?php echo $line["PROPERTY_STATE"]; ?></td>
							<td><?php echo $line["PROPERTY_PC"]; ?></td>
							<td><?php echo $line["TYPE_NAME"]; ?></td>
							<td><a href="propertyUpdate.php?propertyid=<?php echo $line["PROPERTY_ID"]; ?>&Action=Update">Modify</a></td>
							<td><a href="propertyDisplay.php?propertyid=<?php echo $line["PROPERTY_ID"]; ?>">View Photos</a></td>
							<td><a href="propertyImageAdd.php?propertyid=<?php echo $line["PROPERTY_ID"]; ?>&Action=Update&propertystreet=<?php echo $line["PROPERTY_STREET"]; ?>&suburb=<?php echo $line["PROPERTY_SUBURB"]; ?>">Add Photo</a></td>
							
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
					<input  class="btn btn-sm btn-info" type="button" value="Go to Main"
						OnClick="window.location='../main.php'">
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
    <!-- Data Tables-->
	<script type="text/javascript" src="../DataTables-1.10.12/js/jQuery.dataTables.js"></script> 
	<script type="text/javascript" src="../DataTables-1.10.12/js/dataTables.bootstrap.js"></script> 
	<script src="../dataTable1.js"></script> 
	
</body>
</html>