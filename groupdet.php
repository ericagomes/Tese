<?php 
include('./header.php');
include_once 'db.php';
if ( $_SESSION['loggedin'] == 2 OR $_SESSION['loggedin'] == 1 ) {	
	$uemail = $_SESSION['u_email'];
	$sqll="UPDATE users SET loggedin=1 WHERE email='$uemail';";
	mysqli_query($conn, $sqll);
	$_SESSION['loggedin'] = 1;
  // Makes it easier to read
    $ufirst_name = $_SESSION['u_first'];
    $ulast_name = $_SESSION['u_last'];
	$utype= $_SESSION['u_type'];
	$ugroup= $_SESSION['u_group'];
}
else {
	echo '<script language="javascript">';
	echo 'alert("Please login to access this page.");';
	echo 'window.location = "login.php";';
	echo '</script>';
	exit();  
}?>

<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Group Details</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	</head>
	
<body>
	
	<div class=container>
		<h1>Group <?= $ugroup?></h1>
		<br>
		<h3>Schedule</h3>
		<br>
		<?php 		
		//get results from database
		$result = mysqli_query($conn,"SELECT begin, end FROM schedule WHERE group_name='$ugroup';");
	
		echo '<table class="table table-hover">
			<thead>
			<tr >';  //initialize table tag
		echo '<th>Group</td>';  
		echo '<th>Begins at</td>'; 
		echo '<th>Ends at</td>';  
		echo '</tr></thead><tbody>'; //end tr tag

		//showing all data
		while ($row = mysqli_fetch_array($result)) {
			echo '<tr>';
			echo '<td>' . $ugroup . '</td>';
			echo '<td>' . $row['begin'] . '</td>';
			echo '<td>' . $row['end'] . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		?>   
	</div> 
	
	<div class=container>
		
		<h3> List of elements </h3>
		<br>
		<?php 
		
		//get results from database
		$result = mysqli_query($conn,"SELECT firstname, lastname, email, lastlogin, loggedin FROM users WHERE group_id='$ugroup';");
	
		echo '<table class="table table-hover">
			<thead>
			<tr >';  //initialize table tag
		echo '<th >First Name</td>';  
		echo '<th>Last Name</td>'; 
		echo '<th>Email</td>'; 
		echo '<th>Last Login</td>';
		echo '<th>Logged in?</td>';  
		echo '</tr></thead><tbody>'; //end tr tag

		//showing all data
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo '<td>' . $row['firstname'] . '</td>';
			echo '<td>' . $row['lastname'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['lastlogin'] . '</td>';
			if($row['loggedin']==1){
				echo '<td> Yes </td>';}
			if($row['loggedin']==2){
				echo '<td> In Control Page </td>';}
			if($row['loggedin']==0){
				echo '<td>No</td>';}
			echo '</tr>';
		}
		echo '</tbody></table>';


		include('./footer.php');
		?>   
	</div> 
    </body>
</html>    





