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
	$semana = mysqli_escape_string($con, $_GET['semana']);
	$query = "UPDATE `semanas` SET hotsale=0, hotsale_precio=0 WHERE id=".$semana;
	$sql = mysqli_query($con, $query);
	if ($sql) {
		header('Location: ver-residencia.php?id='.$id.'&exito=1');
		exit();
	}
	else header('Location: ver-residencia.php?id='.$id.'&error=2');
?>