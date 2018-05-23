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
