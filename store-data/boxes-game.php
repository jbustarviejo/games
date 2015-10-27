<?php

//Conectarse a BD
include("db_connection.php");

//Comprobar la conexión
$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

//Registrar el resultado del juego
registerInBoxesGameRecords($conn);

//Obtener puntos actuales
$user_points=getUserPoints($conn);

//Actualizar los puntos si se ha ganado
if( $_POST["winner_box"] == $_POST["last_box_selected"] ){
	if($_POST["boxes_number"] == 3){
		$points_variation = 9;
		$points_result=$user_points + $points_variation;
		//Registrar la variación de los puntos
		registerInHistory($conn, $points_variation, $points_result);
		die(json_encode(array("ok" => true, "points"=>$points_result)));
	}else if($_POST["boxes_number"]  == 4){
		$points_variation= 8;
		$points_result=$user_points  + $points_variation;
		//Registrar la variación de los puntos
		registerInHistory($conn, $points_variation, $points_result);
		die(json_encode(array("ok" => true, "points"=>$points_result)));
	}
}else{
	//Registrar la no variación de los puntos
	registerInHistory($conn, 0, $user_points);
	//Todo sigue igual
	die(json_encode(array("ok" => true)));
}

/**
* Función registerInBoxesGameRecords: Registrar lo ocurrido en el juego
* @param $conn | Conexión a BD
* @returns NULL | No devuelve ningún valor
*/
function registerInBoxesGameRecords($conn){
	$sql = "INSERT INTO boxesGameRecords(`id_user`, `date`, `boxes_number`, `winner_box`, `first_box_choose`, `first_available_boxes_to_change`, `first_time_choosing`, `second_box_choose`, `second_available_boxes_to_change`, `second_time_choosing`, `third_box_choose`, `third_available_boxes_to_change`, `third_time_choosing`, `last_box_selected`) VALUES ('" . $_POST["userId"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["boxes_number"] . "', '" . $_POST["winner_box"] . "', '" . $_POST["first_box_choose"] . "', '" . $_POST["first_available_boxes_to_change"] . "', '" . $_POST["first_time_choosing"] . "', '" . $_POST["second_box_choose"] . "', '" . $_POST["second_available_boxes_to_change"] . "', '" . $_POST["second_time_choosing"]. "', " . $_POST["third_box_choose"] . ", " . ($_POST["third_available_boxes_to_change"]=="NULL" ? "NULL" : "'" . $_POST["third_available_boxes_to_change"].  "'")  . ", " . $_POST["third_time_choosing"]. ", " . $_POST["last_box_selected"]. ")";

	if ($conn->query($sql) === TRUE) {
		return;
	} else {
		$conn->close();
	    die(json_encode(array("ok" => false, "msg" => "1.1 Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql)));
	}
}

/**
* Función getUserPoints: Obtener puntos del jugador
* @param $conn | Conexión a BD
* @returns {int} | Devuelve los puntos
*/
function getUserPoints($conn){
	//Obtener datos del usuario por su id y su Token de seguridad
	$sql="SELECT points, id_user, security_token FROM users u WHERE id_user='".$_POST["userId"]."' AND security_token='".$_POST["userToken"]."' LIMIT 1";
	$result = $conn->query($sql);

	//Comprobar usuario
	if ($result->num_rows > 0) {
	    //Datos encontrados
	    $row = $result->fetch_assoc();
	    //Si el usuario es correcto...
	    if($_POST["userId"]===$row["id_user"] && $_POST["userToken"]===$row["security_token"]){
	        //Usuario correcto
	        return $row["points"];
	    }else{
	        //Error
	        $conn->close();
	        die(json_encode(array("ok" => false, "msg" => "2.1 Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql)));
	    }
	} else {
	    //No encontrado
	    $conn->close();
	    die(json_encode(array("ok" => false, "msg" => "2.2 Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql)));
	}
}

/**
* Función registerInStrawsGameRecords: Registrar la  variación de puntos
* @param $conn | Conexión a BD
* @param $points_variation {int} | Variación de puntos
* @param $points_result {int} | Resultado final de puntos
* @returns NULL | No devuelve ningún valor
*/
function registerInHistory($conn, $points_variation, $points_result){
	$sql = "INSERT INTO gamesHistory(`id_user`, `date`, `game`, `time_to_choose`, `points_variation`, `points_result`) VALUES ('" . $_POST["userId"] . "', '" . date('Y-m-d H:i:s') . "', 'cardsGame', NULL, '" . $points_variation . "', '" . $points_result .  "')";

	if ($conn->query($sql) === TRUE) {
		//Actualizar el marcador de usuario
	    $newSql="UPDATE users SET points = '".$points_result."' WHERE id_user = '".$_POST["userId"]."'";
		if ($conn->query($newSql) === TRUE) {
			return;
		} else {
			//Error
		    $conn->close();
		    die(json_encode(array("ok" => false, "msg" => "3.1 Error: " . $newSql . "<br>" . $conn->error . ". The executed query was: " . $newSql)));
		}
	} else {
		//Error
	    $conn->close();
	    die(json_encode(array("ok" => false, "msg" => "3.2 Error: " . $sql . "<br>" . $conn->error . ". The executed query was: " . $sql)));
	}
}

