<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Log In</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
	<body>
		
	<div class="header">
		<?php include('./header.php');
		include_once 'db.php';
		?>
	</div>
	
	
	<div class="container">
		<h2>Please fill the following information to login:</h2>
		<br>
		<form action="login.php" method="post">
		  <div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" name="email" class="form-control" placeholder="example: up201809999@fe.up.pt" id="email" required>
		  </div>
		  <div class="form-group">	
		 	<label for="password">Password:</label>
			<input type="password" name="password" class="form-control" id="password" required>
		  </div>
		  <button type="submit" class="btn btn-secondary btn-lg" name="submit" >Login</button>
		</form>
		<br>
		<a href="forgot.php"><button class="btn btn-secondary btn-sm" name="forgetpwd"/>I forgot my password</button></a>
	</div>
	
	<?php

		if(isset($_POST['submit'])){
			
			$email=mysqli_real_escape_string($conn, $_POST['email']);
			$password=mysqli_real_escape_string($conn, $_POST['password']);
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
					$hashedPwdCheck= password_verify($password, $row['password']);
					if($hashedPwdCheck == false){
						echo '<script language="javascript">';
						echo 'alert("Wrong Password!")';
						echo '</script>';
						exit();
					}
					elseif($hashedPwdCheck == true){
						$_SESSION['u_id']=$row['id'];
						$_SESSION['u_first']=$row['firstname'];
						$_SESSION['u_last']=$row['lastname'];
						$_SESSION['u_email']=$row['email'];
						$_SESSION['u_type']=$row['admin'];
						$_SESSION['u_group']=$row['group_id'];
						$_SESSION['loggedin']=1;					
						$sql1="UPDATE users SET lastlogin=now() WHERE email='$email'";
						$sql2="UPDATE users SET loggedin=1 WHERE email='$email'";
						if (mysqli_query($conn, $sql1) AND mysqli_query($conn, $sql2) ) {
							header("Location: ../profile.php");
							exit();
						} 
						else {
							error_log("Error: " . $sql1 . $sql2 ."<br>" . mysqli_error($conn));
							header("Location: ../login.php?login=connectionerror");
							exit();
						}
						mysqli_close($conn);
						exit();
					}
				}
			}
			
		}
	include('./footer.php');
?>
	</body>
</html>
