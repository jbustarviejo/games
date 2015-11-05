<?php
/******************************************
/* Juego de las cartas. Registro de resultados en la base de datos
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");
//Funciones auxiliares
include("functions.php");

//Registrar el resultado del juego
registerInCardsGameRecords($conn, $_POST["userId"]);

//Obtener puntos actuales
$user_points = getUserPoints($conn, $_POST["userId"], $_POST["userToken"]);

//Actualizar los puntos si se ha ganado
if($_POST["selected_side"] == $_POST["winner_side"]){
	//Obtener premio
	$points_variation = getPointsPrize("cardsGame", $_POST["cardsNumber"]);
	//Calcular resultante
	$points_result = $user_points + $points_variation;
	//Registrar la variación de los puntos
	registerInHistory($conn, $_POST["userId"], "NULL", "cardsGame", $points_variation, $points_result);
	//Imprimir resultado
	die(json_encode(array("ok" => true, "points"=>$points_result)));
}else{
	//Registrar la no variación de los puntos
	registerInHistory($conn, $_POST["userId"], "NULL", "cardsGame", 0, $user_points);
	//Imprimir resultado
	die(json_encode(array("ok" => true)));
}