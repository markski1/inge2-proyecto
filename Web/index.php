<?php include('componentes/funciones.php');
if (isset($_GET['error'])) {
	switch ($_GET['error']) {
		case 1:
			echo "<div class='error'><p>ERROR: Intentaste acceder a un sitio restringido.</p></div>";
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
			<span id="subtitulo">Bienvenido.</span>
			<p>Nuestras residencias:</p>
			<div class="residencia-listado">
				<div class="alinear-izquierda" style="width: 205px; margin-left: 10px;">
					<div style="border: 2px solid black; width: 200px; height: 150px;"><p style="padding: 20px">Img de muestra</br></br>200x150 (4:3)</p></div>
				</div>
				<div class="alinear-derecha" style="width: 63%; min-width: 370px; padding-top: 10px; padding-left: 14px;">
					<span id="subtitulo" class="color-hsh">Nombre de residencia</span></br>
					<p>La Plata, Buenos aires</p>
					<p>2 habitaciones, 1 baño, living-comedor. Zona centrica.</p>
					<p>$1,700</p>
				</div>
				<div style="clear: both;"></div>
				<div class="residencia-saber-mas"><span><a href="ver-residencia.php?id=" class="no-subrayado">Más informacion.</a></span></div>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>