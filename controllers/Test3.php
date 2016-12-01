<?php
error_reporting(E_ALL);
//端口111
$service_port = 20000;
//本地
$address = 'localhost';
//创建 TCP/IP socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

$result = socket_connect($socket, $address, $service_port);
$out = '';
$in = "sun\n";
socket_write($socket, $in, strlen($in));
$out = socket_read($socket, 2048);
echo $out;

socket_close($socket);
?>