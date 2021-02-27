

<?php
	define("MONASH_DIR", "ldap.monash.edu.au");
	define("MONASH_FILTER","o=Monash University, c=au");
	ob_start();
	session_start();

	if (!isset($_SESSION["login"]))
	{
		$_SESSION["server"] = $_SERVER["PHP_SELF"];
		$_SESSION["login"] = false;
	}
	
	// LOG OUT ,top right log in ,every page
	
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
    <link href="Bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="ruthless.css" rel="stylesheet">
	
  </head>
  
  <body>
  <div class="container">
	<?php
	
	include("/menu.php");
	if (empty($_POST["uname"]))
	{
	?>
	
		<form class="form-signin" method="post" action="login.php">
			<h3 class="form-signin-heading" id="log">Authcate Sign In</h3>
			<script>
			var old;
			var login;
			<?php
			if(isset($_SESSION["old"]) && isset($_SESSION["login"])){
			?>
			old = '<?php echo $_SESSION["old"]; ?>'
			login = '<?php echo $_SESSION["login"]; ?>'
			if(login){
				document.getElementById("log").innerHTML = "Welcome, you are logged in";
			}
			else{
				if(old){
					document.getElementById("log").innerHTML = "Incorrect Username or Password";
					<?php $_SESSION["old"] = false; ?>
				}
			}
			<?php
			}
			?>
			
			</script>
			<input type="text" name="uname" class="form-control" placeholder="User Name" required autofocus>
			<input type="password" name="pword" class="form-control" placeholder="Password" required>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<button class="btn btn-lg btn-primary btn-block" type="reset">Reset</button>
		</form>
	</div>
	<?php
	}
	else
	{
		
		$LDAPconn=@ldap_connect(MONASH_DIR);
		if($LDAPconn)
		{
			$LDAPsearch=@ldap_search($LDAPconn, MONASH_FILTER, "uid=".$_POST["uname"]);
			if($LDAPsearch)
			{
				$LDAPinfo =@ldap_first_entry($LDAPconn,$LDAPsearch);
				if($LDAPinfo)
				{
					$LDAPresult=@ldap_bind($LDAPconn,ldap_get_dn($LDAPconn, $LDAPinfo),$_POST["pword"]);
				}
				else
				{
					$LDAPresult=0;
				}
			}
			else
			{
				$LDAPresult=0;
				
			}
		}
		else
		{
			$LDAPresult=0;
			
		}
		if($LDAPresult)
		{
			
			$_SESSION["login"] = true;
			$_SESSION["name"] = $_POST["uname"];
			$temp = $_SESSION["server"];
			header("Location: $temp");
		
		}
		else
		{
			$temp = $_SESSION["server"];
			$_SESSION["old"] = true;
			header("Location: login.php");
		}
	}
	
	
?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Bootstrap-3.3.6/js/bootstrap.js"></script>
    
</body>
</html>