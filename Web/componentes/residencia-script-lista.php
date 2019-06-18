<?php
	// se vuelca todo en un array llamado listar_residencias, y se hace un while por cada elemento.
	$listados = 0;
	while($listar_residencias = mysqli_fetch_array($residencias)){
		if ($listar_residencias['oculto'] == 1) {
			continue;
		}
		// crear divisor y colocar imagen
		echo '<div class="residencia-listado">
				<div class="alinear-izquierda" style="width: 205px; margin-left: 10px;">
					<img src="componentes/imagen.php?id=';
		echo $listar_residencias['id'];
		echo '" style="width: 200px; height: 150px;"/>';
		// fin imagen, se cierra divisor y se crea divisor de info de residencia, ademas de imprimir el nombre.
		echo '</div>
				<div class="alinear-derecha" style="width: 63%; min-width: 370px; padding-top: 10px; padding-left: 14px;">
					<span id="subtitulo" class="color-hsh">';
		echo utf8_decode($listar_residencias['nombre']);
		echo '</span></br>';
		// se lista cada pieza de información
		echo '<p>'.utf8_decode($listar_residencias['localizacion']).'</p>';
		echo '<p>Calle '.utf8_decode($listar_residencias['calle']).', '.$listar_residencias['numero'].'</p>';
		if ($listar_residencias['pisoydepto'] != "NA") {
			echo '<p>'.utf8_decode($listar_residencias['pisoydepto']).'</p>';
		}
		// cerrar divisores y poner el boton de Mas informacion
		echo '</div>
				<div style="clear: both;"></div>
				<div class="residencia-saber-mas"><span><a href="ver-residencia.php?id=';
		echo $listar_residencias['id'];
		echo '" class="no-subrayado">Ver residencia.</a></span></div>
			</div>
		</hr>';
		$listados++;
	}
	if ($listados == 0) {
		echo "<p>No hay residencias cargadas ahora mismo.</p>";
	}
?>