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
		<title>Schedule Usage</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	</head>
	
<body>
	
<div class="container">
	<h1> Schedule Usage</h1>
	<br>
	<div class="row">
		<h2>Please fill the following information to schedule a time for a group:</h2>
		<h4>Note: Use only the "Remove" button if you wish to delete a schedule, not to update one.</h4>
		<br>
		<form action="schedule.php" method="post">
		  <div class="form-group">
			<label for="group">Group ID</label>
			<input type="text" name="group" class="form-control" placeholder="example: 10A1" id="group" required>
		  </div>
		   <div class="form-group">
			<label for="zone">Zone</label>
			<input type="text" name="zone" class="form-control" placeholder="1 or 2" id="zone">
		  </div>
		  <div class="form-group">	
			<label for="i_time">Inicial Time</label>
			<input type="datetime-local" name="i_time" class="form-control" id="i_time">
		  </div>
		  <div class="form-group">	
			<label for="e_time">End Time</label>
			<input type="datetime-local" name="e_time" class="form-control" id="e_time">
		  </div>
		  <button type="submit" class="btn btn-secondary btn-lg" name="submit" >Schedule</button>
		<br>
		<br>
		  <button type="submit" class="btn btn-secondary" name="remove" >Remove</button>
		</form>
		<br>
	</div>
	<hr>
	<div class="row">
		
		<h2>This is the current schedule:</h2>
		<br>
		<?php 

		//get results from database
		$resultt = mysqli_query($conn,"SELECT group_name, begin, end FROM schedule");
	
		echo '<table class="table table-hover">
			<thead>
			<tr >';  //initialize table tag
		echo '<th>Group</td>';  
		echo '<th>Zone</td>';  
		echo '<th>Inicial Time</td>'; 
		echo '<th>End Time</td>'; 
		echo '</tr></thead><tbody>'; //end tr tag

		//showing all data
		while ($roww = mysqli_fetch_array($resultt)) {
			echo '<tr>';
			echo '<td>' . $roww['group_name'] . '</td>';
			echo '<td>' . $roww['zone'] . '</td>';
			echo '<td>' . $roww['begin'] . '</td>';
			echo '<td>' . $roww['end'] . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		
		if(isset($_POST['submit'])){
			$group=mysqli_real_escape_string($conn, $_POST['group']);
			$zone=mysqli_real_escape_string($conn, $_POST['zone']);
			$i_time=mysqli_real_escape_string($conn, $_POST['i_time']);
			$e_time=mysqli_real_escape_string($conn, $_POST['e_time']);
			$result = mysqli_query($conn, "SELECT * FROM users WHERE group_id='$group'");
			$resultCheck=mysqli_num_rows($result);

			if ($resultCheck<1){	
				echo '<script language="javascript">';
				echo 'alert("Ups! There isnt any group with that ID on the website! Please add an user from that group.")';
				echo '</script>';
				exit();
			}			
			else{
				$result1 = mysqli_query($conn, "SELECT * FROM schedule WHERE group_name='$group'");
				$resultCheck1=mysqli_num_rows($result1);
				if($resultCheck1<1){
					$sql1="INSERT INTO schedule (group_name, begin, end, zone) VALUES ('$group','$i_time', '$e_time', '$zone');";
				}
				else{
					$sql1="UPDATE schedule SET begin=('$i_time'), end=('$e_time') WHERE group_name='$group';";
				}
				if (mysqli_query($conn, $sql1)) {
					echo '<script language="javascript">';
					echo 'alert("You have sucessfully scheduled a group.");';
					echo '</script>';
					header("Refresh:0");
					exit();
				} 
				else {
					error_log("Error: " . $sql1 . "<br>" . mysqli_error($conn));
					echo '<script language="javascript">';
					echo 'alert("Ups! Something went wrong!")';
					echo '</script>';
					exit();
				}
			}	
		}
			
		if(isset($_POST['remove'])){
			
			$group=mysqli_real_escape_string($conn, $_POST['group']);
			$result = mysqli_query($conn, "SELECT * FROM schedule WHERE group_name='$group'");
			$resultCheck=mysqli_num_rows($result);
			
			if($resultCheck <1){				
				echo '<script language="javascript">';
				echo 'alert("Group doesnt exist!")';
				echo '</script>';
				exit();
			}
			else{
				if($row=mysqli_fetch_assoc($result)){			
					$sql1="DELETE FROM schedule WHERE group_name='$group'";
					if (mysqli_query($conn, $sql1) ) {
						echo '<script language="javascript">';
						echo 'alert("You have sucessufully remove the group schedule.")';
						echo '</script>';
						header("Refresh:0");
						exit();
					} 
					else {
						error_log("Error: " . $sql1 ."<br>" . mysqli_error($conn));
						header("Location: ../schedule.php?schedule=connectionerror");
						exit();
					}
					mysqli_close($conn);
					exit();
				}
			}
		}		
	include('./footer.php');
?>   
	</div>
</div> 
</body>
</html>    
