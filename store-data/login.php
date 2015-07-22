<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
/*if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}*/

if($_POST["username"] == "test" && $_POST["password"] == "test"){
	echo "ok";
}else{
	echo "no";
}
