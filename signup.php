<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Testes de coisas precisas</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
	</head>
	
	<body>
		
	<div class="header">
		<?php include('./header.html');?>
	</div>
	
	<div> <h2>Please fill the following blanks to sign up</h2></div>
	<br>
	
	<div class="container">
		<form action="/signup.php" method="post">
		<div class="form-group">
			<label for="firstname">First Name</label>
			<input type="text" name="firstname" class="form-control" placeholder="example: John" id="firstname" required>
		</div>
		<div class="form-group">
			<label for="lastname">Last Name</label>
			<input type="text" name="lastname" class="form-control" placeholder="example: Doe" id="lastname" required>
		</div>
		<div class="form-group">
			<label for="class">Class</label>
			<input type="text" name="class" class="form-control" placeholder="example: 12C" id="class">
		</div>
		<div class="form-group">
			<label for="group">Group</label>
			<input type="text" name="group" class="form-control" placeholder="example: 3" id="group">
		</div>
		<div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" name="email" class="form-control" placeholder="example: up201809999@fe.up.pt" id="email" required>
		</div>
		<div class="form-group">
			<label for="admin">Type</label>
			<input type="text" name="admin" class="form-control" id="admin" placeholder="A for admin and N if not" required>
		</div>
		<div class="form-group">
			<label for="pwd">Password:</label>
			<input type="text" name="pwd" class="form-control" id="pwd" placeholder="Password" required>
		</div>
		<button type="submit" class="btn btn-default" name="submit" >Sign Up</button>
		</form>
	
	<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
		
	include_once 'db.php';
		
	if(isset($_POST['submit'])){
			$firstname=mysqli_real_escape_string($conn, $_POST['firstname']);
			$lastname=mysqli_real_escape_string($conn, $_POST['lastname']);
			$class=mysqli_real_escape_string($conn, $_POST['class']);
			$group=mysqli_real_escape_string($conn, $_POST['group']);
			$email=mysqli_real_escape_string($conn, $_POST['email']);
			$admin=mysqli_real_escape_string($conn, $_POST['admin']);
			$pwd=mysqli_real_escape_string($conn, $_POST['pwd']);
			$group_id= $class.$group;
		
		 if(!(preg_match("/^[a-zA-Z]*$/", $firstname)) || !(preg_match("/^[a-zA-Z]*$/", $lastname))){
			echo '<script language="javascript">';
			echo 'alert("Invalid Name!")';
			echo '</script>';
			exit();
		}
		else{
			if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
				echo '<script language="javascript">';
				echo 'alert("Invalid Email!")';
				echo '</script>';
				exit();
			}
			else{
				$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				$resultCheck=mysqli_num_rows($result);
				if($resultCheck > 0){
					echo '<script language="javascript">';
					echo 'alert("Email/user already exists!")';
					echo '</script>';
					exit();
				}
				else{
					$hashedPwd= password_hash($pwd, PASSWORD_DEFAULT);
					$sql1="INSERT INTO users (firstname, lastname, admin, email, password, group_id) VALUES ('$firstname', '$lastname', '$admin', '$email', '$hashedPwd', '$group_id');";
					if (mysqli_query($conn, $sql1)) {
						header("Location: ../signup.php?signup=sucess");
						exit();
					} 
					else {
						error_log("Error: " . $sql1 . "<br>" . mysqli_error($conn));
						header("Location: ../signup.php?signup=connectionerror");
						exit();
					}
					
					mysqli_close($conn);
				}
			}
		}
	}	
	?>
	
	</div>
	</body>
</html>
