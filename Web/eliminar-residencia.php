<?php
	if (!isset($_GET['id']) || empty($_GET['id'])) {
		header('Location: index.php');
	}
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	include('componentes/solo-admin.php');
	$id = mysqli_escape_string($con, $_GET['id']);
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$id." AND reservado=1");
	if (mysqli_num_rows($sql) > 0) {
		header('Location: index.php?error=3');
		exit();
	}
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$id." AND hotsale=1");
	if (mysqli_num_rows($sql) > 0) {
		header('Location: index.php?error=8');
		exit();
	}
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$id." AND subasta=1");
	if (mysqli_num_rows($sql) > 0) {
		header('Location: index.php?error=7');
		exit();
	}
	$query = "DELETE FROM `residencias` WHERE id=".$id;
	$sql = mysqli_query($con, $query);
	if ($sql) {
		$sql = mysqli_query($con, "DELETE FROM `semanas` WHERE residencia=".$id);
		$sql = mysqli_query($con, "DELETE FROM `subastas` WHERE residencia=".$id);
		header('Location: index.php?exito=1');
		exit();
	}
	else header('Location: index.php?error=2');
?>