<?php
/******************************************
/* Desconectar al usuario
******************************************/

//Borrar cookies de usuario
clearUserCookies();

//Volver a raíz
header("Location: /");
die();