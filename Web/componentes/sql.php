<?php

// se conecta a la base de datos
function conectar(){
	$con = mysqli_connect('localhost', 'root', '', 'hsh');
	if (!$con) {
		echo ('No se pudo conectar. Error: '.mysqli_connect_errno());
		die();
    }
    mysqli_set_charset($con,'latin1');
	return $con;
}

?>