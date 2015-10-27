<?php
//Comprobación de login
$login=true;
//Si el usuario tiene las cookies
if(!empty($_COOKIE["games-username"]) && !empty($_COOKIE["games-st"])){
	//Conectar a BBDD
	include("store-data/db_connection.php");

	//Intentar conexión
	$conn = mysqli_connect($host_name, $user_name, $password, $database);
	if (mysqli_connect_errno()) {
	    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error().$host_name. $user_name. $password. $database;
	}

	//Obtener datos del usuario por su id y su Token de seguridad
	$sql="SELECT * FROM users WHERE id_user='".$_COOKIE["games-username"]."' AND security_token='".$_COOKIE["games-st"]."' LIMIT 1";
	$result = $conn->query($sql);

	//Comprobar usuario
	if ($result->num_rows > 0) {
	    //Datos encontrados
	    $row = $result->fetch_assoc();

    	//Si el usuario es correcto, coger sus puntos
    	if($_COOKIE["games-username"]===$row["id_user"]){
    		$conn->close();
    		$userPoints=$row["points"];
    		$userName=$row["id_user"];
    		$userToken=$row["security_token"];
    		$login=false;
    	}else{
            $conn->close();
            setcookie('games-username', null, -1, '/');
            setcookie('games-st', null, -1, '/');
        	if($_SERVER['REQUEST_URI']!="/"){
					header('Location: /');
			}
			//Barra de usuario no logado
			$user_pannel = '<a href="/juegos"><span>Acceder</span> <img src="images/movistar/user-icon.png"/></a>';
        }
	} else {
		$conn->close();
	    setcookie('games-username', null, -1, '/');
        setcookie('games-st', null, -1, '/');
    	if($_SERVER['REQUEST_URI']!="/"){
			header('Location: /');
		}
		//Barra de usuario no logado
		$user_pannel = '<a href="/juegos"><span>Acceder</span> <img src="images/movistar/user-icon.png"/></a>';
	}
	//Barra de usuario logado
	$user_pannel = '<a href="/mis-puntos"><span>Hola '.$userName.'. </span><span class="user-points"> Tienes'.$points.' puntos</span> <img src="images/movistar/user-icon.png"/></a><a class="unlog-button" title="desconectar" href="/desconectar">X</a>';
}else{
	if($_SERVER['REQUEST_URI']!="/"){
		header('Location: /');
	}
	//Barra de usuario no logado
	$user_pannel = '<a href="/juegos"><span>Acceder</span> <img src="images/movistar/user-icon.png"/></a>';
}