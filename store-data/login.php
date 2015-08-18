<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

$sql="SELECT * FROM users WHERE id_user='".$_POST["username"]."' AND pass='".$_POST["password"]."' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //Datos encontrados
    while($row = $result->fetch_assoc()) {
    	if($_POST["username"]===$row["id_user"] && $_POST["password"]===$row["pass"]){
    		$conn->close();
    		die("ok");
    	}
    }
} else {
	$conn->close();
    die("no");
}