<?php
	if (!isset($_GET['id']) || empty($_GET['id'])) {
		header('Location: index.php');
	}
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado();
	include('componentes/solo-admin.php');
	$id = mysqli_escape_string($con, $_GET['id']);
	$query = "UPDATE `residencias` SET oculto=0 WHERE id=".$id;
	$sql = mysqli_query($con, $query);
	if ($sql) {
		header('Location: index.php?exito=3');
		exit();
	}
	else header('Location: index.php?error=4');
?>