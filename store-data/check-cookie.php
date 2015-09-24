<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

$sql="SELECT points, answer, u.id_user as id_user FROM users u LEFT JOIN survey s on u.id_user = s.id_user WHERE u.id_user='".$_POST["userId"]."' ORDER BY s.date DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //Datos encontrados
    while($row = $result->fetch_assoc()) {
    	if($_POST["userId"]===$row["id_user"]){
    		$conn->close();
    		echo json_encode(array("ok" => true, "points"=>$row["points"], "survey"=>$row["answer"]));
    	}else{
            $conn->close();
            echo json_encode(array("ok" => false));
        }
    }
} else {
	$conn->close();
    echo json_encode(array("ok" => false));
}