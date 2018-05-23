<?php include('./header.php');
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
}?>





<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Change Password</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
	<body>
			
	<div class="container">
		<h2>Please fill the following information to change your password:</h2>
		<br>
		<form action="changepwd.php" method="post">
		<div class="form-group">
			<label for="password1">Password:</label>
			<input type="password" name="password1" class="form-control" placeholder="Password" id="password1" required>
		</div>
		<div class="form-group">	
			<label for="newpwd"> New Password:</label>
			<input type="password" name="newpwd" class="form-control" placeholder="New Password" id="newpwd" required>
		</div>	
		<div class="form-group">
			<label for="repeatpwd"> Repeat new Password:</label>
			<input type="password" name="repeatpwd" class="form-control" placeholder="New Password" id="repeatpwd" required>
		</div>
		<br>
		<button type="submit" class="btn btn-secondary btn-lg" name="submit">Change Password</button>
		</form>
		<br>
	</div>
	
	<?php

	if(isset($_POST['submit'])){
		
		$password=mysqli_real_escape_string($conn, $_POST['password1']);
		$pwd=mysqli_real_escape_string($conn, $_POST['newpwd']);
		$repeatpwd=mysqli_real_escape_string($conn, $_POST['repeatpwd']);
		$email=mysqli_real_escape_string($conn, $_SESSION['u_email']);
		$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
		$row=mysqli_fetch_assoc($result);
		$hashedPwdCheck= password_verify($password, $row['password']);
		
		if($hashedPwdCheck == false){				
			echo '<script language="javascript">';
			echo 'alert("You have inputed the wrong password")';
			echo '</script>';
			exit();
		}
		else{
			if($pwd != $repeatpwd){				
			echo '<script language="javascript">';
			echo 'alert("Your password doesn\'t match, please try again")';
			echo '</script>';
			exit();
			}
			
			else{
				$hashedPwd= password_hash($pwd, PASSWORD_DEFAULT);
				$sql1="UPDATE users SET password=('$hashedPwd') WHERE email='$email'";
				if (mysqli_query($conn, $sql1)) {
					echo '<script language="javascript">';
					echo 'alert("Your password has been sucessfully changed")';
					echo '</script>';
					exit();
				} 
				else {
					error_log("Error: " . $sql1 ."<br>" . mysqli_error($conn));
					header("Location: ../changepwd.php?changepwd=connectionerror");
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
