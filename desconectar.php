<?php
//Borrar cookie de usuario
if($_COOKIE["games-username"]){
	unset($_COOKIE["games-username"]);
	setcookie('games-username', null, -1, '/');
}

//Volver a raíz
header("Location: /");
die();