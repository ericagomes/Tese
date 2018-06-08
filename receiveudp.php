<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
if (!$socket) { die("socket_create failed.\n"); }

//Set socket options.
socket_set_nonblock($socket);
socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, 1);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
if (defined('SO_REUSEPORT'))
    socket_set_option($socket, SOL_SOCKET, SO_REUSEPORT, 1);

//Bind to any address & port xxxxx
if(!socket_bind($socket, '127.0.0.1', 9999))
    die("socket_bind failed.\n");

//Wait for data.
$read = array($socket); $write = NULL; $except = NULL;
while(socket_select($read, $write, $except, NULL)) {

    //Read received packets with a maximum size of 5120 bytes.
    while(is_string($data = socket_read($socket, 5120))) {
        echo $data;
        break;
    }
	break;
}
?>
