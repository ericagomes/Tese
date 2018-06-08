<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Forgotten Password</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
	<body>
		
	<div class="header">
		<?php include('./header.php');?>
	</div>
	
	
	<div class="container">
		<h2>Please fill the following information to retreive your password:</h2>
		<br>
		<form action="forgot.php" method="post">
		  <div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" name="email" class="form-control" placeholder="example: up201809999@fe.up.pt" id="email" required>
		  </div>
		   <button type="submit" class="btn btn-secondary btn-lg" name="submit" >Send new password</button>
		</form>
		<br>
	</div>
	
<?php
	
	function random_password( $length = 8 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

		if(isset($_POST['submit'])){
			
			include_once 'db.php';
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
				
				$row=mysqli_fetch_assoc($result);
				$pass = random_password(8);
				$hashedPwd= password_hash($pass, PASSWORD_DEFAULT);
				$sql1="UPDATE users SET password=('$hashedPwd') WHERE email='$email'";
				if (mysqli_query($conn, $sql1)) {
					$message= "This is you new password:  " . $pass . ". You can change it in your profile.";
					$headers= 'From: recovery@chemlab.pt' . "\r\n" .
							'Reply-To: recovery@chemlab.pt' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();
					$subject="[FEUP ChemLab] Your new password";
					mail($to, $subject, $message, $headers);
					echo '<script language="javascript">';
					echo 'alert("A new password has been sent to your email!")';
					echo '</script>';
					exit();
				} 
				
				else {
					error_log("Error: " . $sql1 ."<br>" . mysqli_error($conn));
					header("Location: ../forgot.php?forgot=connectionerror");
					exit();
				}
				mysqli_close($conn);
				exit();
			}
		}
			
		
	include('./footer.php');
?>
	</body>
</html>
