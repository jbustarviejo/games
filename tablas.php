<?php

//Comprobar usuario logado y obtener panel de usuario
include("store-data/check-user-login.php");

if($userName!="test" && $userName!="alma" && $userName!="miguel" && $userName!="carlos" && $userName!="josue"){
	header("Location: /");
	die();
}

$db = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
	die(json_encode(array("ok" => false, "msg" => "0.1 Error al conectar con servidor MySQL: " . mysqli_connect_error())));
}

$table=substr($_SERVER['REQUEST_URI'], 8);
if($table==""){ //No hay tabla seleccionada
	mysql_connect($host_name, $user_name, $password);
	$res = mysql_query("SHOW TABLES FROM $database");
	while($row = mysql_fetch_array($res, MYSQL_NUM)) {
	    echo "<a href='/tablas?".$row[0]."'>".$row[0]."</a><br/>";
	}
	echo "<a href='/tablas?ranking'>ranking</a><br/>";
}else{
	//Caso ranking
	if($table=="ranking"){
		$sql="SELECT id_user_entry, id_user, points FROM users ORDER BY points DESC";
	}else{
		$sql="SELECT * FROM ".$table;
	}

	echo "<table style='width:100%''>";
	$result = $db->query($sql);
	    //Datos encontrados
		$first=true;
		$i=1;
	    while($row = $result->fetch_assoc()){
	    	if($first){
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
}?>
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