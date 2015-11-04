<?php
/******************************************
/* Registro de nueva meta
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");

//Guardar respuesta en BD
$sql = "INSERT INTO user_goal (`id_user`, `id_goal`, `date`) VALUES ('" . $_POST["userId"] . "', '" . $_POST["answer"] . "', '" . date('Y-m-d H:i:s') . "')";

if ($conn->query($sql) === TRUE) {
	echo json_encode(array("ok" => true));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();