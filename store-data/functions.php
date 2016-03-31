<?php
/******************************************
/* Funciones utilizadas por los scripts PHP
******************************************/

/******************************************
* Funciones para los puntos
******************************************/

/**
* Función getUserPoints: Obtener puntos del jugador
* @param $conn | Conexión activa a BD
* @returns {int} | Devuelve los puntos
*/
function getUserPoints($conn, $userId, $userToken){
	//Obtener datos del usuario por su id y su Token de seguridad
	$sql="SELECT points, id_user, security_token FROM users u WHERE id_user='".$userId."' AND security_token='".$userToken."' LIMIT 1";
	$result = $conn->query($sql);

	//Comprobar usuario
	if ($result->num_rows > 0) {
	    //Datos encontrados
	    $row = $result->fetch_assoc();
	    //Si el usuario es correcto...
	    if($userId===$row["id_user"] && $userToken===$row["security_token"]){
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
	    die(json_encode(array("ok" => false, "msg" => "1.2 Error: " . $conn->error . ". The executed query was" . $sql)));
	}
}


/**
* Función registerInHistory: Registrar una variación de puntos
* @param $conn | Conexión activa a BD
* @param $userId {string}| Id de usuario
* @param $concept {string}| Concepto de la variación
* @param $points_variation {int} | Variación de puntos
* @param $points_result {int} | Resultado final de puntos
* @returns NULL | No devuelve ningún valor
*/
function registerInHistory($conn, $userId, $time_to_choose, $concept, $points_variation, $points_result){
	$sql = "INSERT INTO gamesHistory(`id_user`, `date`, `game`, `time_to_choose`, `points_variation`, `points_result`) VALUES ('" . $userId . "', '" . date('Y-m-d H:i:s') . "', '".$concept."', " . $time_to_choose . ", '" . $points_variation . "', '" . $points_result .  "')";

	if ($conn->query($sql) === TRUE) {
		//Actualizar el marcador de usuario
	    $newSql="UPDATE users SET points = '".$points_result."' WHERE id_user = '".$userId."'";
		if ($conn->query($newSql) === TRUE) {
			return;
		} else {
			//Error
		    $conn->close();
		    die(json_encode(array("ok" => false, "msg" => "2.1 Error: " . $newSql . "<br>" . $conn->error . ". The executed query was: " . $newSql)));
		}
	} else {
		//Error
	    $conn->close();
	    die(json_encode(array("ok" => false, "msg" => "2.2 Error: " . $conn->error . ". The executed query was: " . $sql)));
	}
}


/**
* Función registerInShoppingHistory: Registrar la variación de puntos por la compra
* @param $conn | Conexión a BD
* @param $userId {string} | Id de usuario
* @param $time_to_choose {int} | Tiempo tomado hasta decisión final
* @param $itemId {string}| Id de item
* @param $points_variation {int} | Variación de puntos
* @param $points_result {int} | Resultado final de puntos
* @returns NULL | No devuelve ningún valor
*/
function registerInShoppingHistory($conn, $userId, $time_to_choose, $itemId, $points_variation, $points_result){
	$sql = "INSERT INTO shoppingHistory(`id_user`, `date`, `time_to_choose`, `item_id`, `points_variation`, `points_result`) VALUES ('" . $userId . "', '" . date('Y-m-d H:i:s') . "', " .$time_to_choose .",'". $itemId ."','". $points_variation . "', '" . $points_result .  "')";

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
	    die(json_encode(array("ok" => false, "msg" => "3.2 Error: " . $conn->error . ". The executed query was: " . $sql)));
	}
}

/**
* Función returnItemShop: Devolver datos del item adquirido en la tienda por un usuario
* @param $conn | Conexión a BD
* @param $userId {string} | Id de usuario
* @param $itemId {string}| Id de item
* @returns NULL | No devuelve ningún valor
*/
function returnItemInShop($conn, $userId, $itemId){
	//Marcar item más antiguo posible como devuelto
	$sql = "UPDATE shoppingHistory SET return_date = '" . date('Y-m-d H:i:s') . "' WHERE item_id='buy-" . $itemId . "' AND id_user='" . $userId . "' AND date > (NOW() - INTERVAL 20 DAY) AND return_date IS NULL ORDER BY DATE ASC LIMIT 1";

	if ($conn->query($sql) === TRUE && mysqli_affected_rows($conn)>0) {
		return;
	} else {
		//Error
	    $conn->close();
	    die(json_encode(array("ok" => false, "msg" => "4.1 Error: " . $conn->error . ". The executed query was: " . $sql)));
	}
}

/******************************************
* Funciones de ofertas
******************************************/

/**
* Función getPointsCost: Obtener coste de puntos por la participación
* @param $game {string} | Nombre del juego
* @param $itemsNumber {int} | Número de items
* @returns {int} | Devuelve los puntos del coste
*/
function getPointsCost($game, $itemsNumber, $die = true){
	switch ($game) {
		//Juegos de las cañas
		case 'strawsGame':
			if($itemsNumber == 4 || $itemsNumber == 3){
				return -1;
			}
			die(json_encode(array("ok" => false, "msg" => "5.1 Error: No se encuentra este juego (Pajitas) para estos items")));
		break;
		//Juego de las cartas
		case 'cardsGame':
			if($itemsNumber == 4){
				return -2;
			}else if($itemsNumber == 3){
				return -5;
			}
			die(json_encode(array("ok" => false, "msg" => "5.2 Error: No se encuentra este juego (Cartas) para estos items")));
		break;
		//Juego de las cajas
		case 'boxesGame':
			if($itemsNumber == 4){
				return -2;
			}else if($itemsNumber == 3){
				return -3;
			}
			die(json_encode(array("ok" => false, "msg" => "5.3 Error: No se encuentra este juego (Cajas) para estos items")));
		break;
		default:
			die(json_encode(array("ok" => false, "msg" => "5.4 Error: No se encuentra este juego")));
		break;
	}
}

/**
* Función getItemCost: Obtener coste de puntos por id de item
* @param $game {item} | Número de items
* @param $die {bool} | Si $die es true, al encontrar error, ejecuta un die();. Utilizado para Ajax
* @returns {int} | Devuelve el coste de la oferta
*/
function getItemCost($itemId, $die=true){
	switch ($itemId) {
		//Las dos primeras ofertas
		case 'buy-1':
		case 'buy-2':
			return -30;
		//Las dos siguientes ofertas
		case 'buy-3':
		case 'buy-4':
			return -35;
		//Las dos últimas ofertas
		case 'buy-5':
		case 'buy-6':
			return -40;
		default:
			if($die){
				die(json_encode(array("ok" => false, "msg" => "Oferta no encontrada")));
			}
	}
}

/**
* Función getPointsPrize: Obtener premio de puntos por ganar
* @returns {int} | Devuelve los puntos del coste
*/
function getPointsPrize($game, $itemsNumber){
	switch ($game) {
		//Juegos de las cañas
		case 'strawsGame':
			if($itemsNumber == 4){
				return 4;
			}else if($itemsNumber == 3){
				return 3;
			}
			die(json_encode(array("ok" => false, "msg" => "6.1 Error: No se encuentra este juego (Pajitas) para estos items")));
		break;
		//Juego de las cartas
		case 'cardsGame':
			if($itemsNumber == 4){
				return 4;
			}else if($itemsNumber == 3){
				return 10;
			}
			die(json_encode(array("ok" => false, "msg" => "6.2 Error: No se encuentra este juego (Cartas) para estos items")));
		break;
		//Juego de las cajas
		case 'boxesGame':
			if($itemsNumber == 4){
				return 8;
			}else if($itemsNumber == 3){
				return 9;
			}
			die(json_encode(array("ok" => false, "msg" => "6.3 Error: No se encuentra este juego (Cajas) para estos items")));
		break;
		default:
			die(json_encode(array("ok" => false, "msg" => "6.4 Error: No se encuentra este juego")));
		break;
	}
}

/**
* Función getGoalName: Obtener nombre de la oferta
* @param $itemId {int} | id del item
* @returns {int} | Devuelve el nombre de la oferta
*/
function getGoalName($itemId){
  switch ($itemId) {
    case 1:
      return "Línea Móvil: 30Mpts";
    case 2:
      return "Movinternet fijo: 30Mpts";
    case 3:
      return "MoviNubico y Movinternet: 35Mpts";
    case 4:
      return "Móvil y Movisure: 35Mpts";
    case 5:
      return "Movifusión 1: 40Mpts";
    case 6:
      return "Movifusión 2: 40Mpts";
    default:
      return null;
  }
}

/**
* Función getUserPurchases: Obtener productos comprados por el jugador
* @param $conn | Conexión activa a BD
* @returns {array} | Devuelve un array con los datos de los items comprados
*/
function getUserPurchases($conn, $userId){
	//Obtener datos del usuario por su id 
	$sql="SELECT item_id, id_user, COUNT(*) as how_many, (DATEDIFF(NOW(), max(date))<20) AND (item_id='buy-3' OR item_id='buy-5') as can_return FROM shoppingHistory WHERE id_user='".$userId."' AND return_date IS NULL GROUP BY item_id";
	$result = $conn->query($sql);

	//Compras de usuario
	$purchases=array();

	//Comprobar usuario
	if ($result->num_rows > 0) {
	    //Datos encontrados
	    while($row = $result->fetch_assoc()) {
		    //Si el usuario es correcto...
		    if($userId===$row["id_user"]){
		        //Usuario correcto, guardar compra adquirida al final del array
		        $purchases[] = array('itemId' => $row["item_id"], "howMany" => $row["how_many"], "canReturn" => $row["can_return"]);
		    }else{
		        //Error
		        return null;
		    }
		}
		return $purchases;
	} else {
	    //No hay nada comprado
	    return null;
	}
}

/******************************************
* Funciones para los juegos
******************************************/

/**
* Función registerInStrawsGameRecords: Registrar lo ocurrido en el juego de las cañas
* @param $conn | Conexión a BD
* @returns NULL | No devuelve ningún valor
*/
function registerInStrawsGameRecords($conn, $userId){
	$sql = "INSERT INTO strawsGameRecords (`id_user`, `date`, `time`, `selected`, `winner`, `straws_number`) VALUES ('" . $userId . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["time"] . "', '" . $_POST["selected"] . "', '" . $_POST["winner"] . "', '" . $_POST["strawsNumber"] . "')";

	if ($conn->query($sql) === TRUE) {
		return;
	} else {
		$conn->close();
	    die(json_encode(array("ok" => false, "msg" => "7.1 Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql)));
	}
}


/**
* Función registerInCardsGameRecords: Registrar lo ocurrido en el juego cd las cartas
* @param $conn | Conexión a BD
* @returns NULL | No devuelve ningún valor
*/
function registerIncardsGameRecords($conn, $userId){
	$sql = "INSERT INTO cardsGameRecords (`id_user`, `date`, `time_memory`, `time_decission`, `displayed_side`, `winner_side`, `selected_side`, `cards_number`, `cards_array`, `cards_clicks`) VALUES ('" . $userId . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["time_memory"] . "', '" . $_POST["time_decission"] . "', '" . $_POST["displayed_side"] . "', '" . $_POST["winner_side"] . "', '" . $_POST["selected_side"] . "', '" . $_POST["cardsNumber"] . "', '" . $_POST["cards_array"] . "', '" . $_POST["cards_clicks"] . "')";

	if ($conn->query($sql) === TRUE) {
		return;
	} else {
		$conn->close();
	    die(json_encode(array("ok" => false, "msg" => "8.1 Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql)));
	}
}


/**
* Función registerInBoxesGameRecords: Registrar lo ocurrido en el juego de las cajas
* @param $conn | Conexión a BD
* @returns NULL | No devuelve ningún valor
*/
function registerInBoxesGameRecords($conn, $userId){
	$sql = "INSERT INTO boxesGameRecords(`id_user`, `date`, `boxes_number`, `winner_box`, `first_box_choose`, `first_available_boxes_to_change`, `first_time_choosing`, `second_box_choose`, `second_available_boxes_to_change`, `second_time_choosing`, `last_box_selected`) VALUES ('" . $userId . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["boxesNumber"] . "', '" . $_POST["winner_box"] . "', '" . $_POST["first_box_choose"] . "', '" . $_POST["first_available_boxes_to_change"] . "', '" . $_POST["first_time_choosing"] . "', '" . $_POST["second_box_choose"] . "', '" . $_POST["second_available_boxes_to_change"] . "', '" . $_POST["second_time_choosing"]. "', " . $_POST["last_box_selected"]. ")";

	if ($conn->query($sql) === TRUE) {
		return;
	} else {
		$conn->close();
	    die(json_encode(array("ok" => false, "msg" => "9.1 Error: " . $conn->error . ". The executed query was" . $sql)));
	}
}


/******************************************
* Funciones auxiliares
******************************************/

/**
* Función clearUserCookies: Borrar cookies del jugador
* @returns NULL | No devuelve ningún valor
*/
function clearUserCookies(){
	setcookie('games-username', null, -1, '/');
	setcookie('games-st', null, -1, '/');
}

/**
* Función redirectToRoot: Redirigir al directorio raíz si no se está en él
* @returns NULL | No devuelve ningún valor
*/
function redirectToRoot(){
	if($_SERVER['REQUEST_URI']!="/"){
		header('Location: /');
	}
}

/**
* Función getUserPannel: Borrar cookies del jugador
* @param $userName {string} | Nombre de usuario
* @param $userPoints {string} | Puntos de usuario
* @returns {string} | Devuelve un string con el HTML de la barra de login
*/
function getUserPannel($userName = null, $userPoints = null){
	if(!empty($userName) && !empty($userPoints)){
		return '<a href="/mi-panel"><span>Hola '.$userName.'. </span><span class="user-points"> Tienes '.$userPoints.' Movipuntos</span> <img src="images/movistar/user-icon.png"/></a><a class="unlog-button" title="desconectar" href="/desconectar">X</a>';
	}else{
		return '<a href="/juegos"><span>Acceder</span> <img src="images/movistar/user-icon.png"/></a>';
	}
}

/**
* Función userNotLogged: Usuario no logado
* @param $conn | Conexión a BD
* @returns NULL | No devuelve ningún valor
*/
function userNotLogged($conn=null){
	//Si hay conexión activa a BD, cerrarla
	if(!empty($conn)){
    	$conn->close();
	}
    //Borrar cookies de usuario
	clearUserCookies();
	//Redirigir al directorio raiz
	redirectToRoot();
}

/**
* Función getGameName: Obtener nombre completo de juego según se almacenó en BD
* @param $game {string} | Nombre del juego
* @returns {string} | Devuelve el nombre del juego
*/
function getGameName($game){
  switch ($game) {
    case "strawsGame":
      return "Juego de las cañas";
    case "cardsGame":
      return "Juego de las cartas";
    case "boxesGame":
      return "Juego de las cajas";
    default:
      return $game;
  }
}

/**
* Función getUserPointsHistory: Obtener historial de puntos
* @param $conn | Conexión a BD
* @param $userName {string} | Nombre de usuario
* @param $idGoal {string} | id de la oferta objetivo del usuario
* @returns array | Devuelve un array con dos subarrays, uno con datos en formato de tabla y otro con datos para inclusión en js
*/
function getUserPointsHistory($conn, $userName, $idGoal){
	$sql='(SELECT s.date as date, s.id_user as id_user, s.item_id as concept, s.points_variation as points_variation, s.points_result as points_result FROM shoppingHistory s WHERE id_user = "'.$userName.'") UNION (SELECT h.date as date, h.id_user as id_user, h.game as concept, h.points_variation as points_variation, h.points_result as points_result FROM gamesHistory h WHERE id_user = "'.$userName.'" AND h.points_variation != 0) order by date DESC';

	$result = $conn->query($sql);

	$table="";
	$jsdata="";

	if ($result->num_rows > 0) {
	    //Datos encontrados
	    while($row = $result->fetch_assoc()) {
	    	//Si el usuario es correcto, coger todos los datos e ir rellenándolos
	    	if($_COOKIE["games-username"] === $row["id_user"]){
		        $concept=getGoalName(substr($row["concept"],4,strlen($row["concept"])));
		        if(!$concept){
		          $concept=getGameName($row["concept"]);
		        }
		        $table.="<tr><td>".$concept."</td>"."<td>".$row["date"]."</td><td>".$row["points_variation"]."</td><td>".$row["points_result"]."</td></tr>";
	    		/*"$jsdata.=[new Date('".str_replace(" ", "T", $row["date"])."'),  ".($row["points_result"] == 0 ? "0":$row["points_result"]).",  'point { size: 2; fill-color: #31698A;}', ".-getItemCost("buy-".$idGoal, false).", 'point { }'],";*/
	    	}else{
	          $table.="";
	          $jsdata.="";
	      }
	    }

		$sql='SELECT DATE_FORMAT(date, "%Y-%m-%d") as datee, points_result FROM ((SELECT s.date as date, s.id_user as id_user, s.item_id as concept, s.points_variation as points_variation, s.points_result as points_result FROM shoppingHistory s WHERE id_user = "'.$userName.'") UNION (SELECT h.date as date, h.id_user as id_user, h.game as concept, h.points_variation as points_variation, h.points_result as points_result FROM gamesHistory h WHERE id_user = "'.$userName.'" AND h.points_variation != 0) order by date DESC) as t GROUP BY datee;';

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$last_date=null;
		    //Datos encontrados
		    while($row = $result->fetch_assoc()) {
		    	if(empty($last_date)){
		    		$last_date=$row["datee"];
		    	}
		    	$jsdata.="[new Date('".str_replace(" ", "T", $row["datee"])."'), ".$row["points_result"].", ".-getItemCost("buy-".$idGoal, false)."],";
			}
		}

	} else {
		$conn->close();
	  	$table="";
	}
	return array("table" => $table, "jsdata" => $jsdata);
}
