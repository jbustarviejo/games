<?php

$title = "Mis puntos - Movistar";

if($_COOKIE["games-username"]){

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

	$user_pannel = '<a href="/mis-puntos"><span>Hola '.$_COOKIE["games-username"].'. </span><span class="user-points">'.$points.'</span> <img src="images/movistar/user-icon.png"/></a>';
}else{
	header("Location: /");
	die();
}

/*Content*/

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

$sql="(SELECT u.id_user as id_user, 'Juego de las cañas' as game, s.date as 'date', (s.selected=s.winner) as won FROM users u LEFT JOIN `strawsGameRecords` s ON u.id_user = s.id_user WHERE u.id_user='".$_COOKIE["games-username"]."') UNION (SELECT u.id_user as id_user, 'Juego de las cartas' as game, c.date as 'date', (c.winner_side = c.displayed_side) as won FROM users u LEFT JOIN `cardsGameRecords` c ON u.id_user = c.id_user WHERE u.id_user='".$_COOKIE["games-username"]."') UNION (SELECT u.id_user as id_user, 'Juego de las cajas' as game, b.date as 'date', (b.winner_box = b.last_box_selected) as won FROM users u LEFT JOIN `boxesGameRecords` b ON u.id_user = b.id_user WHERE u.id_user='".$_COOKIE["games-username"]."') ORDER BY date DESC";

$result = $conn->query($sql);

$table="";

if ($result->num_rows > 0) {
    //Datos encontrados
    while($row = $result->fetch_assoc()) {
    	if($_COOKIE["games-username"]===$row["id_user"]){
    		if($row["won"]==1){
    			$won_table="Ganaste";
    		}else{
    			$won_table="Perdiste";
    		}
    		$table.="<tr><td>".$row["game"]."</td>"."<td>".$row["date"]."</td>"."<td>".$won_table."</td></tr>";
    	}else{
            $table.="";
        }
    }
} else {
	$conn->close();
    $table="--";
}

$content = <<<HTML
	<h1 class="fake-title">Mis puntos</h1>

	<!--Contentedor principal del juego-->    
	<div id="points-container">
		<p>Historial de puntos: $points</p>
		<table style="width:100%">
			 <thead>
			 <td>Juego</td><td>Fecha</td><td>Resultado</td>
			 </thead>
			 <tbody>
				$table
			</tbody>
		</table> 
	</div>
HTML;

/*Layout*/

include("pages/layout.php");
