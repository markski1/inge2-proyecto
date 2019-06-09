<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	include('componentes/funciones-residencia.php');

	$id = mysqli_real_escape_string($con, $_GET['id']);
	if (isset($_GET['semana'])) {
		if ($_GET['semana'] == '*') $semana = -1;
		else $semana = htmlspecialchars(mysqli_real_escape_string($con, $_GET['semana']));
	} else {
		$semana = -1;
	}

    // si el ID esta vacio, se asume un error y se envia al index
    if(!isset($id) || empty($id)){
    	header('Location: index.php');
    }

    if(isset($_GET['ofertar']) && $_GET['ofertar'] == 1) {
    	if ($semana != -1){
	    	$oferta = htmlspecialchars(mysqli_real_escape_string($con, $_POST['oferta']));
	    	$email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
	    	$obtenerSubastaAOfertar = mysqli_query($con, "SELECT * FROM semanas WHERE id=".$semana);
	    	$datosSubastaOfertar = mysqli_fetch_array($obtenerSubastaAOfertar);
 	    	if (EsOfertaValida($con, $semana, $id, $oferta, $datosSubastaOfertar['sub_precio_base'])) {
	    		if ($email == '') {
	    			echo '<div class="error"><p>No ingreso un e-mail valido.</p></div>';
	    		} else {
	    			$agregarOferta = mysqli_query($con, "INSERT INTO subastas (residencia, semana, email, oferta) VALUES ('".$id."', '".$semana."', '".$email."', '".$oferta."')");
	    			if ($agregarOferta) {
	    				echo '<div class="exito"><p>Has ofertado con exito.</p></div>';
	    			} else {
	    				echo '<div class="error"><p>Error al crear oferta.</p></div>';
	    			}
	    		}
	    	} else {
	    		echo '<div class="error"><p>Su oferta no es lo suficientemente alta.</p></div>';
	    	}
    	} else {
    		echo '<div class="error"><p>Error desconocido.</p></div>';
    	}
    } 

	// se bajan los datos de la residencia en $residencia
    $residencia = mysqli_query($con, "SELECT * FROM residencias WHERE id=".$id);

    $datos_residencia = mysqli_fetch_array($residencia);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Switch Home - Viendo residencias</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<?php include('js/todo.php') ?>
	<script type="text/javascript">
		function elegirSemana() {
			var cajaSemanas = document.getElementById("semanas");
			var semanaElegida = cajaSemanas.options[cajaSemanas.selectedIndex].value;
			var redireccionAux = "ver-residencia.php?id=<?php echo $id ?>&semana=";
			var redireccion = redireccionAux.concat(semanaElegida);
			window.location = redireccion;
		}
		function confirmarEliminar() {
			var confirmacion=confirm("Seguro que queres eliminar esta residencia?");
			if (confirmacion) {
				window.location = "eliminar-residencia.php?id=<?php echo $id ?>";
			}
		}
	</script>
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
			<span id="subtitulo" class="color-hsh"><b><?php echo utf8_decode($datos_residencia['nombre'])?></b></span></br>
			<div class="contenido-pagina">
				<div class="alinear-izquierda" style="width: 45%">
					<img style="width: 300px; height: 225px;" src="componentes/imagen.php?id=<?php echo $id?>"/>
				</div>
				<div class="alinear-derecha" style="width: 52.5%;">
					<p><span class="color-hsh"><b>Ciudad:</b></span> <?php echo utf8_decode($datos_residencia['localizacion'])?></p>
					<p><span class="color-hsh"><b>Dirección:</b></span> <?php echo utf8_decode($datos_residencia['calle'])?>, <?php echo $datos_residencia['numero']?></p>
					<?php
					if ($datos_residencia['pisoydepto'] != "NA") {
							echo '<p><span class="color-hsh"><b>Piso y depto:</b></span> ';
							echo $datos_residencia['pisoydepto'];
							echo '</p>';
						}
					?>
					<p><span class="color-hsh"><b>Precio por semana:</b></span> $<?php echo $datos_residencia['precio']?></p>
				</div>
				<div style="clear: both;"></div>
				<p><span class="color-hsh"><b>Descripción:</b></span> <?php echo utf8_decode($datos_residencia['descripcion'])?></p>
				<select id="semanas" name="semana" onchange="elegirSemana();">
				<option value="*">Seleccionar semana</option>
				<?php $subastas = ListarSemanas($con, $id, $semana, $estado); ?>
				</select>
				<?php 
					$subOfertable = false;
					switch ($estado) {
						case 1:
							$subOfertable = true;
							echo '<p>Esta semana esta en subasta.</p>';
							break;

						case 2:
							echo '<p>Esta semana solo puede ser reservada por un usuario premium.</p>';
							break;

						case 3:
							echo '<p>Esta semana ya esta reservada.</p>';
							if (esAdmin()) {
								echo ObtenerInfoReserva($con, $id, $semana);
							}
							break;
						
						default:
							if ($subastas > 0) {
									echo '<p>Esta residencia tiene una subasta en curso. <a href="./ver-residencia.php?id='.$id.'&semana='.$subastas.'">Ir a subasta.</a></p>';
							} else echo '<p>Esta residencia no tiene subastas en curso.</p>';
							break;
					}
					

					if ($subOfertable) {
						$obtenerDatosSubasta = mysqli_query($con, "SELECT * FROM `semanas` WHERE residencia=".$id." AND id=".$semana);
						$listarDatosSubasta = mysqli_fetch_array($obtenerDatosSubasta);
						$email = '';
						$cantidadOfertas = 0;
						$ofertaMasAlta = ObtenerOfertaMasAlta($con, $id, $semana, $email, $cantidadOfertas);
						if ($ofertaMasAlta >= $listarDatosSubasta['sub_precio_base']) {
							$ofertaMinima = $ofertaMasAlta+100;
						} else {
							$ofertaMinima = $listarDatosSubasta['sub_precio_base'];
						}
				?>
				<p id="subtitulo">Ofertar en subasta.</p>
				<p>El precio base es de $<?php echo $listarDatosSubasta['sub_precio_base'] ?></p>
				<?php 
					if ($ofertaMasAlta == 0) echo '<p>Nadie ha ofertado aun por esta propiedad.</p>';
					else echo '<p>La oferta mas alta es de '.$ofertaMasAlta.' por '.$email.'</p>';
				?>
				<form method="post" action="ver-residencia.php?id=<?php echo $id?>&semana=<?php echo $semana?>&ofertar=1">
					<p><input class="campo-formulario" name="oferta" type="number" placeholder="Cantidad a ofertar (minimo $<?php echo $ofertaMinima ?>)"></p>
					<p><input class="campo-formulario" name="email" placeholder="Dirección de e-mail"></p>
					<input class="boton" type="submit" value="Ofertar en subasta">
				</form>
				<?php 
					}
				if (esAdmin()) {
					echo '<p id="subtitulo">Controles administrativos.</p>';
					if ($subOfertable) echo '<p><a href="cerrar-subasta.php?id='.$id.'&semana='.$semana.'" style="color: green">Cerrar subasta.</a></p>';
					else echo '<p><a href="crear-subasta.php?id='.$id.'" style="color: green">Crear subasta.</a></p>';
					echo '<p><a href="modificar-residencia.php?id='.$id.'" style="color: green">Modificar residencia.</a></p>';
					echo '<p><a onclick="confirmarEliminar()" href="#" style="color: red">Eliminar residencia.</a></p>';
				}
				?>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>