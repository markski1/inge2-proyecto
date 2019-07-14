<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	include('componentes/solo-admin.php');
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

		if (!is_numeric($precio) || $precio < 1) {
			MostrarError("Precio invalido o no ingresado.");
		} else {
			if (ChequearSemanaReservada($con, $semanaId)) {
				MostrarError("No se puede crear hotsale, esa semana ya fue reservada.");
			} else {
				if (ObtenerInformacionHotsale($con, $semanaId) == -1) {
					$sql = mysqli_query($con, "UPDATE `semanas` SET `hotsale`='1', `hotsale_precio`='".$precio."' WHERE `id`='".$semanaId."'");
					if ($sql) echo '<div class="exito"><p>Hotsale creado con exito.</p></div>';
					else MostrarError("Error al crear hotsale.");
				} else {
					MostrarError("Esta semana ya tiene un hotsale en curso.");
				}
			}
		}
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
			<span id="subtitulo" class="color-hsh"><b>Creando hotsale.</b></span></br>
			<div class="contenido-pagina">
				<p><b>Creando hotsale para la propiedad</b> <?php echo utf8_decode($datos_residencia['nombre'])?></p>
				<form method="POST" action="crear-hotsale.php?id=<?php echo $id; ?>&crear=1" onsubmit="return validarCrearSubasta()">
					<p>Precio: <input class="campo-formulario" name="precio" type="number"></p>
					<p>Semana:
					<select id="semanas" name="semana">
						<?php ListarSemanasHotsale($con, $id); ?>
					</select></p>
					<input type="submit" class="boton" value="Crear hotsale">
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