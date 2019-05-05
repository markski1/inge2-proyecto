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
			<p><a href="listar-residencias.php">Listar todas nuestras residencias.</a></p>
			<p><a href="listar-residencias.php?tipo=subasta">Listar nuestras residencias en subasta.</a></p>
			
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>