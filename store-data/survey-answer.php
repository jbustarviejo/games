<?php
/******************************************
/* Registro de respuesta a encuesta
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");

//Guardar respuesta en BD
$sql = "INSERT INTO survey (`id_user`, `answer`, `text_answer`, `date`) VALUES ('" . $_POST["userId"] . "', '" . $_POST["answer"] . "', '" . addslashes($_POST["text_answer"]) . "', '" . date('Y-m-d H:i:s') . "')";

if ($conn->query($sql) === TRUE) {
	echo json_encode(array("ok" => true));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();