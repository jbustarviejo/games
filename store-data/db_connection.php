<?php

//Detectar configuración del servidor
if(php_uname('n')!="MacBook-de-jbustarviejogmailcom.local"){
	$host_name = "localhost";
	$database = "games";
	$user_name = "root";
	$password = "";
}else{
	$host_name = "localhost";
	$database = "test";
	$user_name = "pressclipit";
	$password = "pressclipit";
}

//Comprobar la conexión
$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
	die(json_encode(array("ok" => false, "msg" => "0.1 Error al conectar con servidor MySQL: " . mysqli_connect_error())));
}