<?php
include "../componentes/sql.php";
include "../componentes/funciones-usuarios.php";
$con = conectar();
$sesion = new sesion;

$logeado = $sesion->estaLogeado($con);

if ($logeado) {
	$sesion->cerrarSesion();
	header('Location: ../index.php');
} else {
	header('Location: ../index.php?error=4');
}
?>