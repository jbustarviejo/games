<?php
//Coger Contenido
$content = file_get_contents("pages/index.php");
//Título
$title = "Movijuegos - Telefónica";
//Comprobar usuario logado y obtener panel de usuario
include("store-data/check-user-login.php");
//Layout de página
include("pages/layout.php");