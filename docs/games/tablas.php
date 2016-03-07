<?php
/******************************************
/* Página de consula de contenido de tablas
******************************************/

//Comprobar usuario logado y obtener panel de usuario
include("store-data/check-user-login.php");

//Verificar usuarios administradores
if($userName!="test" && $userName!="alma" && $userName!="miguel" && $userName!="carlos" && $userName!="josue"){
	header("Location: /");
	die();
}

//Conectar con BBDD
$db = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
	die(json_encode(array("ok" => false, "msg" => "0.1 Error al conectar con servidor MySQL: " . mysqli_connect_error())));
}

//Comprobar URL
$table=substr($_SERVER['REQUEST_URI'], 8);
if($table==""){ //No hay tabla seleccionada. Página de consulta de tablas
	mysql_connect($host_name, $user_name, $password);
	$res = mysql_query("SHOW TABLES FROM $database");
	//Crear un enlace por tabla
	while($row = mysql_fetch_array($res, MYSQL_NUM)) {
	    echo "<a href='/tablas?".$row[0]."'>".$row[0]."</a><br/>";
	}
	//Invluir enlace a ranking
	echo "<a href='/tablas?ranking'>ranking</a><br/>";
}else{
	//Caso ranking
	if($table=="ranking"){
		$sql="SELECT id_user_entry, id_user, points FROM users ORDER BY points DESC";
	}else{
		$sql="SELECT * FROM ".$table." LIMIT 1000";
	}

	//Crear tabla con todos los datos
	echo "<table style='width:100%''>";
	$result = $db->query($sql);
	    //Datos encontrados
		$first=true;
		$i=1;
	    while($row = $result->fetch_assoc()){
	    	if($first){
	    		//SI es la primera entrada, ponemos los encabezados
	    		$first=false;
	    		echo "<td class='header'>#</td>";
	    		foreach ($row as $key => $values) {
	    			echo "<td class='header'>".$key."</td>";
	    		}
	    		echo "</tr><tr>";
	    	}
	    	echo "<td>".$i++."</td>";
		    foreach ($row as $key => $value) {
		    	echo "<td>".$value."</td>";
		    }
		    echo "</tr>";
		}
	echo "</table>";
}
//Estilos de tablas
?>
<style type="text/css">
	table, th, td {
    	border: 1px solid black;
    	border-collapse: collapse;
    	background-color: #a5d6d6;
	}
	.header{
		background-color: #80a6a6;
	}
</style>