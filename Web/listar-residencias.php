<?php 
	include('componentes/funciones.php');
	if (isset($_GET['error'])) {
		switch ($_GET['error']) {
			case 1:
				echo "<div class='error'><p>ERROR: Intentaste acceder a un sitio restringido.</p></div>";
				break;
		}
	}
	include('componentes/sql.php');
	$con = conectar();
	$residencias = mysqli_query($con, "SELECT * FROM residencias ORDER BY id");

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
			<span id="subtitulo">Todas nuestras residencias.</span>
			<?php include('componentes/residencia-script-lista.php') ?>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>