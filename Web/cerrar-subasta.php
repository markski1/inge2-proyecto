<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/solo-admin.php');
	include('componentes/sql.php');
	$con = conectar();
	include('componentes/funciones-residencia.php');

	$id = mysqli_real_escape_string($con, $_GET['id']);

    // si el ID esta vacio, se asume un error y se envia al index
    if(!isset($id) || empty($id)){
    	header('Location: index.php');
    }

    if (isset($_GET['semana'])) {
		if ($_GET['semana'] == '*') $semana = -1;
		else $semana = htmlspecialchars(mysqli_real_escape_string($con, $_GET['semana']));
	} else {
		$semana = -1;
	}

	if ($semana >= 0) {
		// Los ordenamos de mayor a menor oferta, de esta manera ya tenemos en el tope del vector respuesta a la oferta ganadora.
		$sql = mysqli_query($con, "SELECT * FROM subastas WHERE residencia=".$id." AND semana=".$semana." ORDER BY oferta DESC");
		if ($sql) {
			if (mysqli_num_rows($sql) > 0) {
				$cantidadOfertas = mysqli_num_rows($sql);
				$ofertaGanadora = mysqli_fetch_array($sql);
				$ganador = $ofertaGanadora['email'];
				$ganadorPaga = $ofertaGanadora['oferta'];
				$sql = mysqli_query($con, "UPDATE semanas SET sub_precio_base=0, subasta=0, reservado=1, reservado_por='".$ganador."', reservado_precio='".$ganadorPaga."' WHERE id=".$semana);
				if ($sql) {
					$mensaje = "La subasta se cerro. El ganador fue ".$ganador." con una oferta de $".$ganadorPaga.".";
				} else {
					$mensaje = "La subasta existe y tambien existen ofertas, pero no se pudo cerrar por un error de SQL.";
				}
			} else {
				// Solo una semana puede estar en subasta a la vez, asi que cerramos todo bajo el ID de residencia y ya esta.
				$sql = mysqli_query($con, "UPDATE semanas SET subasta=0 WHERE residencia=".$id);
				$mensaje = "Se cerro la subasta sin ganadores porque nadie oferto.";
			}
		} else {
			$mensaje = "Hubo un error, la base de datos no tomo la consulta.";
		}
	} else {
		$mensaje = "Hubo un error, el link esta mal. Intenta de nuevo.";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Switch Home</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<?php include('js/todo.php') ?>
</head>
<body>
	<div class="cabezera"> 
		<?php include('modulos/cabezera.php') ?>
	</div> 
	<div class="contenedor">
		<div class="sidebar">
			<?php include('modulos/sidebar.php') ?>
		</div>
		<div class="pagina">
			<span id="subtitulo">Cerrar subasta.</span>
			<p><?php echo $mensaje ?></p>
			<p><a href="ver-residencia.php?id=<?php echo $id ?>">Volver a la residencia.</a></p>			
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>