<?php

//Conectarse a BD
include("db_connection.php");

//Comprobar la conexión
$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

//Obtener puntos actuales
$points = getUserPoints($conn);
//Calcular coste de participación
$points_variation = getPointsCost();
$points_result=$points+$points_variation;
//Registrar el tiempo del juego y los puntos
registerInHistory($conn, $points_variation, $points_result);
die(json_encode(array("ok" => true, "points"=>$points_result)));

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
	        die(json_encode(array("ok" => false, "msg" => "1.1 Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql)));
	    }
	} else {
	    //No encontrado
	    $conn->close();
	    die(json_encode(array("ok" => false, "msg" => "1.2 Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql)));
	}
}

/**
* Función getPointsCost: Obtener coste de puntos por la participación
* @returns {int} | Devuelve los puntos del coste
*/
function getPointsCost(){
	switch ($_POST["game"]) {
		case 'strawsGame':
			if($_POST["itemsNumber"]==4 || $_POST["itemsNumber"]==3){
				return -1;
			}
			die(json_encode(array("ok" => false, "msg" => "2.1 Error: No se encuentra este juego (Pajitas) para estos items")));
		break;
		case 'cardsGame':
			if($_POST["itemsNumber"]==4){
				return -2;
			}else if($_POST["itemsNumber"]==3){
				return -3;
			}
			die(json_encode(array("ok" => false, "msg" => "2.2 Error: No se encuentra este juego (Cartas) para estos items")));
		break;
		case 'boxesGame':
			if($_POST["itemsNumber"]==4){
				return -2;
			}else if($_POST["itemsNumber"]==3){
				return -5;
			}
			die(json_encode(array("ok" => false, "msg" => "2.3 Error: No se encuentra este juego (Cajas) para estos items")));
		break;
		default:
			die(json_encode(array("ok" => false, "msg" => "2.4 Error: No se encuentra este juego")));
		break;
	}
}

/**
* Función registerInHistory: Registrar la  variación de puntos
* @param $conn | Conexión a BD
* @param $points_variation {int} | Variación de puntos
* @param $points_result {int} | Resultado final de puntos
* @returns NULL | No devuelve ningún valor
*/
function registerInHistory($conn, $points_variation, $points_result){
	$sql = "INSERT INTO gamesHistory(`id_user`, `date`, `game`, `time_to_choose`, `points_variation`, `points_result`) VALUES ('" . $_POST["userId"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["game"] . "', '" . $_POST["time"] . "', '" . $points_variation . "', '" . $points_result .  "')";

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

