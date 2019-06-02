<?php
	if (!isset($_GET['id']) || empty($_GET['id'])) {
		header('Location: index.php');
	}
	include('componentes/sql.php');
	$con = conectar();
	include('componentes/funciones-usuarios.php');
	include('componentes/solo-admin.php');
	$id = mysqli_escape_string($con, $_GET['id']);
	$query = "UPDATE `residencias` SET oculto=1 WHERE id=".$id;
	$sql = mysqli_query($con, $query);
	if ($sql) {
		header('Location: index.php?exito=2');
		exit();
	}
	else header('Location: index.php?error=4');
?>