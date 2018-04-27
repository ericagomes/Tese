<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Testes de coisas precisas</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
		<meta charset="utf-8">

	</head>
	
	<body>
		
	<div class="header">
		<?php include('./header.html');?>
	</div>
	
	<div> <h2>Please fill the following blanks to sign up</h2></div>
	<br>
	
	<div class="container">
		<form action="/signup.php">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="name" name="name" class="form-control" placeholder="example: John Doe" id="name" required>
		</div>
		<div class="form-group">
			<label for="class">Class</label>
			<input type="class" name="class" class="form-control" placeholder="example: 12C" id="class" required>
		</div>
		<div class="form-group">
			<label for="group">Class</label>
			<input type="group" name="group" class="form-control" placeholder="example: 3" id="class" required>
		</div>
		<div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" name="email" class="form-control" placeholder="example: up201809999@fe.up.pt" id="email" required>
		</div>
		<div class="form-group">
			<label for="admin">Password:</label>
			<input type="admin" name="admin" class="form-control" id="admin" placeholder="1 for admin and 0 if not" required>
		</div>
		<div class="form-group">
			<label for="pwd">Password:</label>
			<input type="password" name="pwd-repeat" class="form-control" id="pwd" placeholder="Password" required>
		</div>
		<div class="form-group">
			<label for="pwd-repeat">Repeat Password:</label>
			<input type="password" name="pwd-repeat" class="form-control" id="pwd-repeat" placeholder="Repeat Password" required>
		</div>
		<button type="submit" class="btn btn-default" name="submit" >Sign Up</button>
		</form>
	
	<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
		
	include_once 'db.php';

	if(isset($_POST['submit'])){
			$email=mysqli_real_escape_string($conn, $_POST['email']);
			$pwd=mysqli_real_escape_string($conn, $_POST['pwd']);
			$name=mysqli_real_escape_string($conn, $_POST['name']);
			$pwd_repeat=mysqli_real_escape_string($conn, $_POST['pwd-repeat']);
			$class=mysqli_real_escape_string($conn, $_POST['class']);
			$group=mysqli_real_escape_string($conn, $_POST['group']);
			$admin=mysqli_real_escape_string($conn, $_POST['admin']);
			
			//check for errors
			if(empty($email) || empty($password) || empty($name) || empty($class) || empty($group) || empty($pwd) || empty($pwd_repeat){
				header("Location: ../signup.php?signup==empty");
				exit();
			}
			else {
				if(!preg_match("/^[a-zA-Z]*$/", $name)){
				header("Location: ../signup.php?signup=invalid");
				exit();
				}
				else{
					if(filter_var($email, FILTER_VALIDATE_EMAIL)){
						header("Location: ../signup.php?signup=email");
						exit();
					}
					else{
						$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
						$resultCheck=mysqli_num_rows($result);
						if($resultCheck > 0){
							header("Location: ../signup.php?signup=usertaken");
							exit();
						}
						else{
							$hashedPwd= password_hash($pwd, PASSWORD_DEFAULT);
							$sql="INSERT INTO users (name, email, password, admin) VALUES ('$name', '$email', '$hashedPwd', '$admin');";
							mysqli_query($conn, $sql);
							header("Location: ../signup.php?signup=sucess");
							exit();
						}
					}
				}
			}
		}
	?>
	
	</div>
	</body>
</html>
