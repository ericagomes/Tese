<?php
include('./header.php');
include_once 'db.php';

if ( $_SESSION['loggedin'] == 1 OR 	$_SESSION['loggedin'] ==2){
	$first_name = $_SESSION['u_first'];
	$last_name = $_SESSION['u_last'];
	$email = $_SESSION['u_email'];
	$type= $_SESSION['u_type']; 
	$group= $_SESSION['u_group'];
	date_default_timezone_set('Europe/London');
	$today = date("Y-m-d H:i:s");
	$sqll="UPDATE users SET loggedin=3, wait_entrytime=('$today') WHERE email='$email';";
	mysqli_query($conn, $sqll);
	$_SESSION['loggedin'] == 3;
}
else {
	echo '<script language="javascript">';
	echo 'alert("To visit this page, please login.");';
	echo 'window.location = "login.php";';
	echo '</script>';
	exit();  
}
?>


<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Waiting Mode</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
	<body>
		
		<div class="container text-center">
			<h2>Your are currently on the waiting list to enter the Control Page.</h2>
			<h3>When your turn arrives, you willl be redirect to the control page automatically.</h3>
			<h4>To exit the waiting list, just go to another page.</h4>
			<br>
			<video src="http://192.168.105.71:8080/stream.ogg" autoplay="autoplay" controls ></video>
		</div>
		<br>

	<script type="text/javascript">
		var auto_refresh = setInterval(
		function ()
		{
		$('#checkfree').load('check.php').fadeIn("slow");
		}, 10000); // refresh every 10000 milliseconds
	</script>
	
	<div id="checkfree"></div>

<?php 
	
	include('./footer.php');
?>    
    </body>
</html> 
