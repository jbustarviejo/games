<?php
//Coger Contenido
$content = file_get_contents("pages/shop.php");
//Título
$title = "Tienda de Movipuntos - Telefónica";
//Comprobar usuario logado y obtener panel de usuario
include("store-data/check-user-login.php");
//Layout de página
include("pages/layout.php");