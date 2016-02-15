<?php
/******************************************
/* Login en aplicacación
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");
//Funciones auxiliares
include("functions.php");

//Obtener datos del usuario por su id y su contraseña
$sql="SELECT points, answer, pass, security_token, u.id_user as id_user FROM users u LEFT JOIN survey s on u.id_user = s.id_user WHERE u.id_user='".$_POST["username"]."' AND pass='".md5($_POST["password"])."' ORDER BY s.date DESC LIMIT 1";
$result = $conn->query($sql);

//Comprobar usuario
if ($result->num_rows > 0) {
    //Datos encontrados
    $row = $result->fetch_assoc();
    //Si el usuario es correcto...
    if($_POST["username"]===$row["id_user"] && md5($_POST["password"])===$row["pass"]){
        //Usuario correcto
        $conn->close();
        die(json_encode(array("ok" => true, "points"=>$row["points"], "survey"=>$row["answer"], "token"=>$row["security_token"])));
    }else{
        //Error
        $conn->close();
        die(json_encode(array("ok" => false)));
    }
} else {
    //No encontrado
    $conn->close();
    $points="";
    die(json_encode(array("ok" => false)));
}
die(json_encode(array("ok" => false)));