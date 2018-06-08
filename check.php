<?php

include_once 'db.php';
session_start();
$email = $_SESSION['u_email'];
$resultt = mysqli_query($conn, "SELECT * FROM users WHERE loggedin=2");
$result3= mysqli_query($conn, "SELECT email, wait_entrytime FROM users WHERE wait_entrytime IS NOT NULL GROUP BY email ORDER BY wait_entrytime ASC LIMIT 1"); 
$other=mysqli_num_rows($resultt);
$row = mysqli_fetch_array($result3);
if($other==0 AND $email==$row['email']){
	$sql="UPDATE users SET wait_entrytime=NULL WHERE email='$email';";
	mysqli_query($conn, $sql);
	echo '<script language="javascript">';
	echo 'alert("You will now be redirected to the control page.");';
	echo 'window.location = "controlposition.php";';
	echo '</script>';
	exit(); 
	}
else{
	exit();
	}	
?>
