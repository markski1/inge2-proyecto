<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	if ($logeado) $datosUsuario = $sesion->obtenerDatosUsuario();
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

    if($logeado && isset($_GET['ofertar']) && $_GET['ofertar'] == 1) {
    	$datosUsuario = $sesion->obtenerDatosUsuario();
    	if ($semana != -1){
	    	$oferta = htmlspecialchars(mysqli_real_escape_string($con, $_POST['oferta']));
	    	$obtenerSubastaAOfertar = mysqli_query($con, "SELECT * FROM semanas WHERE id=".$semana);
	    	$datosSubastaOfertar = mysqli_fetch_array($obtenerSubastaAOfertar);
 	    	if (EsOfertaValida($con, $semana, $id, $oferta, $datosSubastaOfertar['sub_precio_base'])) {
    			$agregarOferta = mysqli_query($con, "INSERT INTO subastas (residencia, semana, email, oferta) VALUES ('".$id."', '".$semana."', '".$datosUsuario['email']."', '".$oferta."')");
    			if ($agregarOferta) {
    				echo '<div class="exito"><p>Has ofertado con exito.</p></div>';
    			} else {
    				MostrarError("Error al crear oferta.");
    			}
	    	} else {
	    		MostrarError("Su oferta no es lo suficientemente alta.");
	    	}
    	} else {
    		MostrarError("Error desconocido.");
    	}
    }

    if (isset($_GET['reservahecha']) && $_GET['reservahecha'] == 1) {
    	echo "<div class='exito'><p>Reservado con éxito.</p></div>";
    }

    if (isset($_GET['error'])) {
    	switch ($_GET['error']) {
    		case 1:
    			MostrarError("Semana invalida.");
    			break;
    		
    		case 2:
    			MostrarError("Error al eliminar hotsale.");
    			break;
    	}
    } else if (isset($_GET['exito'])) {
    	switch ($_GET['exito']) {
    		case 1:
    			echo '<div class="exito"><p>Hotsale eliminado exitosamente.</p></div>';
    			break;
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
			var confirmacion=confirm("¿Seguro que queres eliminar esta residencia?");
			if (confirmacion) {
				window.location = "eliminar-residencia.php?id=<?php echo $id ?>";
			}
		}
		function confirmarOcultar() {
			var confirmacion=confirm("¿Seguro que queres ocultar esta residencia?");
			if (confirmacion) {
				window.location = "ocultar-residencia.php?id=<?php echo $id ?>";
			}
		}
		function confirmarReservar() {
			var confirmacion=confirm("¿Seguro que queres reservar esta semana premium?");
			if (confirmacion) {
				window.location = "hacer-reserva-premium.php?id=<?php echo $id ?>&semana=<?php echo $semana ?>";
			}
		}
		function confirmarReservarHotsale() {
			var confirmacion=confirm("¿Seguro que queres reservar esta semana hotsale?");
			if (confirmacion) {
				window.location = "hacer-reserva-hotsale.php?id=<?php echo $id ?>&semana=<?php echo $semana ?>";
			}
		}
		function confirmarEliminarHotsale() {
			var confirmacion=confirm("¿Seguro que queres eliminar este hotsale?");
			if (confirmacion) {
				window.location = "eliminar-hotsale.php?id=<?php echo $id ?>&semana=<?php echo $semana?>";
			}
		}
		function confirmarCancelar(residencia) {
			var confirmacion=confirm("¿Seguro que queres cancelar esta reserva? No vas a recuperar tu token, y la acción no se podra revertir.");
			if (confirmacion) {
				var inicio = "cancelar-reserva.php?id=";
				var direccion = inicio.concat(residencia);
				window.location = direccion;
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
				</div>
				<div style="clear: both;"></div>
				<p><span class="color-hsh"><b>Descripción:</b></span> <?php echo utf8_decode($datos_residencia['descripcion'])?></p>
				<?php
					if (!$logeado) {
						echo '<p>Para ver las semanas y opciones, es necesario que estes registrado en el sistema.</p>';
					} else {
				?>
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
							if (!$sesion->esPremium()) {
								echo '<p>Esta semana solo puede ser reservada por un usuario premium.</p>';
							} else {
								if ($datosUsuario['tokens'] == 0) {
									echo '<p>No es posible ofertar en esta semana debido a que no te quedan creditos.</p>';
								} else {
									echo '<p>Esta semana es premium. <a onclick="confirmarReservar()" href="#">Reservar</a></p>';
								}
							}
							break;

						case 3:
							if (ObtenerEmailReserva($con, $id, $semana) == $datosUsuario['email']) {
								echo '<p>Has reservado esta semana. <a href="#" onclick="confirmarCancelar('.$semana.')">Cancelar reserva</a></p>';
							} else {
								echo '<p>Esta semana ya esta reservada.</p>';
							}
							if ($sesion->esAdmin()) {
								echo ObtenerInfoReserva($con, $id, $semana);
							}
							break;

						case 4:
							echo '<p>Esta semana esta en hotsale. Tiene un precio de $'.ObtenerInformacionHotsale($con, $semana).'. - <a onclick="confirmarReservarHotsale()" href="#">Reservar</a></p>';
							break;
						
						default:
							if ($semana == -1) {
								if ($subastas > 0) {
									echo '<p>Esta residencia tiene una subasta en curso. <a href="./ver-residencia.php?id='.$id.'&semana='.$subastas.'">Ir a subasta.</a></p>';
								} else {
									echo '<p>Esta residencia no tiene subastas en curso.</p>';
								}
							} else {
								echo '<p>Esta semana ya paso su etapa premium, y no puede ser reservada.</p>';
							}
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
				<?php 
					$finSubasta = ObtenerFinSubasta($con, $semana, false);
				?>
				<p>El precio base es de $<?php echo $listarDatosSubasta['sub_precio_base'] ?></p>
				<p>La subasta finaliza el <?php echo $finSubasta ?></p>
				<?php 
					if ($ofertaMasAlta == 0) echo '<p>Nadie ha ofertado aun por esta propiedad.</p>';
					else if ($sesion->esAdmin()) echo '<p>La oferta mas alta es de '.$ofertaMasAlta.' por '.$email.'</p>';
					else echo '<p>La oferta mas alta es de '.$ofertaMasAlta.'.</p>';
				?>
				<form method="post" action="ver-residencia.php?id=<?php echo $id?>&semana=<?php echo $semana?>&ofertar=1">
					<p><input class="campo-formulario" name="oferta" type="number" placeholder="Cantidad a ofertar (minimo $<?php echo $ofertaMinima ?>)"></p>
					<input class="boton" type="submit" value="Ofertar en subasta">
				</form>
				<?php 
					}
				}
				if ($sesion->esAdmin()) {
					echo '<p id="subtitulo">Controles administrativos.</p>';
					if ($subOfertable) echo '<p><a href="cerrar-subasta.php?id='.$id.'&semana='.$semana.'" style="color: red">Cerrar subasta.</a></p>';
					else echo '<p><a href="crear-subasta.php?id='.$id.'" style="color: green">Crear subasta.</a></p>';
					echo '<p><a href="modificar-residencia.php?id='.$id.'" style="color: green">Modificar residencia.</a></p>';
					if ($estado == 4) {
						echo '<p><a style="color: green" href="modificar-hotsale.php?id='.$id.'&semana='.$semana.'">Modificar hotsale.</p>';
						echo '<p><a style="color: red" onclick="confirmarEliminarHotsale()" href="#">Eliminar hotsale.</p>';
					} else {
						echo '<p><a href="crear-hotsale.php?id='.$id.'" style="color: green">Crear hotsale</p>';
					}
					if ($datos_residencia['oculto'] == 1) echo '<p><a href="mostrar-residencia.php?id='.$id.'" style="color: green">Mostrar residencia.</a></p>';
					else echo '<p><a onclick="confirmarOcultar()" href="#" style="color: red">Ocultar residencia.</a></p>';
					echo '<p><a onclick="confirmarEliminar()" href="#" style="color: red">Eliminar residencia.</a></p>';
				}
				?>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>