<?php
include('./header.php');
include_once 'db.php';
if ( $_SESSION['loggedin'] == 2 OR $_SESSION['loggedin'] == 1 ) {	
	$uemail = $_SESSION['u_email'];
	$sqll="UPDATE users SET loggedin=1 WHERE email='$uemail';";
	mysqli_query($conn, $sqll);
	$_SESSION['loggedin'] = 1;
  // Makes it easier to read
    $first_name = $_SESSION['u_first'];
    $last_name = $_SESSION['u_last'];
	$type= $_SESSION['u_type'];
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
		<title>View Mode</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
	<body>
		
		<div class="container text-center">
		<video src="http://192.168.105.71:8080/stream.ogg" autoplay="autoplay" controls ></video>
		</div>
		<br>
		
<?php 

	include('./footer.php');
?>    
    </body>
</html>    
