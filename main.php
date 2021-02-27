<?php session_start();
	ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ruthless Real Estate</title>

    <!-- Bootstrap -->
    <link href="Bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="ruthless.css" rel="stylesheet">
	
  </head>
  
  <body>
 
	<?php
		include("connection.php");
		include("menu.php");
		
		include("money.php");
		$conn = oci_connect($UName,$PWord,$Db)
		or die("Couldn't logon.");
		$query = "SELECT p.property_suburb, p.property_state,p.property_street,i.image_name,i.image_main,l.list_price
					FROM Property_Image i, Property p, Property_Listing l
					WHERE p.PROPERTY_ID = i.PROPERTY_ID 
					AND p.PROPERTY_ID = l.PROPERTY_ID";
		$stmt = oci_parse($conn,$query);
		if(@oci_execute($stmt)){
	?>
	<div id="myCarousel" class="carousel slide" data-ride="carousel">

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
  <?php
  $count = 0;
  while($row = oci_fetch_array($stmt))
	{
		$temp = $row["IMAGE_NAME"];
		$main = $row["IMAGE_MAIN"];
			
	if($main == 'y'){
		$src = "Images/".$temp;
	if($count == 0){
	?>
    <div class="item active">
      <img src="<?php echo $src; ?>" alt="Property Missing">
      <div class="carousel-caption">
        <h4><strong><?php echo $row["PROPERTY_STREET"]; ?></strong></h4>
		<h3><strong><?php echo $row["PROPERTY_SUBURB"]." ".$row["PROPERTY_STATE"]; ?></strong></h3>
		<?php
		if(!$row["LIST_PRICE"] == 0 and $row["LIST_PRICE"] < 100000000){
		?>
		<h2><strong><?php echo money($row["LIST_PRICE"]); ?></strong></h2>
		<?php
		}
		?>
      </div>
    </div>
	<?php
	}
	else{
	?>
		<div class="item">
      <img src="<?php echo $src; ?>" alt="Property Missing">
      <div class="carousel-caption">
        <h4><strong><?php echo $row["PROPERTY_STREET"]; ?></strong></h4>
		<h3><strong><?php echo $row["PROPERTY_SUBURB"]." ".$row["PROPERTY_STATE"]; ?></strong></h3>
		<?php
		if(!$row["LIST_PRICE"] == 0 and $row["LIST_PRICE"] < 100000000){
		?>
		<h2><strong><?php echo money($row["LIST_PRICE"]); ?></strong></h2>
		<?php
		}
		?>
      </div>
    </div>
	<?php
	}
	$count = $count + 1;
	
	}
	}
	?>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
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
					<input  class="btn btn-sm btn-info" type="button" value="Retry"
						OnClick="window.location='main.php'">
				</div>
				</div>
			</div>
			<?php
		}

	?>
		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Bootstrap-3.3.6/js/bootstrap.js"></script>
    
</body>
</html>