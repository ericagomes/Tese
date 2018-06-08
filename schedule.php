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
		<h4>Note: Use the "Remove" button if you wish to delete a schedule.</h4>
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
			<label for="i_time">Initial Time</label>
			<input type="datetime-local" name="i_time" class="form-control" id="i_time" required>
		  </div>
		  <div class="form-group">	
			<label for="e_time">End Time</label>
			<input type="datetime-local" name="e_time" class="form-control" id="e_time" required>
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
		//delete old schedules
		date_default_timezone_set('Europe/London');
		$today = date("Y-m-d H:i:s");  
		$del= mysqli_query($conn, "DELETE FROM schedule WHERE (end<'$today')");
		mysqli_query($conn, $del);
		
		//get results from database
		$resultt = mysqli_query($conn, "SELECT * FROM schedule");
	
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
			$beg=$_POST['i_time'];
			$end=$_POST['e_time'];
			$itime=mysqli_real_escape_string($conn, $_POST['i_time']);
			$etime=mysqli_real_escape_string($conn, $_POST['e_time']);
			
			$result0 = mysqli_query($conn, "SELECT group_id FROM users WHERE group_id='$group'");
			$resultCheckk=mysqli_num_rows($result0);
			if($resultCheckk<1){
				echo '<script language="javascript">';
				echo 'alert("Ups! The group you inserted does not have any students. Please sign up some students from that group or choose a different group.")';
				echo '</script>';
				exit();
			}
			else{
				if(($today > $end) OR ($beg > $end)){
						echo '<script language="javascript">';
						echo 'alert("Ups! Something is wrong with the times you tried to input! Please try again.")';
						echo '</script>';
						exit();
					}			
				else{				
					$sql0="INSERT INTO schedule (group_name, begin, end, zone) VALUES ('$group', '$itime', '$etime', '$zone');";
					if (mysqli_query($conn, $sql0)) {
						echo '<script language="javascript">';
						echo 'alert("You have sucessfully scheduled a group.")';
						echo '</script>';
						echo("<script>location.href = '/schedule.php?added';</script>");
					} 
					else {
						error_log("Error: ". $sql0 . "<br>" . mysqli_error($conn));
						echo '<script language="javascript">';
						echo 'alert("Ups! Something went wrong!2")';
						echo '</script>';
						exit();
					}
				mysqli_close($conn);
				}
			}	
		}

		if(isset($_POST['remove'])){
			
			$group=mysqli_real_escape_string($conn, $_POST['group']);
			$itime=mysqli_real_escape_string($conn, $_POST['i_time']);
			$etime=mysqli_real_escape_string($conn, $_POST['e_time']);
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
					$sql1="DELETE FROM schedule WHERE (group_name='$group' AND begin='$itime' AND end='$etime')";
					if (mysqli_query($conn, $sql1) ) {
						echo '<script language="javascript">';
						echo 'alert("You have sucessufully remove the group schedule.")';
						echo '</script>';
						echo("<script>location.href = '/schedule.php?removed';</script>");
					} 
					else {
						error_log("Error: " . $sql1 ."<br>" . mysqli_error($conn));
						echo("<script>location.href = '/schedule.php?error=removeconnection';</script>");
						exit();
					}
					mysqli_close($conn);
				}
			}
		}		
	include('./footer.php');?>   
	</div>
</div> 
</body>
</html>    
