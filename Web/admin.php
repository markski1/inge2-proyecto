<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado();
	include('componentes/funciones-residencia.php');
	include('componentes/solo-admin.php');
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
			<span id="subtitulo">Panel administrativo.</span>
			<h3>Residencias</h3>
			<ul>
				<li><a href="agregar.php">Agregar residencia</a></li>
				<li><a href="listar-residencias-admin.php">Listar todas las residencias.</a></li>
			</ul>
				
			<h3>Usuarios</h3>
			<ul>
				<li><a href="ver-residencias-admin.php">Listar todos los usuarios</a></li>
				<li><a href="hacer-admin.php">Agregar administrador</a></li>
			</ul>

			<h3>General</h3>
			<ul>
				<li><a href="precios.php">Precios de usuario y premium.</a></li>
			</ul>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>