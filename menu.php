<?php
ob_start();
?>

 <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a href="/FIT2076_11966939/ass2/RuthlessRealEstate/main.php" class="navbar-brand">Ruthless Real Estate</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Property <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Property/property.php">Search</a></li>
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Property/propertyInsert.php">Create</a></li>
          </ul>
        </li>
		
		<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Customer <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Customer/customer.php">Search</a></li>
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Customer/customerInsert.php">Create</a></li>
            
          </ul>
        </li>
		
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Property Type <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/PropertyType/typeInsert.php">Create</a></li>
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/PropertyType/type.php">Modify</a></li>
            
          </ul>
        </li>
		
		
		
		<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Feature <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Feature/featureInsert.php">Create</a></li>
            <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Feature/feature.php">Modify</a></li>
            
          </ul>
        </li>
		
		<li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Listings/listing.php?Action=Display">Listing </a></li>
		<li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/Image/image.php">Images </a></li>
		<li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/ass3/search.php"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search </a></li>
   
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/FIT2076_11966939/ass2/RuthlessRealEstate/login.php" id="link"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		<script>
		var login;
		var name;
		<?php 
		if(isset($_SESSION["login"]) && isset($_SESSION["name"])){
		
		?>
			login = '<?php echo $_SESSION["login"]; ?>'
			name = '<?php echo $_SESSION["name"]; ?>'
			
			
			<?php
			}
			else
			{
			?>
				login =false;
			<?php
			}
			?>
			if(login){
				document.getElementById("link").innerHTML = "Welcome ".concat(name);
				document.getElementById("link").style.color = "#3366ff";
			}
			</script>
      </ul>
    </div>
  </div>
</nav>

<?php
	$file = $_SERVER["SCRIPT_FILENAME"];
?>
<!-- Fixed footer -->
<div class="navbar navbar-inverse navbar-fixed-bottom" id="footer">
    <div class="container">
      <p class="navbar-text pull-left">© Last modified: 16/10/2016
           <a href="/FIT2076_11966939/ass2/RuthlessRealEstate/documentation.php" >Site Documentation</a>
      </p>
      
      <a type="button"  class="navbar-btn btn-success btn pull-right" href="/FIT2076_11966939/ass2/RuthlessRealEstate/displaySource.php?file=<?php echo $file; ?>"  target="_blank">
		View Source Code
        </a>
    </div>
    
    
  </div>
	
	
