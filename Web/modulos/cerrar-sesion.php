<?php
include "../componentes/sql.php";
include "../componentes/funciones-usuarios.php";
$con = conectar();
$sesion = new sesion;

$logeado = $sesion->estaLogeado();

if ($logeado) {
	$sesion->cerrarSesion();
	header('Location: ../index.php');
} else {
	header('Location: ../index.php?error=4');
}
?>