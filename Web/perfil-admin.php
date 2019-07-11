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
	include('componentes/solo-admin.php');

	$datosUsuario = $sesion->obtenerDatosUsuario();

	if (isset($_GET['cambiar']) && $_GET['cambiar'] == 1) {
		$error = 0;
		if (!is_numeric($_POST['rango'])|| $_POST['rango'] < 0 || $_POST['rango'] > 2) {
			$error = 1;
		}
		if (!$error) {
			$sql = mysqli_query($con, "UPDATE usuarios SET rango='".$_POST['rango']."' WHERE id=".$_GET['id']);
			if (!$sql) {
				$error = 1;
			}
		}
		if ($error) {
			MostrarError("Ocurrio un error actualizando el perfil.");
		} else {
			echo '<div class="exito"><p>Perfil actualizado con éxito.</p></div>';
		}
	}

	$datosUsuarioViendo = ObtenerDatosUsuarioPorID($_GET['id']);
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
			<span id="subtitulo" class="color-hsh"><b><?php echo utf8_decode($datosUsuarioViendo['apellido'])?>, <?php echo utf8_decode($datosUsuarioViendo['nombre'])?></b></span></br>
			<div class="contenido-pagina">
				<p id="subtitulo">Tu información</p>
				<p><span class="color-hsh"><b>E-Mail:</b></span> <?php echo utf8_decode($datosUsuarioViendo['email'])?></p>
				<p><span class="color-hsh"><b>Nacimiento:</b></span> <?php $fechaCompleta = utf8_decode($datosUsuarioViendo['nacimiento']); $mostrar = str_replace('00:00:00', '', $fechaCompleta); echo $mostrar;?></p>
				<p id="subtitulo">Información de tu tarjeta de credito</p>
				<p><span class="color-hsh"><b>Marca:</b></span> <?php echo utf8_decode($datosUsuarioViendo['cc_marca'])?></p>
				<p><span class="color-hsh"><b>Numero:</b></span> <?php echo utf8_decode($datosUsuarioViendo['cc_numero'])?></p>
				<p><span class="color-hsh"><b>Vencimiento:</b></span> <?php $fechaCompleta = utf8_decode($datosUsuarioViendo['cc_vencimiento']); $mostrar = str_replace('-28 00:00:00', '', $fechaCompleta); echo $mostrar;?></p>
				<p id="subtitulo">Datos varios</p>
				<p><span class="color-hsh"><b>Creditos restantes:</b></span> <?php echo utf8_decode($datosUsuarioViendo['tokens']);?></p>
				<p><span class="color-hsh"><b>Rango actual:</b></span> <?php echo ImprimirTipoUsuario($datosUsuarioViendo)?></p>
				<p>Cambiar rango</p>
				<form method="POST" action="perfil-admin.php?id=<?php echo $_GET['id'] ?>&cambiar=1">
					<select name="rango">
						<option value="*">Seleccionar rango</option>
						<option value="0">Usuario basico</option>
						<option value="1">Usuario premium</option>
						<option value="2">Administrador</option>
					</select></br>&nbsp;</br>
					<input value="Cambiar rango" class="boton" type="submit">
				</form>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>