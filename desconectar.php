<?php
//Borrar cookies de usuario
if($_COOKIE["games-username"]){
	unset($_COOKIE["games-username"]);
	setcookie('games-username', null, -1, '/');
}
if($_COOKIE["games-st"]){
	unset($_COOKIE["games-st"]);
	setcookie('games-st', null, -1, '/');
}

//Volver a raíz
header("Location: /");
die();