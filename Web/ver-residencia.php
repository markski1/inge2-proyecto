<?php include('componentes/funciones.php') ?>
<?php 
	include('componentes/sql.php');
	$con = conectar();

	$id = mysqli_real_escape_string($con, $_GET['id']);

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
			<span id="subtitulo" class="color-hsh"><b><?=$datos_residencia['nombre']?></b></span></br>
			<div class="contenido-pagina">
				<div class="alinear-izquierda" style="width: 45%">
					<img style="width: 300px; height: 225px;" src="componentes/imagen.php?id=<?=$id?>"/>
				</div>
				<div class="alinear-derecha" style="width: 52.5%;">
					<p><span class="color-hsh"><b>Ciudad:</b></span> <?=$datos_residencia['localizacion']?></p>
					<p><span class="color-hsh"><b>Dirección:</b></span> <?=$datos_residencia['calle']?>, <?=$datos_residencia['numero']?></p>
					<p><span class="color-hsh"><b>Piso y depto:</b></span> <?=$datos_residencia['pisoydepto']?></p>
					<p><span class="color-hsh"><b>Precio por semana:</b></span> $<?=$datos_residencia['precio']?></p>
				</div>
				<div style="clear: both;"></div>
				<p><span class="color-hsh"><b>Descripción:</b></span> <?=utf8_decode($datos_residencia['descripcion'])?></p>
				<?php 
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