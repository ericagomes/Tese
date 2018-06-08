<?php

include_once 'db.php';
session_start();
date_default_timezone_set('Europe/London');
$today = date("Y-m-d H:i:s");  
$group = $_SESSION['u_group'];
$resultt = mysqli_query($conn, "SELECT * FROM schedule WHERE group_name='$group'");
$row = mysqli_fetch_array($resultt);
if($_SESSION['u_type']=='A' or $_SESSION['u_type']=='a'){
	exit;
	}
elseif($today>$row['end']){
	echo '<script language="javascript">';
	echo 'alert("Your scheduled time has ended. Will be now redirected out of the control page to the view page.");';
	echo 'window.location = "view.php";';
	echo '</script>';
	exit(); 
	}
else{
	exit();
	}	
?>
