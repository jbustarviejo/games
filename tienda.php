<?php
//Coger Contenido
$content = file_get_contents("pages/shop.php");
//Título
$title = "Tienda de puntos - Movistar";

//Si el usuario está logado 
if($_COOKIE["games-username"]){
	//Conectar a BBDD
	include("store-data/db_connection.php");

	$conn = mysqli_connect($host_name, $user_name, $password, $database);
	if (mysqli_connect_errno()) {
	    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
	}

	$sql="SELECT * FROM users WHERE id_user='".$_COOKIE["games-username"]."' LIMIT 1";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    //Datos encontrados
	    while($row = $result->fetch_assoc()) {
	    	//Si el usuario es correcto, coger sus puntos
	    	if($_COOKIE["games-username"]===$row["id_user"]){
	    		$conn->close();
	    		$points="Tienes ".$row["points"]." puntos";
	    	}else{
	            $conn->close();
	            $points="";
	        }
	    }
	} else {
		$conn->close();
	    $points="";
	}
	//Barra de usuario logado
	$user_pannel = '<a href="/mis-puntos"><span>Hola '.$_COOKIE["games-username"].'. </span><span class="user-points">'.$points.'</span> <img src="images/movistar/user-icon.png"/></a><a class="unlog-button" title="desconectar" href="/desconectar">X</a>';
}else{
	//Barra de usuario no logado
	$user_pannel = '<a href="/juegos"><span>Acceder</span> <img src="images/movistar/user-icon.png"/></a>';
}

//Layout de página
include("pages/layout.php");