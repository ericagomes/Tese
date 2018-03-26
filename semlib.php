<html>
<head>
	<title> Testing Page </title>
</head>
<body>

<?php
echo "<p>Control Page</p>";
$port = fopen('/dev/ttyUSB0', 'w+');
if( $port == FALSE) {
        echo "Error";die();
}
sleep(2);
?>

<br>

<form action="semlib.php" method="POST">
<input type="hidden" name="cmd" value="R" />
<input type="Submit" value="Record" />
</form>


<form action="semlib.php" method="POST">
<input type="hidden" name="cmd" value="S" />
<input type="Submit" value="Stop" />
</form>

<form action="semlib.php" method="POST">
<input type="hidden" name="cmd" value="P" />
<input type="Submit" value="Play" />
</form>

<?php
	if ($_POST['cmd']=="R")
	{
		echo "Record";
		fwrite($port,"R");
		
		
	}

	if ($_POST['cmd']=="S")
	{
		echo "Stop";
		fwrite($port,"S");
		sleep(2);
		
	}

	if ($_POST['cmd']=="P")
	{
		echo "Play";
		fwrite($port,"P");
		sleep(2);
	
	}

	fclose($port);
	echo "Done";
?>

</body>
</html>
