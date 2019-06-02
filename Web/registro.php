<?php 
	include('componentes/funciones-usuarios.php') ;
	include('componentes/sql.php');
	$con = conectar();
	$error = 0;
	if (isset($_GET['error'])) {
		switch ($_GET['error']) {
			case 1:
				echo "<div class='error'><p>ERROR: Uno o mas campos no fueron correctamente llenados.</p></div>";
				break;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>

	<title>Home Switch Home - Agregando residencia</title>
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
			<span id="subtitulo">Registrar una nueva cuenta.</span>
			<form class="formulario" enctype="multipart/form-data" method="post" action="agregar.php?agregando=1" onsubmit="return validarResidencia()">
				<span>&nbsp;</span>
				<center><p id="subtitulo">Información personal</p></center>
				<span>&nbsp;</span>
				<table>
					<tr>
						<td style="width: 200px;">
							<span>Nombre:</span>
						</td>
						<td>
							<input maxlength="32" name="nom" class="campo-formulario" id="nom">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Apellido:</span>
						</td>
						<td>
							<input maxlength="64" name="ape" class="campo-formulario" id="loc">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>E-Mail:</span></td>
						<td>
							<input maxlength="64" name="email" class="campo-formulario" id="calle">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Fecha de Nacimiento:</span></td>
						<td>
							<input maxlenght="5" name="nac" type="number" class="campo-formulario" id="num">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Contraseña:</span></td>
						<td>
							<input maxlenght="16" name="clv" class="campo-formulario" placeholder="Minimo 6 caracteres." id="pyd">
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
							<input maxlenght="16" name="cc_marca" class="campo-formulario" id="pyd">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Numero:</span>
						</td>
						<td>
							<input type="number" maxlenght="16" name="cc_num" class="campo-formulario" id="pyd">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Código de seguridad:</span>
						</td>
						<td>
							<input type="number" maxlenght="16" name="cc_seg" class="campo-formulario" id="pyd">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Nombre de Titular:</span>
						</td>
						<td>
							<input maxlenght="16" name="cc_seg" class="campo-formulario" id="pyd">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Fecha de vencimiento:</span>
						</td>
						<td>
							<input maxlenght="16" name="cc_seg" class="campo-formulario" id="pyd">
						</td>
					</tr>
				</table>
				<input class="boton" type="submit" value="Agregar residencia.">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>