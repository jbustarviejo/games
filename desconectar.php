<?php
/******************************************
/* Desconectar al usuario
******************************************/

//Funciones auxiliares
include("store-data/functions.php");

//Borrar cookies de usuario
clearUserCookies();

//Volver a raíz
header("Location: /");
die();