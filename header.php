<?php
		session_start();
		if(isset($_SESSION['loggedin'])){
			$log= $_SESSION['loggedin'];
			echo '<script type="text/javascript">';
			echo "var loggedin = '<?php echo $log; ?>';";
			echo '</script">';
		}
?>

<script type="text/javascript">
	// Set timeout variables.
	var timoutNow = 900000; // Timeout in 15 mins.
	var logoutUrl = 'logout.php'; // URL to logout page.

	var timeoutTimer;

	// Start timers.
	function StartTimers() {
		timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
	}

	// Reset timers.
	function ResetTimers() {
		clearTimeout(timeoutTimer);
		StartTimers();
		$("#timeout").dialog('close');
	}
	    
	// Logout the user.
	function IdleTimeout() {
		if (loggedin != 0){
		window.location = logoutUrl;}
	}	
</script>
    
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8" http-equiv="refresh">
	
	<style>
	.bg{
		background-color: #f2f2f2;
	}</style>
</head>

<body onload="StartTimers();" onmousemove="ResetTimers();">
	
	<div class="container-fluid bg">	
		<div class="page-header">
			<div class="text-center">
				<h1 center>FEUP ChemLab: Control of The Robotic Manipulator</h1>
			</div>
		</div>
	</div>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
		<a class="navbar-brand" href="index.php">FEUP ChemLab</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav">
			<li><a href="index.php">Home</a></li>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="view.php">View Mode</a></li>
			<li><a href="controlposition.php">Control Mode</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">	
			<?php
			
			if( isset($_SESSION['loggedin']))
			{
			?>
			<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
			<?php
			if( $_SESSION['u_type'] == 'A' or $_SESSION['u_type'] == 'a' )
			{
			?>
			<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up an User</a></li>
			<?php
			}
			}	
			else {?>
			<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
			<?php }
			?>				
		</ul>
    </div>
  </div>
</nav>
	
</body>	
</html>	

