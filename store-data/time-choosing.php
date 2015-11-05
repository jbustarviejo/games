<?php
/******************************************
/* Registro de tiempos en Base de datos. Calcular coste de paricipación en el juego
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");
//Funciones auxiliares
include("functions.php");

//Obtener puntos actuales
$points = getUserPoints($conn, $_POST["userId"], $_POST["userToken"]);
//Calcular coste de participación
$points_variation = getPointsCost($_POST["game"], $_POST["itemsNumber"]);
//Si no tiene suficiente puntos, cancelar
if($points < -$points_variation){
	die(json_encode(array("ok" => false, "notEnoughtPoints"=>true)));
}
$points_result=$points+$points_variation;
//Registrar el tiempo del juego y los puntos
registerInHistory($conn, $_POST["userId"],  $_POST["time"], $_POST["game"], $points_variation, $points_result);
//Imprimir resultado
die(json_encode(array("ok" => true, "points"=>$points_result)));