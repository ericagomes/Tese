<!DOCTYPE html>
<html lang="en">
  	<head>
		<title>Testes de coisas precisas</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="../nipplejs-master/dist/nipplejs.js" charset="utf-8"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
		<meta charset="utf-8">
		<style>
			html, body 
			{
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				padding: 0;
				margin: 0;
			}

			#left {
				position: absolute;
				left: 0%;
				top: 25%;
				height: 50%;
				width: 25%;
				background: rgba(255, 0, 255, 0.1);
			}
	
			#right {
				position: absolute;
				right: 0%;
				top: 25%;
				height: 50%;
				width: 25%;
				background: rgba(255, 255, 0, 0.1);
			}
			
			#middle {
				position: absolute;
				left: 25%;
				top:20%;
				height: 50%;
				width: 50%;
				background: rgba(255, 255, 255, 0.1);
			}
				
		</style>
	</head>
	
	<body>
	<div class="container-fluid">
	<div class="header"><?php include('./header.html');?></div>
	</div>
	
	<div>	
		<div id="left"> 
			<ul>
			<li class="position">
				position :
				<ul>
				<li class="x">x : <span class='data'></span></li>
				<li class="y">y : <span class='data'></span></li>
				</ul>
			</li>
			<li class="force">force : <span class='data'></span></li>
			<li class="pressure">pressure : <span class='data'></span></li>
			<li class="distance">distance : <span class='data'></span></li>
			<li class="angle">
				angle :
				<ul>
				<li class="radian">radian : <span class='data'></span></li>
				<li class="degree">degree : <span class='data'></span></li>
				</ul>
			</li>
			<li class="direction">
				direction :
				<ul>
				  <li class="x">x : <span class='data'></span></li>
				  <li class="y">y : <span class='data'></span></li>
				  <li class="angle">angle : <span class='data'></span></li>
				</ul>
			</li>
			</ul>	
		</div>
					
	<div id="right">
		<ul>
		<li class="position">
			position :
			<ul>
			<li class="x">x : <span class='data'></span></li>
			<li class="y">y : <span class='data'></span></li>
			</ul>
		</li>
		<li class="force">force : <span class='data'></span></li>
		<li class="pressure">pressure : <span class='data'></span></li>
		<li class="distance">distance : <span class='data'></span></li>
		<li class="angle">
			angle :
			<ul>
			<li class="radian">radian : <span class='data'></span></li>
			<li class="degree">degree : <span class='data'></span></li>
			</ul>
		</li>
		<li class="direction">
			direction :
			<ul>
			<li class="x">x : <span class='data'></span></li>
			<li class="y">y : <span class='data'></span></li>
			<li class="angle">angle : <span class='data'></span></li>
			</ul>
		</li>
		</ul>	
	</div>
	
	
	<div id="middle">

		<video width="900" height="600" src="http://192.168.105.71:8080/stream.ogg" autoplay="autoplay" controls ></video>
    </div>
    </div> 
			
			
		
		 <script>
		var s = function(sel) {
		  return document.querySelector(sel);
		};
		var sId = function(sel) {
		  return document.getElementById(sel);
		};
		
		 var joystickL = nipplejs.create({
				zone: document.getElementById('left'),
				mode: 'static',
				position: { left: '50%', top: '70%' },
				color: 'green',
				size: 100
			});
		bindNippleL();
		
			var joystickR = nipplejs.create({
				zone: document.getElementById('right'),
				mode: 'static',
				position: { left: '50%', top: '70%' },
				color: 'red',
				size: 100
			});
		bindNippleR();
			
		   
				// Get debug elements and map them
			var elDebugL = sId('left');
			var elDumpL = elDebugL.querySelector('.dump');
			var elsl = {
			  position: {
				x: elDebugL.querySelector('.position .x .data'),
				y: elDebugL.querySelector('.position .y .data')
			  },
			  force: elDebugL.querySelector('.force .data'),
			  pressure: elDebugL.querySelector('.pressure .data'),
			  distance: elDebugL.querySelector('.distance .data'),
			  angle: {
				radian: elDebugL.querySelector('.angle .radian .data'),
				degree: elDebugL.querySelector('.angle .degree .data')
			  },
			  direction: {
				x: elDebugL.querySelector('.direction .x .data'),
				y: elDebugL.querySelector('.direction .y .data'),
				angle: elDebugL.querySelector('.direction .angle .data')
			  }
			};
			
			var elDebugR = sId('right');
			var elDumpR = elDebugR.querySelector('.dump');
			var elsr = {
			  position: {
				x: elDebugR.querySelector('.position .x .data'),
				y: elDebugR.querySelector('.position .y .data')
			  },
			  force: elDebugR.querySelector('.force .data'),
			  pressure: elDebugR.querySelector('.pressure .data'),
			  distance: elDebugR.querySelector('.distance .data'),
			  angle: {
				radian: elDebugR.querySelector('.angle .radian .data'),
				degree: elDebugR.querySelector('.angle .degree .data')
			  },
			  direction: {
				x: elDebugR.querySelector('.direction .x .data'),
				y: elDebugR.querySelector('.direction .y .data'),
				angle: elDebugR.querySelector('.direction .angle .data')
			  }
			};
	
			function bindNippleL () {
				joystickL.on('start end', function (evt, data) {
					dumpL(evt.type);
					debugL(data);
				}).on('move', function (evt, data) {
					debugL(data);
				}).on('dir:up plain:up dir:left plain:left dir:down ' +
					'plain:down dir:right plain:right',
					function (evt, data) {
						dumpL(evt.type);
					}
				).on('pressure', function (evt, data) {
					debugL({pressure: data});
				});
			}
	
			function bindNippleR () {
			joystickR.on('start end', function (evt, data) {
				dumpR(evt.type);
				debugR(data);
			}).on('move', function (evt, data) {
				debugR(data);
			}).on('dir:up plain:up dir:left plain:left dir:down ' +
				'plain:down dir:right plain:right',
				function (evt, data) {
					dumpL(evt.type);
				}
			).on('pressure', function (evt, data) {
				debugR({pressure: data});
			});
		}
	
	
			function debugL (obj) {
					function parseObj(sub, el) {
						for (var i in sub) {
							if (typeof sub[i] === 'object' && el) {
								parseObj(sub[i], el[i]);
							} else if (el && el[i]) {
								el[i].innerHTML = sub[i];
							}
						}
					}
					setTimeout(function () {
						parseObj(obj, elsl);
					}, 0);
			
				}
		function debugR (obj) {					
			function parseObj(sub, el) {
					for (var i in sub) {
						if (typeof sub[i] === 'object' && el) {
							parseObj(sub[i], el[i]);
						} else if (el && el[i]) {
							el[i].innerHTML = sub[i];
						}
					}
				}
				setTimeout(function () {
					parseObj(obj, elsr);
				}, 0);
			}
		  function dumpL (evt) {
			  if(elDumpL!=null)
			  {
					setTimeout(function () {
					if (elDumpL.children.length > 4) {
						elDumpL.removeChild(elDump.firstChild);
					}
					var newEvent = document.createElement('div');
					newEvent.innerHTML = '#' + nbEvents + ' : <span class="data">' +
						evt + '</span>';
					elDumpL.appendChild(newEvent);
					nbEvents += 1;
				}, 0);
			}
		}
		 function dumpR (evt) {
			 if(elDumpR!=null)
			  {
			setTimeout(function () {
				if (elDumpR.children.length > 4) {
					elDumpR.removeChild(elDump.firstChild);
				}
				var newEvent = document.createElement('div');
				newEvent.innerHTML = '#' + nbEvents + ' : <span class="data">' +
					evt + '</span>';
				elDumpR.appendChild(newEvent);
				nbEvents += 1;
			}, 0);
			}
	}
		</script>
		
			<br/>
			
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
			
		<div>

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
			
			</body>
			
			</html>
			
			
		
