

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
	
	<div> <h2>Please fill the following blanks with your information to login</h2></div>
	<br>
	
	<div class="container">
		<form action="login.php" method="post">
		  <div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" name="email" class="form-control" placeholder="example: up201809999@fe.up.pt" id="email">
		  </div>
		  <div class="form-group">
			<label for="passwordd">Password:</label>
			<input type="password" name="password" class="form-control" id="password">
		  </div>
		  <div class="checkbox">
			<label><input type="checkbox"> Remember me</label>
		  </div>
		  <button type="submit" class="btn btn-default" name="submit" >Login</button>
		</form>
	<div class="dropdown-divider"></div>
	  <a class="dropdown-item" href="signup.php">New around here? Sign up</a>
	  <br>
	  <a class="dropdown-item" href="#">Forgot password?</a>
	</div>
	</div>
	
	<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
		
		include_once 'db.php';

		if(isset($_POST['submit'])){
			$email=mysqli_real_escape_string($conn, $_POST['email']);
			$password=mysqli_real_escape_string($conn, $_POST['password']);
			
			if(empty($email) || empty($password)){
				header("Location: ../login.php?login=empty");
				exit();
			}
		else {
			$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
			$resultCheck=mysqli_num_rows($result);
			if($resultCheck >0){
				
			$row=mysqli_fetch_assoc($result);
				
			}
		}
	

	?>
	
	</body>
</html>

