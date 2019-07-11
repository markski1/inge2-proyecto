<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	include('componentes/solo-admin.php');
	include('componentes/funciones-residencia.php');

	$id = mysqli_real_escape_string($con, $_GET['id']);
	$semana = mysqli_real_escape_string($con, $_GET['semana']);

    // si el ID esta vacio, se asume un error y se envia al index
    if(!isset($id) || empty($id) || !isset($semana) || empty($semana)){
    	header('Location: index.php');
    }

    if (isset($_GET['modificar']) && $_GET['modificar'] == 1) {
		$precio = htmlspecialchars(mysqli_real_escape_string($con, $_POST['precio']));
		$semanaId = htmlspecialchars(mysqli_real_escape_string($con, $_GET['semana']));

		if (!is_numeric($precio) || $precio < 1) {
			MostrarError("Precio invalido o no ingresado.");
		} else {
			$sql = mysqli_query($con, "UPDATE `semanas` SET `hotsale_precio`='".$precio."' WHERE `id`='".$semanaId."'");
			if ($sql) echo '<div class="exito"><p>Precio de hotsale con exito.</p></div>';
			else MostrarError("Error al actualizar precio.");
		}
	}

	// se bajan los datos de la residencia en $residencia
    $residencia = mysqli_query($con, "SELECT * FROM residencias WHERE id=".$id);
    $datos_residencia = mysqli_fetch_array($residencia);

    $sem = mysqli_query($con, "SELECT * FROM semanas WHERE id=".$semana);
    $datos_semana = mysqli_fetch_array($sem);
    if ($datos_semana['hotsale'] != 1) {
    	header('Location: ver-residencia.php?id='.$id.'&error=1');
    	exit;
    }
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
			<span id="subtitulo" class="color-hsh"><b>Modificando hotsale.</b></span></br>
			<div class="contenido-pagina">
				<p><b>Ingrese un nuevo precio para este hotsale.</b></p>
				<form method="POST" action="modificar-hotsale.php?id=<?php echo $id; ?>&semana=<?php echo $semana;?>&modificar=1" onsubmit="return validarCrearSubasta()">
					<p>Precio <input class="campo-formulario" name="precio" value="<?php echo $datos_semana['hotsale_precio'] ?>" type="number"></p>
					<input type="submit" class="boton" value="Actualizar">
				</form>
				<p><a href="ver-residencia.php?id=<?php echo $id ?>">Volver a residencia.</a></p>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>