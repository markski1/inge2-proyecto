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
			<span id="subtitulo" class="color-hsh"><b>Nombre de residencia</b></span></br>
			<div class="contenido-pagina">
				<div class="alinear-izquierda" style="width: 45%">
					<div style="border: 2px solid black; width: 300px; height: 225px;"><p style="padding: 20px">Imagen de muestra</p><p style="padding: 20px">300x225 (4:3)</p></div>
				</div>
				<div class="alinear-derecha" style="width: 52.5%;">
					<p><span class="color-hsh"><b>Ciudad:</b></span> La Plata, Buenos Aires.</p>
					<p><span class="color-hsh"><b>Dirección:</b></span> Calle Falsa 123</p>
					<p><span class="color-hsh"><b>Piso y depto:</b></span> 4° D</p>
					<p><span class="color-hsh"><b>Precio por semana:</b></span> $1,700</p>
				</div>
				<div style="clear: both;"></div>
				<p><span class="color-hsh"><b>Descripción:</b></span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<?php 
				if (esAdmin()) {
					?>
					<p id="subtitulo">Controles administrativos.</p>
					<p><a href="crear-subasta.php?id=" style="color: green">Crear subasta.</a></p>
					<p><a href="modificar-residencia.php?id=" style="color: green">Modificar residencia.</a></p>
					<p><a href="eliminar-residencia.php?id=" style="color: red">Eliminar residencia.</a></p>
				<?php
				}
				?>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>