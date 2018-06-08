<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Home</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	</head>
	
	<body>
	
	
		<?php 
		include_once 'db.php';
		include 'header.php';

		if ((isset($_SESSION['loggedin']) AND ($_SESSION['loggedin'] == 2 OR $_SESSION['loggedin'] == 1 ))) {	
			$uemail = $_SESSION['u_email'];
			$sqll="UPDATE users SET loggedin=1 WHERE email='$uemail';";
			mysqli_query($conn, $sqll);
			$_SESSION['loggedin'] = 1;
		  // Makes it easier to read
			$first_name = $_SESSION['u_first'];
			$last_name = $_SESSION['u_last'];
			$type= $_SESSION['u_type'];
		}
		?>
	</div>
	<div class="container text-center">
		<h1> Welcome to this website!</h1>    
		<h2> Please choose what you wish to do on the top of the screen.</h2>
		<img src="ustepper.jpg" alt="Robotic Manipulator" class="img-responsive" >
	</div>
		<?php 
	include('./footer.php');
?>
    </body>
</html>    
isset
