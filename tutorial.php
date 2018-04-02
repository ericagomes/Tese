
<?php

require("php_serial.class.php");

$comPort = "/dev/ttyUSB0"; //The com port address. This is a debian address

$msg = '';

$serial = new phpSerial;
 
if(isset($_POST["O"])){

$serial = new phpSerial;

$serial->deviceSet($comPort);

exec("stty -F /dev/ttyUSB0 cs8 9600 -cstopb -hupcl brkint ignpar -icrnl -opost -onlcr -isig -icanon -echo");

$serial->deviceOpen();


sleep(8); //Unfortunately this is nessesary, arduino requires a 2 second delay in order to receive the message


$msg = $serial->readPort(1024);

$serial->deviceClose();

//$msg = "You message has been sent! WOHOO!";

}

if(isset($_POST["R"])){

$serial = new phpSerial;

$serial->deviceSet($comPort);

exec("stty -F /dev/ttyUSB0 cs8 9600 -cstopb -hupcl brkint ignpar -icrnl -opost -onlcr -isig -icanon -echo");

$serial->deviceOpen();


sleep(2); //Unfortunately this is nessesary, arduino requires a 2 second delay in order to receive the message

$serial->sendMessage("R");

$msg = $serial->readPort(1024);

$serial->deviceClose();

//$msg = "You message has been sent! WOHOO!";

}

if(isset($_POST["S"])){

$serial = new phpSerial;

$serial->deviceSet($comPort);

exec("stty -F /dev/ttyUSB0 cs8 9600 -cstopb -hupcl brkint ignpar -icrnl -opost -onlcr -isig -icanon -echo");

$serial->deviceOpen();

sleep(2); //Unfortunately this is nessesary, arduino requires a 2 second delay in order to receive the message

$serial->sendMessage("S");

$msg = $serial->readPort(1024);

$serial->deviceClose();

//$msg = "You message has been sent! WOHOO!";

}

if(isset($_POST["P"])){

$serial = new phpSerial;

$serial->deviceSet($comPort);

exec("stty -F /dev/ttyUSB0 cs8 9600 -cstopb -hupcl brkint ignpar -icrnl -opost -onlcr -isig -icanon -echo");

$serial->deviceOpen();

sleep(2); //Unfortunately this is nessesary, arduino requires a 2 second delay in order to receive the message

$serial->sendMessage("P");

$msg = $serial->readPort(1024);

$serial->deviceClose();

//$msg = "You message has been sent! WOHOO!";

}
?>

<html>

<head>

<title>Arduino control</title>

</head>

<body>

<form method="POST">

<input type="submit" value="Load Info" name="L">

</form><br>


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

</body>

</html>
