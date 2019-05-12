<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/solo-admin.php');
	include('componentes/sql.php');
	$con = conectar();
	include('componentes/funciones-residencia.php');

	$id = mysqli_real_escape_string($con, $_GET['id']);

    // si el ID esta vacio, se asume un error y se envia al index
    if(!isset($id) || empty($id)){
    	header('Location: index.php');
    }

    if (isset($_GET['crear']) && $_GET['crear'] == 1) {
		$error = 0;

		$precio = htmlspecialchars(mysqli_real_escape_string($con, $_POST['precio']));
		$semanaId = htmlspecialchars(mysqli_real_escape_string($con, $_POST['semana']));

		$sql = mysqli_query($con, "UPDATE `semanas` SET `subasta`='1', `sub_precio_base`='".$precio."' WHERE `id`='".$semanaId."'");
		if ($sql) echo '<div class="exito"><p>Subasta creada con exito.</p></div>';
		else echo '<div class="error"><p>Error al crear subasta.</p></div>';
	}

	// se bajan los datos de la residencia en $residencia
    $residencia = mysqli_query($con, "SELECT * FROM residencias WHERE id=".$id);

    $datos_residencia = mysqli_fetch_array($residencia);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Switch Home - Crear subasta</title>
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
			<span id="subtitulo" class="color-hsh"><b>Creando subasta.</b></span></br>
			<div class="contenido-pagina">
				<p><b>Crear subasta para la propiedad</b> <?=$datos_residencia['nombre']?></p>
				<form method="POST" action="crear-subasta.php?id=<?php echo $id; ?>&crear=1" onsubmit="return validarCrearSubasta()">
					<p>Precio base: <input class="campo-formulario" name="precio"></p>
					<p>Semana: <select id="semana" name="semana">
					<option class="campo-formulario" value="*">Seleccionar semana</option>
					<?php $subastas = ListarSemanas($con, $id, true); ?>
					</select></p>
					<input type="submit" class="boton" value="Crear subasta">
				</form>
				<p><a href="ver-residencia.php?id=<?php echo $id ?>">Volver a residencia.</a></p>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>