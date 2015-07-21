<?php

$host_name = "db483958052.db.1and1.com";
$database = "db483958052";
$user_name = "dbo483958052";
$password = "database";

$conn = mysqli_connect($host_name, $user_name, $password, $database);
/*if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}*/

if($_POST["username"] == "test" && $_POST["password"] == "test"){
	echo "ok";
}else{
	echo "no";
}
