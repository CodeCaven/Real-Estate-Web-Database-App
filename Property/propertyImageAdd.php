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
		include("../connection.php");
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$query = "SELECT * FROM Property_Image WHERE property_id =".$_GET["propertyid"];
		$stmt = oci_parse($conn,$query);
		if(@oci_execute($stmt)){
	
	switch($_GET["Action"]){
			case "Update":	
	
	?>
	
	<div class="container">
		<div class="row">
		<div class="col-4">
			<div class="form-group">
			<form method="post"  action="propertyImageAdd.php?propertyid=<?php echo $_GET["propertyid"]; ?>&Action=Confirm"
					enctype="multipart/form-data" onsubmit="return formcheck(this)">
				<h3>Add a Photo</br>
				<small><?php echo $_GET["propertystreet"]." ".$_GET["suburb"]; ?></small></h3>
				
					<input type="file" name="userfile" accept="image/*" >
				</br>
				
				<div class="checkbox">
					<label><input type="checkbox" value="y" name ="main"><strong class="str">Main Display Photo</strong></label>
				</div>
				<p id="check"></p>
				<button type="submit" class="btn btn-link btn-lg">
					<span class="glyphicon glyphicon-save" aria-hidden="true"></span> Upload
				</button>
				
			</form>
			</div>
			<button class="btn btn-sm btn-info " type="button" OnClick="window.location='property.php'">Return to List</button>
		</div>
		</div>
	 </div>
	 
	 <?php
	 break;
		case "Confirm":
		
		$upfile = "../Images/".$_FILES["userfile"]["name"];
		
		if(!move_uploaded_file($_FILES["userfile"]["tmp_name"],$upfile))
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
		break;
		}
		
		if(empty($_POST["main"]))
		{
			$temp = $_FILES["userfile"]["name"];
			$insert = "INSERT INTO Property_Image VALUES (image_seq.nextval,'$temp', 'n', '$_GET[propertyid]')";
			$stmt = oci_parse($conn,$insert);
			if(@oci_execute($stmt))
			{
			?>
				<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-success bg-success text-center">The image was successfully added.</p>
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
		}
		else
		{
			$update = "UPDATE Property_Image SET image_main = 'n'
				WHERE PROPERTY_ID = ".$_GET["propertyid"];
				
			$temp = $_FILES["userfile"]["name"];
			$insert = "INSERT INTO Property_Image VALUES (image_seq.nextval,'$temp', 'y', '$_GET[propertyid]')";
			$stmt2 = oci_parse($conn,$update);
			$stmt3 = oci_parse($conn,$insert);
			if(@oci_execute($stmt2) && @oci_execute($stmt3))
			{
			?>
				<div class="container">
					<div class="row">
					<div class="col-4">
				<p class="text-success bg-success text-center">The image was successfully added.</p>
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
		}
		break;
	}
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
	?>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
	<script src="imageValidate.js"></script>
    
</body>
</html>