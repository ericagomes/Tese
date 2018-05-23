<script type="text/javascript">
	function getConfirmation(){
	   var retVal = confirm("Someone is already using the control page. Would you like to go to the waiting list?");
	   if( retVal == true ){
		 window.location = "wait.php";
		 return true;
	   }
	   else{
		  window.location = "view.php";
		  return false;
	   }
	}
</script>
      
<?php
	include('./header.php');
	include_once 'db.php';
	
	$resultt = mysqli_query($conn, "SELECT * FROM users WHERE loggedin=2");
	$other=mysqli_num_rows($resultt);
	
// Check if user is logged in using the session variable
if($_SESSION['loggedin'] == 0) {
	echo '<script language="javascript">';
	echo 'alert("Please login to enter this page.");';
	echo 'window.location = "login.php";';
	echo '</script>';
	exit();  
}

elseif($_SESSION['loggedin'] == 1 AND $other>0) {
	echo '<script language="javascript">';
	echo 'getConfirmation();';
	echo '</script>';
	exit(); 
}
elseif (($_SESSION['loggedin'] == 1 AND $other==0)) {
	 // Makes it easier to read
    $first_name = $_SESSION['u_first'];
	$last_name = $_SESSION['u_last'];
	$email = $_SESSION['u_email'];
	$type= $_SESSION['u_type']; 
	$group= $_SESSION['u_group'];
	$sqll="UPDATE users SET loggedin=2 WHERE email='$email';";
	mysqli_query($conn, $sqll);
}	

$resullt=mysqli_query($conn, "SELECT * FROM schedule WHERE group_name='$group'");
$roww=mysqli_fetch_array($resullt);
$begin=$roww['begin'];
$end=$roww['end'];
$today = date("Y-m-d H:i:s");  

if(($type=='N' or $type=='n') AND $today < $begin AND $today < $end){
	echo '<script language="javascript">';
	echo 'alert("You schedule is at a later time. Please check your profile.");';
	echo 'window.location = "view.php";';
	echo '</script>';
	exit();
}
elseif(($type=='N' or $type=='n') AND $today > $begin AND $today > $end ){
	echo '<script language="javascript">';
	echo 'alert("You schedule has passed. Please ask your teacher for a new schedule.");';
	echo 'window.location = "view.php";';
	echo '</script>';
	exit();
}	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Control Mode</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../nipplejs-master/dist/nipplejs.js" charset="utf-8"></script>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
</head>
	
<body>
	
<?php 
	//$sock = socket_create(AF_INET, SOCK_DGRAM, 0);
	//$local='127.0.0.1';
	//$port=9999;
	//socket_bind($sock, $local) or die('Could not bind to address');
	//socket_connect($sock, '127.0.0.1', 9999);
	//while(1) {
	//	echo socket_read($sock,9999);
	//}
	//socket_close($sock);

	
?>

	

<div class="container-fluid">
	<div class="row"></div>
		<div class="col-sm-4">
			<button onclick="p1f()" class="btn btn-primary">Place 1</button>
			<br>
			<br>
			<button onclick="p2f()" class="btn btn-primary">Place 2</button>
			<br>
			<br>
			<button onclick="p3f()" class="btn btn-primary">Place 3</button>
			<br>
			<br>

		</div>
		
<script language="javascript">
	function p1f() {
      $.get("p1.php");
      return false;
	}
	
	function p2f() {
      $.get("p2.php");
      return false;
	}
	
	function p3f() {
      $.get("p3.php");
      return false;
	}		
</script>
	

		<div class="col-sm-8">
			<video width="900" height="600" src="http://192.168.105.71:8080/stream.ogg" autoplay="autoplay" controls ></video>
		</div>
	</div>
</div>

<?php 
	include('./footer.php');
?>
</body>
</html>



