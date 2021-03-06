<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);

	if ($logeado) $datosUsuario = $sesion->obtenerDatosUsuario();

	if (isset($_GET['error'])) {
		switch ($_GET['error']) {
			case 1:
				echo "<div class='error'><p>Intentaste acceder a un sitio restringido.</p></div>";
				break;
			case 2:
				echo "<div class='error'><p>Error al eliminar residencia.</p></div>";
				break;
			case 3:
				echo "<div class='error'><p>No se puede eliminar esta residencia porque tiene una o mas semanas reservadas.</p></div>";
				break;
			case 4:
				echo "<div class='error'><p>Error desconocido.</p></div>";
				break;
			case 5:
				echo "<div class='error'><p>E-Mail o clave incorrectos.</p></div>";
				break;
			case 6:
				echo "<div class='error'><p>La residencia no se pudo ocultar porque tiene una subasta en curso.</p></div>";
				break;
			case 7:
				echo "<div class='error'><p>No se puede eliminar esta residencia porque tiene una subasta en curso.</p></div>";
				break;
			case 8:
				echo "<div class='error'><p>No se puede eliminar esta residencia porque tiene uno o mas hotsales en curso.</p></div>";
				break;
		}
	}
	if (isset($_GET['exito'])) {
		switch($_GET['exito']) {
			case 1:
				echo "<div class='exito'><p>Residencia eliminada con éxito.</p></div>";
				break;
			case 2:
				echo "<div class='exito'><p>Residencia oculta con éxito.</p></div>";
				break;
			case 3:
				echo "<div class='exito'><p>Residencia re-publicada con éxito.</p></div>";
				break;
			case 4:
				echo "<div class='exito'><p>Usuario registrado con éxito. Utilice la forma para logearse.</p></div>";
				break;

		}
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
			<?php 
			if (!$logeado) {
				echo '<span id="subtitulo">Bienvenido, invitado.</span>';
				echo '<p>Home Switch Home es un servicio de tiempos compartidos en el cual podes competir con otros usuarios por residencias, al igual que tambien beneficiarte de ofertas especiales. Es necesario que seas miembro del sitio para participar.';
				echo '<p>Si deseas ser miembro, o si ya lo sos, podes acceder al sitio desde la barra lateral izquierda.';
				echo '<p>Si no sos miembro, solo podras ver las residencias.</p>';
			} else {
				echo '<span id="subtitulo">Bienvenido, '.$_SESSION['nombre'].'.</span>';
				echo '<p>Usuario '.ImprimirTipoUsuario($datosUsuario).'.</p>';
			}
			?>
			
			<p><a href="listar-residencias.php">Listar todas las residencias.</a></p>
			<p><a href="filtrar-residencias.php">Filtrar residencias por semanas.</a></p>
			
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>