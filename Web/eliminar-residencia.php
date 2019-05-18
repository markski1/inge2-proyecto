<?php
	if (!isset($_GET['id']) || empty($_GET['id'])) {
		header('Location: index.php');
	}
	include('componentes/sql.php');
	$con = conectar();
	include('componentes/funciones-usuarios.php');
	include('componentes/solo-admin.php');
	$id = mysqli_escape_string($con, $_GET['id']);
	$query = "DELETE FROM `residencias` WHERE id=".$id;
	$sql = mysqli_query($con, $query);
	if ($sql) {
		$sql = mysqli_query($con, "DELETE FROM `semanas` WHERE residencia=".$id);
		$sql = mysqli_query($con, "DELETE FROM `subastas` WHERE residencia=".$id);
		header('Location: index.php?exito=1');
	}
	else header('Location: index.php?error=2');
?>