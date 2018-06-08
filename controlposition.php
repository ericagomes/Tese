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
	
// Check if user is logged in using the session variable
if($_SESSION['loggedin'] == 0) {
	echo '<script language="javascript">';
	echo 'alert("Please login to enter this page.");';
	echo 'window.location = "login.php";';
	echo '</script>';
	exit();  
}
	date_default_timezone_set('Europe/London');
	$today = date("Y-m-d H:i:s");  
	$del= mysqli_query($conn, "DELETE FROM schedule WHERE (end<'$today')");
	mysqli_query($conn, $del);
	$resultt = mysqli_query($conn, "SELECT * FROM users WHERE loggedin=2");
	$other=mysqli_num_rows($resultt);

	$type= $_SESSION['u_type'];
	$resullt=mysqli_query($conn, "SELECT * FROM schedule WHERE group_name='$group'");
	$roww=mysqli_fetch_array($resullt);
	$begin=$roww['begin'];
	$end=$roww['end'];

if(($type=='N' or $type=='n') AND $today > $begin AND $today > $end){
	echo '<script language="javascript">';
	echo 'alert("You schedule is at a later time. Please check your profile.");';
	echo 'window.location = "view.php";';
	echo '</script>';
	exit();
}
if(($type=='N' or $type=='n') AND $today < $begin AND $today < $end ){
	echo '<script language="javascript">';
	echo 'alert("You schedule has passed. Please ask your teacher for a new schedule.");';
	echo 'window.location = "view.php";';
	echo '</script>';
	exit();
}

if($_SESSION['loggedin'] == 1 AND $other>0) {
	echo '<script language="javascript">';
	echo 'getConfirmation();';
	echo '</script>';
	exit(); 
}
if (($_SESSION['loggedin'] == 1 AND $other==0)) {
	 // Makes it easier to read
    $first_name = $_SESSION['u_first'];
	$last_name = $_SESSION['u_last'];
	$email = $_SESSION['u_email'];
	$group= $_SESSION['u_group'];
	$sqll="UPDATE users SET loggedin=2 WHERE email='$email';";
	mysqli_query($conn, $sqll);
	$rz = mysqli_query($conn, "SELECT zone FROM schedule WHERE group_name='$group'");
	$roww=mysqli_fetch_assoc($rz);
	$zone=$roww['zone'];
}	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Control Mode</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
</head>
	
<body>
	
<div class="container-fluid">
	<div class="row"></div>
		<div class="col-sm-4">
			
			<?php
			if($zone==1)
			{
			?>
			<button onclick="p1f()" class="btn btn-primary">Place 1 Z1</button>
			<br>
			<br>
			<button onclick="p2f()" class="btn btn-primary">Place 2 Z1</button>
			<br>
			<br>
			<button onclick="p3f()" class="btn btn-primary">Place 3 Z1</button>
			<br>
			<br>
			<?php
			}
			if($zone==2)
			{
			?>
			<button onclick="p1f()" class="btn btn-primary">Place 1 Z2</button>
			<br>
			<br>
			<button onclick="p2f()" class="btn btn-primary">Place 2 Z2</button>
			<br>
			<br>
			<button onclick="p3f()" class="btn btn-primary">Place 3 Z2</button>
			<br>
			<br>
			<?php
			}
			if($zone==NULL)
			{
			?>
			<button onclick="p1f()" class="btn btn-primary">Place 1 Z1</button>
			<br>
			<br>
			<button onclick="p2f()" class="btn btn-primary">Place 2 Z1</button>
			<br>
			<br>
			<button onclick="p3f()" class="btn btn-primary">Place 3 Z1</button>
			<br>
			<br><button onclick="p1f()" class="btn btn-primary">Place 1 Z2</button>
			<br>
			<br>
			<button onclick="p2f()" class="btn btn-primary">Place 2 Z2</button>
			<br>
			<br>
			<button onclick="p3f()" class="btn btn-primary">Place 3 Z2</button>
			<br>
			<br>
			<?php
			} ?>
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

	var auto_refresh = setInterval(
	function ()
	{
	$('#haspass').load('haspass.php').fadeIn("slow");
	}, 60000); 
</script>
	
	<div id="haspass"></div>
	
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



