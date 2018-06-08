<?php
include_once 'db.php';
include('./header.php');
$email=$_SESSION['u_email'];
$sql1="UPDATE users SET loggedin=0 WHERE email='$email'";
if (mysqli_query($conn, $sql1)) {
	session_unset();
	session_destroy();

} 
else {
	error_log("Error: " . $sql1 ."<br>" . mysqli_error($conn));
	header("Location: ../logout.php?logout=connectionerror");
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
  <title>Logged Out</title>
</head>

<body>
	<div class="header">
		
	</div>
    <div class="container">
          <h1>Thanks for stopping by!</h1>  
          <p>You have been logged out or you have been inactive for more than 15 minutes.</p>
          <br>
          <a href="index.php"><button class="btn btn-secondary btn-lg"/>Home</button></a>

    </div>
<?php 
	include('./footer.php');
?>
</body>
</html>

