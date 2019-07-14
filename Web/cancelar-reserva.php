<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	if (!$logeado) {
		header('Location: index.php');
		exit;
	}

	function ImprimirError($error) {
		echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de cancelacion</h1></center><div class="reg-error"><p>Error: '.$error.'</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
	}

	$datosUsuario = $sesion->obtenerDatosUsuario();

	if (!isset($_GET['id'])) {
		ImprimirError("No se incluyo un ID.");
		exit;
	}

	$id = $_GET['id'];

	$chequeo = mysqli_query($con, "SELECT * FROM semanas WHERE id=".$id);
	$datos_chequeo = mysqli_fetch_array($chequeo);

	if ($datos_chequeo['reservado_por'] != $datosUsuario['email']) {
		ImprimirError("La semana que estas tratando de cancelar no es tuya.");
		exit;
	}

	$fecha = time();
	$fechaReserva = strtotime($datos_chequeo['fecha']);

	if ($fecha > $fechaReserva) {
		ImprimirError("Esta reserva no se puede cancelar porque ya paso.");
		exit;
	}


	$sql = mysqli_query($con, "UPDATE semanas SET `reservado`='0', `reservado_por`='', `reservado_precio`='0', `hotsale_precio`='0' WHERE `id`='".$id."'");
	if ($sql) {
		header('Location: mis-reservas.php?exito=1');
	} else {
		header('Location: mis-reservas.php?error=1');
	}
?>