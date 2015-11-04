<?php
/******************************************
/* Juego de las cajas. Registro de resultados en la base de datos
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");
//Funciones auxiliares
include("functions.php");

//Registrar el resultado del juego
registerInBoxesGameRecords($conn, $_POST["userId"]);

//Obtener puntos actuales
$user_points = getUserPoints($conn, $_POST["userId"], $_POST["userToken"]);

//Actualizar los puntos si se ha ganado
if($_POST["winner_box"] == $_POST["last_box_selected"]){
	//Obtener premio
	$points_variation = getPointsPrize("boxesGame", $_POST["boxesNumber"]);
	//Calcular resultante
	$points_result = $user_points + $points_variation;
	//Registrar la variación de los puntos
	registerInHistory($conn, $_POST["userId"], "boxesGame", $points_variation, $points_result);
	//Imprimir resultado
	die(json_encode(array("ok" => true, "points"=>$points_result)));
}else{
	//Registrar la no variación de los puntos
	registerInHistory($conn, $_POST["userId"], "boxesGame", 0, $user_points);
	//Imprimir resultado
	die(json_encode(array("ok" => true)));
}