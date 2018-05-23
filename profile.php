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
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<title>Profile</title>
</head>

<body>

	<div class="container">
	<h1>Welcome to your profile, <?= $first_name?>!</h1>
	<h3>There are the actions you can perfom:</h3>
	<br>
	<a href="logout.php"><button class="btn btn-secondary btn-lg" name="logout"/>Log Out</button></a>
	<a href="changepwd.php"><button class="btn btn-secondary btn-lg" name="changepwd"/>Change Password</button></a>
	<?php	
		if( $_SESSION['u_type'] == 'N' or $_SESSION['u_type'] == 'n' )
		{
		?>
		<a href="groupdet.php"><button class="btn btn-secondary btn-lg" name="list"/>See Group's Details</button></a>
		<?php }
	
		if( $_SESSION['u_type'] == 'A' or $_SESSION['u_type'] == 'a' )
		{
		?>
		<a href="listusers.php"><button class="btn btn-secondary btn-lg" name="list"/>See List of users</button></a>
		<a href="signup.php"><button class="btn btn-secondary btn-lg" name="signup"/>Sign Up an User</button></a>
		<a href="remove.php"><button class="btn btn-secondary btn-lg" name="remove"/>Remove an User</button></a>
		<a href="schedule.php"><button class="btn btn-secondary btn-lg" name="schedule"/>Schedule Group usage</button></a>
		<?php }	?>	

    </div>
    </div>
    
<?php 
	include('./footer.php');
?>
</body>
</html>
