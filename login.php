<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Testes de coisas precisas</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
	<body>
		
	<div class="header">
		<?php include('./header.html');?>
	</div>
	
	<div> <h2>Please fill the following blanks with your information to login</h2></div>
	<br>
	
	<div class="container">
		<form action="login.php" method="post">
		  <div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" name="email" class="form-control" placeholder="example: up201809999@fe.up.pt" id="email" required>
		  </div>
		  <div class="form-group">
			<label for="passwordd">Password:</label>
			<input type="password" name="password" class="form-control" id="password" required>
		  </div>
		  <div class="checkbox">
			<label><input type="checkbox"> Remember me</label>
		  </div>
		  <button type="submit" class="btn btn-default" name="submit" >Login</button>
		</form>
	</div>
	
	<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	

		if(isset($_POST['submit'])){
			
			include_once 'db.php';
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
						header("Location: ../view.php");
					}
				}
			}
		}
	
	?>
	
	</body>
</html>
