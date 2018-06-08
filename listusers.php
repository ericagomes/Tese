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
		<title>List of Users</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">

	</head>
	
<body>
	
	<div class=container>
		<h1> List of Users</h1>
		<br>
		<?php 
		
		//get results from database
		$result = mysqli_query($conn,"SELECT firstname, lastname, email, admin, group_id, lastlogin, loggedin FROM users ORDER BY firstname");
	
		echo '<table class="table table-hover">
			<thead>
			<tr >';  //initialize table tag
		echo '<th >First Name</td>';  
		echo '<th>Last Name</td>'; 
		echo '<th>Email</td>'; 
		echo '<th>Type</td>'; 
		echo '<th>Group</td>'; 
		echo '<th>Last Login</td>';
		echo '<th>Logged in?</td>';  
		echo '</tr></thead><tbody>'; //end tr tag

		//showing all data
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo '<td>' . $row['firstname'] . '</td>';
			echo '<td>' . $row['lastname'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['admin'] . '</td>';
			echo '<td>' . $row['group_id'] . '</td>';
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





