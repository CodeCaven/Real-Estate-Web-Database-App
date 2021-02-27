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
	
  </head>
  
  <body>
	<?php
	include("../menu.php");
	require_once("Property_DAO.php");
	require_once("Feature_DAO.php");
	require_once("DB.php");
	require_once("compare.php");
	require_once("../money.php");
	
	$conn = new DB();
	
	if($conn->get_conn())
	{
		$feat = new DAO_Feature($conn->get_conn());
	}
	
	if(empty($_POST["suburb"])){
	?>
	
	<div class="container">
		<div class="page-header">
			<h3>Search a Property</h3>
		  </div>
		<div class="row">
			<div class="col-md-8">
			<div class="form-group">
			<form method="post"  action="search.php">
				
			  <table class="table">
				<tbody>
					<tr>
						<td><input id="suburb" name="suburb" type="text" class="form-control" placeholder="Search by Suburb" maxlength="50" required></td>
				  </tr>
				  <tr>
					<td><input id="type" name="type" type="text" class="form-control" placeholder="Search by Property Type" maxlength="50" ></td>
					</tr>
					<tr>
					<td>
					<?php
							
							if($rs = $feat->find(array()))
							{
								for ($i = 0; $i < $rs->rowCount(); $i++)
								{
									$featurerow = $rs->getNext(new DAO_Feature($conn->get_conn()), $i);
								
						?>
								
									<label class="checkbox-inline">
									<input type="checkbox" name="checkbox[]" value="<?php echo $featurerow->FEATURE_ID; ?>">
									<?php echo $featurerow->FEATURE_NAME; ?></label>
								
							<?php
								}
							}
							
							?>
					</td>
				  </tr>
				  <tr>
					<td><button type="submit" class="btn btn-sm btn-info ">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
					</button>
					<button class="btn btn-sm btn-info " type="reset" >Clear All Fields</button></td>
				  </tr>
				</tbody>
			  </table>
			  </form>
			  </div>
			</div>
		</div>
	</div>
	<?php
	}
	else
	{
		$prop = new DAO_Property($conn->get_conn());
		
		$suburb = $_POST['suburb'];
		$where = array();
		$where["property_suburb"] = $suburb;
		
		if(!empty($_POST['type'])){
			$type = $_POST['type'];
			$where["type_name"] = $type;
		}
		
		$empty = true;
		
		?>
		<div class="container">
		<div class="page-header">
			<h3>Search Results</h3>
		  </div>
		  <div class="row">
			<div class="col-lg-12">
			  <table class="table"  id="search">
				<thead>
				  <tr>
					<th>Street</th>
					<th>Suburb</th>
					<th>State</th>
					<th>PostCode</th>
					<th>Type</th>
					<th>Listed Price</th>
					<th>Features</th>
				  </tr>
				</thead>
				<tbody>
		<?php
		if($rs = $prop->search($where))
		{
			?>
			
			<?php
			for ($i = 0; $i < $rs->rowCount(); $i++)
			{
				$proprow = $rs->getNext(new DAO_Property($conn->get_conn()), $i);
				$proprow->find_features();
				$proprow->getPrice();
				
				if(!isset($_POST["checkbox"])){
					$empty = false;
		?>
					<tr>
						<td><?php echo $proprow->PROPERTY_STREET; ?></td>
						<td><?php echo $proprow->PROPERTY_SUBURB; ?></td>
						<td><?php echo $proprow->PROPERTY_STATE; ?></td>
						<td><?php echo $proprow->PROPERTY_PC; ?></td>
						<td><?php echo $proprow->TYPE_NAME; ?></td>
						<td><?php if($proprow->LIST_PRICE > 0){echo money($proprow->LIST_PRICE);}else{ echo "Not Listed";}?></td>
						<td><?php for($j = 0; $j<count($proprow->FEATURES_NAMES); $j++){echo $proprow->FEATURES_NAMES[$j];
														if($j != count($proprow->FEATURES_NAMES)-1){echo ", ";}} ?></td>
					</tr>
		<?php
				}
				else{
					if(compare($_POST["checkbox"], $proprow->FEATURES)){
						$empty = false;
						?>
						<tr>
							<td><?php echo $proprow->PROPERTY_STREET; ?></td>
							<td><?php echo $proprow->PROPERTY_SUBURB; ?></td>
							<td><?php echo $proprow->PROPERTY_STATE; ?></td>
							<td><?php echo $proprow->PROPERTY_PC; ?></td>
							<td><?php echo $proprow->TYPE_NAME; ?></td>
							<td><?php if($proprow->LIST_PRICE > 0){echo money($proprow->LIST_PRICE);}else{ echo "Not Listed";} ?></td>
							<td><?php for($j = 0; $j<count($proprow->FEATURES_NAMES); $j++){echo $proprow->FEATURES_NAMES[$j];
														if($j != count($proprow->FEATURES_NAMES)-1){echo ", ";}} ?></td>
						</tr>
						
						<?php
					}
				
				}
				
			}
			
				if($empty){
				?>
					<tr>
							<td>NO DATA MATCHED THE SEARCH CRITERIA</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
				
				<?php
				}
			  ?>
			</tbody>
			  </table>
			  
			  <input  class="btn btn-sm btn-info" type="button" value="Another Search"
						OnClick="window.location='search.php'">
			</div>
		</div>
	</div>
	<?php
		}
		else
		{
			?>
					<tr>
							<td>NO DATA MATCHED THE SEARCH CRITERIA</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						</tbody>
			  </table>
			  
			  <input  class="btn btn-sm btn-info" type="button" value="Another Search"
						OnClick="window.location='search.php'">
			</div>
		</div>
	</div>	
				<?php
		}	
	}
	?>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
    
</body>
</html>