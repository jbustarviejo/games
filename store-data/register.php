<?php
/******************************************
/* Registro en aplicacación
******************************************/

//Obtener datos de conexión a BD
include("db_connection.php");
//Funciones auxiliares
include("functions.php");

//Obtener datos del usuario por su id y su contraseña
$sql="SELECT u.id_user as id_user FROM users u WHERE u.id_user='".$_POST["username"]."' LIMIT 1";
$result = $conn->query($sql);

//Comprobar usuario
if ($result->num_rows > 0) {
    //Usuario ya registrado
    $conn->close();
    die(json_encode(array("ok" => false, "msg" => "El usuario ya está registrado")));
} else {
    $uuid=uniqid();
    $sql = "INSERT INTO users (`id_user`, `pass`, `points`, `security_token`) VALUES ('" . $_POST["username"] . "', '" . md5($_POST["password"]) . "', '10', '".$uuid."')";
    if ($conn->query($sql) === TRUE) {
        die(json_encode(array("ok" => true, "points"=>10, "token"=>$uuid)));
    } else {
        die(json_encode(array("ok" => false, "error"=>$sql)));
    }
}
die(json_encode(array("ok" => false)));