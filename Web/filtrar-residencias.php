<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/funciones-residencia.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);

	$residencias = mysqli_query($con, "SELECT * FROM residencias ORDER BY id");

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
			<span id="subtitulo">Filtar residencias.</span>
			<p>Quiero residencias con semanas <select name="tipo"><option value="1">Libres (solo premium)</option><option value="2">En subasta</option><option value="3">En hotsale</option></select></p>
			<p>Dentro de el rango (inclusivo): </p>
			<p><small>No elija un rango mayor a 2 meses</small></p>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>