<?php

//Conectarse a BD
include("db_connection.php");

//Comprobar la conexión
$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

//Obtener coste de puntos
$points_cost=getPointsCost();

//Obtener puntos actuales
$user_points=getUserPoints($conn);

//Puntos finales
$points_result=$user_points+$points_cost;

if($points_result<0){
	die(json_encode(array("ok" => false, "msg" => "No tienes suficientes puntos", "notEnoughtPoints" => true)));
}

//Registrar la compra
registerInShoppingHistory($conn, $points_cost, $points_result);


/**
* Función getPointsCost: Registrar lo ocurrido en el juego
* @param $conn | Conexión a BD
* @returns {int} | Devuelve el coste de la oferta
*/
function getPointsCost(){
	switch ($_POST["itemId"]) {
		case 'buy-1':
		case 'buy-2':
			return -30;
		case 'buy-3':
		case 'buy-4':
			return -35;
		case 'buy-5':
		case 'buy-6':
			return -40;
		default:
			die(json_encode(array("ok" => false, "msg" => "Oferta no encontrada")));
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
* Función registerInShoppingHistory: Registrar la variación de puntos por la compra
* @param $conn | Conexión a BD
* @param $points_variation {int} | Variación de puntos
* @param $points_result {int} | Resultado final de puntos
* @returns NULL | No devuelve ningún valor
*/
function registerInShoppingHistory($conn, $points_variation, $points_result){
	$sql = "INSERT INTO shoppingHistory(`id_user`, `date`, `item_id`, `points_variation`, `points_result`) VALUES ('" . $_POST["userId"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["itemId"] ."','". $points_variation . "', '" . $points_result .  "')";

	if ($conn->query($sql) === TRUE) {
		//Actualizar el marcador de usuario
	    $newSql="UPDATE users SET points = '".$points_result."' WHERE id_user = '".$_POST["userId"]."'";
		if ($conn->query($newSql) === TRUE) {
			die(json_encode(array("ok" => true, "points"=>$points_result)));
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