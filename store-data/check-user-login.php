<?php
/******************************************
/* Comprobar cookie de usuario
******************************************/

//Funciones auxiliares
include("functions.php");

//Si $login = true, mostrar pantalla de login al usuario
$login=true;

//Si el usuario tiene las cookies
if(!empty($_COOKIE["games-username"]) && !empty($_COOKIE["games-st"])){
	//Obtener datos de conexión a BD
	include("db_connection.php");

	//Obtener datos del usuario por su id y su Token de seguridad
	$sql="SELECT points, (SELECT answer FROM survey s WHERE s.id_user='".$_COOKIE["games-username"]."' ORDER BY s.date DESC LIMIT 1) as answer, pass, security_token, u.id_user as id_user, (SELECT id_goal FROM user_goal g WHERE g.id_user='".$_COOKIE["games-username"]."' ORDER BY g.date DESC LIMIT 1) as id_goal FROM users u WHERE u.id_user='".$_COOKIE["games-username"]."' AND security_token='".$_COOKIE["games-st"]."' LIMIT 1";
	$result = $conn->query($sql);

	//Comprobar usuario
	if ($result->num_rows > 0) {
	    //Datos encontrados
	    $row = $result->fetch_assoc();

    	//Si el usuario es correcto, coger sus datos
    	if($_COOKIE["games-username"]===$row["id_user"]){
    		$userPoints=$row["points"];
    		if($userPoints<=0){
    			//Usuario sin puntos
				$userWithZeroPoints=true;
				//Aumentar a 10
				$userPoints = 10;
				//Regalar 10 puntos
				registerInHistory($conn, $row["id_user"], "Regalo de puntos", 10, $userPoints);
    		}
    		if($_SERVER['REQUEST_URI']=="/tienda"){
    			//En la página de tienda. Obtener compras del usuario
				$purchases=getUserPurchases($conn, $row["id_user"]);
				$purchaseListForJs="";
				foreach ($purchases as $item) {
					$purchaseListForJs.="$('#".$item["itemId"]."').parents('.sale-container:first').addClass('purchased');";
				}
    		}
    		$userName=$row["id_user"];
    		$userToken=$row["security_token"];
    		$surveyAnswer=$row["answer"];
    		$login=false;
    		$conn->close();
    		if(empty($row["answer"])){
    			//Si no tiene fijada una respuesta de la encuesta, indicarlo
    			$showAnswer=true;
    		}
    		if(empty($row["id_goal"])){
    			//Si no tiene fijada una meta, indicarlo
    			$showGoal=true;
    		}else{
    			$idGoal=$row["id_goal"];
    		}
    	}else{
    		//Usuario incorrecto
    		userNotLogged($conn);
    		//Barra de usuario no logado
			$user_pannel = getUserPannel();
        }
	} else {
		//Usuario no encontrado o incorrecto
		userNotLogged($conn);
		//Barra de usuario no logado
		$user_pannel = getUserPannel();
	}
	//Barra de usuario logado
	$user_pannel = getUserPannel($userName, $userPoints);
}else{
	//usuario sin cookies
	userNotLogged();
	//Barra de usuario no logado
	$user_pannel = getUserPannel();
}