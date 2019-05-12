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
			<span id="subtitulo" class="color-hsh"><b><?=$datos_residencia['nombre']?></b></span></br>
			<div class="contenido-pagina">
				<div class="alinear-izquierda" style="width: 45%">
					<img style="width: 300px; height: 225px;" src="componentes/imagen.php?id=<?=$id?>"/>
				</div>
				<div class="alinear-derecha" style="width: 52.5%;">
					<p><span class="color-hsh"><b>Ciudad:</b></span> <?=$datos_residencia['localizacion']?></p>
					<p><span class="color-hsh"><b>Dirección:</b></span> <?=$datos_residencia['calle']?>, <?=$datos_residencia['numero']?></p>
					<?php
					if ($datos_residencia['pisoydepto'] != "NA") {
							echo '<p><span class="color-hsh"><b>Piso y depto:</b></span> ';
							echo $datos_residencia['pisoydepto'];
							echo '</p>';
						}
					?>
					<p><span class="color-hsh"><b>Precio por semana:</b></span> $<?=$datos_residencia['precio']?></p>
				</div>
				<div style="clear: both;"></div>
				<p><span class="color-hsh"><b>Descripción:</b></span> <?=utf8_decode($datos_residencia['descripcion'])?></p>
				<select id="semanas" name="semana" onchange="elegirSemana();">
				<option value="*">Seleccionar semana</option>
				<?php $subastas = ListarSemanas($con, $id, false, $semana); ?>
				</select>
				<?php 
					$subOfertable = false;
					if ($subastas > 0) {
						if ($semana != -1) {
							echo '<p>Esta semana tiene una subasta en curso.';
							$subOfertable = true;
						} else {
							if ($subastas == 1) echo '<p>Esta propiedad tiene 1 subasta en curso.';
							else echo '<p>Esta propiedad tiene '.$subastas.' subastas en curso.';
						}
					} else {
						if ($semana != -1) echo '<p>Esta semana no tiene subasta en curso.';
						else echo '<p>Esta propiedad no tiene subastas en curso.</p>';
					}

					if ($subOfertable) {
				?>
				<?php 
					}
				if (esAdmin()) {
					?>
					<p id="subtitulo">Controles administrativos.</p>
					<p><a href="crear-subasta.php?id=<?=$id?>" style="color: green">Crear subasta.</a></p>
					<p><a href="modificar-residencia.php?id=<?=$id?>" style="color: green">Modificar residencia.</a></p>
					<p><a href="eliminar-residencia.php?id=<?=$id?>" style="color: red">Eliminar residencia.</a></p>
				<?php
				}
				?>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>