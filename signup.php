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

<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Sign Up a New User</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
	</head>
	
	<body>
		
		
		
	<div class="container">
		<h2>Please fill the following information to sign up a new user:</h2>
		<br>
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
		<button type="submit" class="btn btn-secondary" name="submit" >Sign Up</button>
		</form>
	
	<?php
			
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
					$sql1="INSERT INTO users (firstname, lastname, admin, email, password, group_id, loggedin) VALUES ('$firstname', '$lastname', '$admin', '$email', '$hashedPwd', '$group_id', 0);";
					if (mysqli_query($conn, $sql1)) {
						header("Location: ../signup.php?signup=sucess");
						exit();
					} 
					else {
						error_log("Error: " . $sql1 . "<br>" . mysqli_error($conn));
							echo '<script language="javascript">';
							echo 'alert("Ups! Something went wrong!")';
							echo '</script>';
							exit();
					}
					
					mysqli_close($conn);
				}
			}
		}
	}	
	
	include('./footer.php');
?>
	
	</div>
	</body>
</html>
