<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado();
	include('componentes/solo-admin.php');
	include('componentes/funciones-residencia.php');

	$id = mysqli_real_escape_string($con, $_GET['id']);

    // si el ID esta vacio, se asume un error y se envia al index
    if(!isset($id) || empty($id)){
    	header('Location: index.php');
    }

    if (isset($_GET['semana'])) {
		if ($_GET['semana'] == '*') $semana = -1;
		else $semana = htmlspecialchars(mysqli_real_escape_string($con, $_GET['semana']));
	} else {
		$semana = -1;
	}

	if ($semana >= 0) {
		$mensaje = CerrarSubasta($con, $semana);
	} else {
		$mensaje = "Hubo un error, el link esta mal. Intenta de nuevo.";
	}
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
			<span id="subtitulo">Cerrar subasta.</span>
			<p><?php echo $mensaje ?></p>
			<p><a href="ver-residencia.php?id=<?php echo $id ?>">Volver a la residencia.</a></p>			
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>