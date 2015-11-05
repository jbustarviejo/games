<?php
/******************************************
/* Registro de devolución de artículo
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");
//Funciones auxiliares
include("functions.php");

//Obtener puntos actuales
$user_points = getUserPoints($conn, $_POST["userId"], $_POST["userToken"]);

//Comprobar si se puede devolver
if($_POST["itemId"]!="5" AND $_POST["itemId"]!="3"){
	die(json_encode(array("ok" => false, "msg" => "Oferta no retornable")));
}

//Obtener variación de puntos
$points_variation = -getItemCost("buy-".$_POST["itemId"]);

//Calcular variación de puntos
$points_result = $user_points + $points_variation;

//Registrar la devolución del artículo en la tabla de la tienda
returnItemInShop($conn, $_POST["userId"], $_POST["itemId"]);

//Registrar la variación de los puntos
registerInHistory($conn, $_POST["userId"], "Devolución de Artículo", $points_variation, $points_result);

die(json_encode(array("ok" => true)));