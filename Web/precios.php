<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	include('componentes/funciones-residencia.php');
	include('componentes/solo-admin.php');

	if (isset($_GET['cambiar']) && $_GET['cambiar'] == 1) {
		if (is_numeric($_POST['usuario']) && is_numeric($_POST['premium'])) {
			mysqli_query($con, "UPDATE variables SET valor='".$_POST['usuario']."' WHERE `nombre`='normal'");
			mysqli_query($con, "UPDATE variables SET valor='".$_POST['premium']."' WHERE `nombre`='premium'");
			echo "<div class='exito'><p>Valores actualizados con éxito.</p></div>";
		} else {
			echo "<div class='error'><p>Valores no numericos ingresados.</p></div>";
		}
	}

	// Obtener variables de servidor
	$vars = mysqli_query($con, "SELECT * FROM variables");
?>
<!DOCTYPE html>
<html>
<head>

	<title>Home Switch Home - Panel Administrativo</title>
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
		<span id="subtitulo">Actualizar precios</span></br>
		<span>&nbsp;</span>
		<form METHOD="post" ACTION="precios.php?cambiar=1">
			<table>
				<tr>
					<td style="width: 200px;">
						<span>Precio usuario basico:</span>
					</td>
					<td>
						<?php $variables = mysqli_fetch_array($vars); ?>
						<input name="usuario" type="number" class="campo-formulario" value="<?php echo $variables['valor']; ?>">
					</td>
				</tr>
				<tr>
					<td style="width: 200px;">
						<span>Precio usuario premium:</span>
					</td>
					<td>
						<?php $variables = mysqli_fetch_array($vars); ?>
						<input name="premium" type="number" class="campo-formulario" value="<?php echo $variables['valor']; ?>">
					</td>
				</tr>
			</table>
			<p>&nbsp;</p>
			<input class="boton" type="submit" value="Actualizar valores">
		</form>
	</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>