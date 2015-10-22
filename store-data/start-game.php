<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

//Guardar tiempo en elegir juego
$sql = "INSERT INTO timeToChooseGame (`id_user`, `date`, `time`, `game`) VALUES ('" . $_POST["userId"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["time"] . "', '" . $_POST["game"] . "')";

if ($conn->query($sql) !== TRUE) {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
    die();
}

//Tabla de costes
switch ($_POST["game"]) {
	case 'strawsGame':
		if($_POST["number"]=="3"){
			$cost_points=1;
		}else if($_POST["number"]=="4"){
			$cost_points=1;
		}else{
			echo json_encode(array("ok" => false, "msg" => "Error: Juego no encontrado")); die();
		}
		break;
	case 'cardsGame':
		if($_POST["number"]=="3"){
			$cost_points=5;
		}else if($_POST["number"]=="4"){
			$cost_points=2;
		}else{
			echo json_encode(array("ok" => false, "msg" => "Error: Juego no encontrado")); die();
		}
		break;
	case 'boxesGame':
		if($_POST["number"]=="3"){
			$cost_points=3;
		}else if($_POST["number"]=="4"){
			$cost_points=2;
		}else{
			echo json_encode(array("ok" => false, "msg" => "Error: Juego no encontrado")); die();
		}
		break;
	default:
		echo json_encode(array("ok" => false, "msg" => "Error: Juego no encontrado")); die();
		break;
}

//Buscar puntuación actual del usuario
$sql="SELECT u.points, u.id_user as id_user FROM users u LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //Datos encontrados
    while($row = $result->fetch_assoc()) {
    	if($_POST["userId"]===$row["id_user"]){
    		//Puntos actuales
    		$userPoints=($row["points"]-$cost_points);
    		//Almacenar histórico de transacción
    		$sql = "INSERT INTO gamesHistory(`id_user`, `date`, `game`, `points_variation`, `points_result`) VALUES ('" . $_POST["id_user"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["game"] . "', " . $cost_points . ", ". $userPoints .")";
    		//Actualizar puntos en BBDD
    		$newSql="UPDATE users SET points = points + ".$userPoints." WHERE id_user = '".$_POST["userId"]."'";
			$conn->query($newSql);
			if ($conn->query($sql) !== TRUE) {
				echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
				$conn->close();
				die();
			}else{
		    	echo json_encode(array("ok" => true, "points" => $userPoints));
				$conn->close();
				die();
			}
    	}else{
            $conn->close();
            echo json_encode(array("ok" => false));
            die();
        }
    }
} else {
	$conn->close();
    echo json_encode(array("ok" => false));
    die();
}


