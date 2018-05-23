<?php

include_once 'db.php';
$resultt = mysqli_query($conn, "SELECT * FROM users WHERE loggedin=2");
$other=mysqli_num_rows($resultt);

if($other==0){
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
