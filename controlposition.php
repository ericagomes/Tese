<!DOCTYPE html>
<html lang="en">
<head>
	<title>Testes de coisas precisas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../nipplejs-master/dist/nipplejs.js" charset="utf-8"></script>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
</head>
	
<body>
	
	<?php 
		include('./header.html');
	?>

	<div class="text-right">
		<video width="900" height="600" src="http://192.168.105.71:8080/stream.ogg" autoplay="autoplay" controls ></video>
    </div>
 
<br>

<?php	
	require("php_serial.class.php");
	$comPort = "/dev/ttyUSB0"; //The com port address. This is a debian address
	$msg = '';

	if(isset($_POST["R"])){
		$serial = new phpSerial;
		$serial->deviceSet($comPort);
		exec("stty -F /dev/ttyUSB0 cs8 9600 -cstopb -hupcl brkint ignpar -icrnl -opost -onlcr -isig -icanon -echo");
		$serial->deviceOpen();
		sleep(2); // arduino requires a 2 second delay in order to receive the message
		$serial->sendMessage("R");
		$msg = $serial->readPort(1024);
		$serial->deviceClose();
	}

	if(isset($_POST["S"])){
		$serial = new phpSerial;
		$serial->deviceSet($comPort);
		exec("stty -F /dev/ttyUSB0 cs8 9600 -cstopb -hupcl brkint ignpar -icrnl -opost -onlcr -isig -icanon -echo");
		$serial->deviceOpen();
		sleep(2); // arduino requires a 2 second delay in order to receive the message
		$serial->sendMessage("S");
		$msg = $serial->readPort(1024);
		$serial->deviceClose();
	}

	if(isset($_POST["P"])){
		$serial = new phpSerial;
		$serial->deviceSet($comPort);
		exec("stty -F /dev/ttyUSB0 cs8 9600 -cstopb -hupcl brkint ignpar -icrnl -opost -onlcr -isig -icanon -echo");
		$serial->deviceOpen();
		sleep(2); // arduino requires a 2 second delay in order to receive the message
		$serial->sendMessage("P");
		$msg = $serial->readPort(1024);
		$serial->deviceClose();
	}
?>

	<div class="text-left">
		<form method="POST">
			<input type="submit" value="Record" name="R">
		</form><br>

		<form method="POST">
			<input type="submit" value="Stop" name="S">
		</form><br>

		<form method="POST">
			<input type="submit" value="Play" name="P">
		</form><br>
		<?=$msg?>
	</div>


<?php 
		include('./footer.php');
	?>
</body>
</html>



