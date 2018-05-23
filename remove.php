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
// Check if user is logged in using the session variable
if ( $_SESSION['u_type'] == 'A' or $_SESSION['u_type'] == 'a') {
	$ufirst_name = $_SESSION['u_first'];
    $ulast_name = $_SESSION['u_last'];
    $uemail = $_SESSION['u_email'];
	$utype= $_SESSION['u_type'];
}
else {
	echo '<script language="javascript">';
	echo 'alert("Only an administrator can access this page.");';
	echo 'window.location = "index.php";';
	echo '</script>';
	exit();  
}?>
?>

<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Remove an User</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
	<body>

	<div class="container">
		<h2>Please fill the following information to Remove an User:</h2>
		<br>
		<form action="remove.php" method="post">
		  <div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" name="email" class="form-control" placeholder="example: up201809999@fe.up.pt" id="email" required>
		  </div>
		  <button type="submit" class="btn btn-secondary btn-lg" name="submit" >Remove</button>
		</form>
		<br>
	</div>
	
	<?php


		if(isset($_POST['submit'])){

			$email=mysqli_real_escape_string($conn, $_POST['email']);
			
			$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
			$resultCheck=mysqli_num_rows($result);
			
			if($resultCheck <1){				
				echo '<script language="javascript">';
				echo 'alert("Email/user doesnt exist!")';
				echo '</script>';
				exit();
			}
			else{
				if($row=mysqli_fetch_assoc($result)){			
					$sql1="DELETE FROM users WHERE email='$email'";
					if (mysqli_query($conn, $sql1) ) {
						echo '<script language="javascript">';
						echo 'alert("You have sucessufully remove the user.")';
						echo '</script>';
						exit();
					} 
					else {
						error_log("Error: " . $sql1 ."<br>" . mysqli_error($conn));
						header("Location: ../remove.php?remove=connectionerror");
						exit();
					}
					mysqli_close($conn);
					exit();
				}
			}
		}
			
		
	include('./footer.php');
?>
	</body>
</html>
