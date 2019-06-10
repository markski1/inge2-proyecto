<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado();
	$error = 0;
	include('componentes/funciones-residencia.php');
	include('componentes/solo-admin.php');

	$datosUsuario = $sesion->obtenerDatosUsuario();
?>
<!DOCTYPE html>
<html>
<head>

	<title>Home Switch Home - Editando perfil</title>
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
			<span id="subtitulo">Editar perfil.</span>
			<form class="formulario" method="post" action="realizarRegistro.php" onsubmit="return validarRegistro()">
				<span>&nbsp;</span>
				<center><p id="subtitulo">Información personal</p></center>
				<span>&nbsp;</span>
				<table>
					<tr>
						<td style="width: 200px;">
							<span>Nombre:</span>
						</td>
						<td>
							<input maxlength="32" value="<?php echo utf8_decode($datosUsuario['nombre']); ?>" name="nom" class="campo-formulario" id="nom">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Apellido:</span>
						</td>
						<td>
							<input maxlength="64" value="<?php echo utf8_decode($datosUsuario['apellido']); ?>" name="ape" class="campo-formulario" id="ape">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>E-Mail:</span></td>
						<td>
							<input maxlength="64" value="<?php echo utf8_decode($datosUsuario['email']); ?>" name="email" class="campo-formulario" id="email">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Fecha de Nacimiento:</span></td>
						<td>
							<input maxlenght="2" placeholder="Dia" style="width: 80px;" name="nac_dia" type="number" class="campo-formulario" id="nac_dia">
							<input maxlenght="2" placeholder="Mes" style="width: 80px;" name="nac_mes" type="number" class="campo-formulario" id="nac_mes">
							<input maxlenght="4" placeholder="Año" style="width: 150px;" name="nac_anno" type="number" class="campo-formulario" id="nac_anno">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Contraseña:</span></td>
						<td>
							<input maxlenght="16" name="clv" type="password" class="campo-formulario" placeholder="Dejar vacio para no cambiar." id="clv">
						</td>
					</tr>
				</table>
				<span>&nbsp;</span>
				<center><p id="subtitulo">Información de Tarjeta de Credito</p></center>
				<span>&nbsp;</span>
				<table>
					<tr>
						<td style="width: 200px;">
							<span>Marca:</span>
						</td>
						<td>
							<input maxlenght="16" value="<?php echo utf8_decode($datosUsuario['cc_marca']); ?>" name="cc_marca" class="campo-formulario" id="cc_marca">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Numero:</span>
						</td>
						<td>
							<input type="number" value="<?php echo utf8_decode($datosUsuario['cc_numero']); ?>" maxlenght="16" placeholder="16 caracteres" name="cc_num" class="campo-formulario" id="cc_num">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Código de seguridad:</span>
						</td>
						<td>
							<input type="number" value="<?php echo utf8_decode($datosUsuario['cc_segur']); ?>" maxlenght="16" placeholder="3 caracteres" name="cc_seg" class="campo-formulario" id="cc_seg">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Nombre de Titular:</span>
						</td>
						<td>
							<input maxlenght="16" value="<?php echo utf8_decode($datosUsuario['cc_titular']); ?>" name="cc_titular" class="campo-formulario" id="cc_titular">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Fecha de vencimiento:</span>
						</td>
						<td>
							<input maxlenght="2" placeholder="Mes" style="width: 110px;" name="cc_venc_mes" type="number" class="campo-formulario" id="cc_venc_mes">
							<input maxlenght="4" placeholder="Año" style="width: 245px;" name="cc_venc_anno" type="number" class="campo-formulario" id="cc_venc_anno">
						</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<input class="boton" type="submit" value="Crear nueva cuenta">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>