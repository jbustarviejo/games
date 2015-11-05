<?php
/******************************************
/* Comprar item en la tienda y regisrarlo en la base de datos
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");
//Funciones auxiliares
include("functions.php");

//Obtener coste de puntos
$points_cost=getItemCost($_POST["itemId"]);

//Obtener puntos actuales
$user_points = getUserPoints($conn, $_POST["userId"], $_POST["userToken"]);

//Puntos finales
$points_result=$user_points+$points_cost;

if($points_result<0){
	die(json_encode(array("ok" => false, "msg" => "No tienes suficientes puntos", "notEnoughtPoints" => true)));
}

//Registrar la compra
registerInShoppingHistory($conn, $_POST["userId"], $_POST["time"], $_POST["itemId"], $points_cost, $points_result);