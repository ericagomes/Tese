<?php
$server_ip   = '127.0.0.1';
$server_port = 8886;
$message = '9';
$server_port1 = 8888;
$message1 = '9';
print "Sending heartbeat to IP $server_ip, port $server_portn";
echo "Sending heartbeat to IP $server_ip, port $server_portn";
if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
    socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
    socket_sendto($socket, $message1, strlen($message), 0, $server_ip, $server_port1);
} else {
  print("can't create socketn");
}

?>
 
