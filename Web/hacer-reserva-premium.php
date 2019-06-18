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

	if (!isset($_GET['id']) || !isset($_GET['semana']) || !is_numeric($_GET['semana']) ||!is_numeric($_GET['id'])) {
		header('Location: index.php?error=4');
		exit;
	}

	include('componentes/funciones-residencia.php');

	$datosUsuario = $sesion->obtenerDatosUsuario();

	$residencia = mysqli_query($con, "SELECT * FROM residencias WHERE id=".$_GET['id']);

    $datos_residencia = mysqli_fetch_array($residencia);

    function ImprimirError($error) {
		echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de reserva</h1></center><div class="reg-error"><p>Error: '.$error.'</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
	}

    if ($datosUsuario['tokens'] == 0) {
    	ImprimirError("No dispone de suficientes creditos.");
    	exit;
    }

    if (ChequearSemanaReservada($con, $_GET['semana'])) {
    	ImprimirError("La semana ya fue reservada.");
    	exit;
    }

    if (!$sesion->esPremium()) {
    	ImprimirError("Usuario no premium.");
    	exit;
    }

    $sql = mysqli_query($con, "UPDATE semanas SET sub_precio_base=0, subasta=0, reservado=1, reservado_por='".$_SESSION['email']."', reservado_precio='-1' WHERE id=".$_GET['semana']);
    if ($sql) {
    	$tokens = $datosUsuario['tokens'] - 1;
    	mysqli_query($con, "UPDATE usuarios SET tokens='".$tokens."'WHERE id='".$_SESSION['id']."'");
    	header('Location: ver-residencia.php?id='.$_GET['id'].'&semana='.$_GET['semana'].'&reservahecha=1');
    }
?>