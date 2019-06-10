<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado();
	if (!$logeado) {
		header('Location: index.php');
		exit;
	}

	$datosUsuario = $sesion->obtenerDatosUsuario();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Switch Home - Mi perfil</title>
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
			<span id="subtitulo" class="color-hsh"><b><?php echo utf8_decode($datosUsuario['apellido'])?>, <?php echo utf8_decode($datosUsuario['nombre'])?></b></span></br>
			<div class="contenido-pagina">
				<p id="subtitulo">Tu información</p>
				<p><span class="color-hsh"><b>E-Mail:</b></span> <?php echo utf8_decode($datosUsuario['email'])?></p>
				<p><span class="color-hsh"><b>Nacimiento:</b></span> <?php $fechaCompleta = utf8_decode($datosUsuario['nacimiento']); $mostrar = str_replace('00:00:00', '', $fechaCompleta); echo $mostrar;?></p>
				<p id="subtitulo">Información de tu tarjeta de credito</p>
				<p><span class="color-hsh"><b>Marca:</b></span> <?php echo utf8_decode($datosUsuario['cc_marca'])?></p>
				<p><span class="color-hsh"><b>Numero:</b></span> <?php echo utf8_decode($datosUsuario['cc_numero'])?></p>
				<p><span class="color-hsh"><b>Vencimiento:</b></span> <?php $fechaCompleta = utf8_decode($datosUsuario['cc_vencimiento']); $mostrar = str_replace('-28 00:00:00', '', $fechaCompleta); echo $mostrar;?></p>
				<p><a href="editar-perfil.php">Editar perfil</a></p>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>