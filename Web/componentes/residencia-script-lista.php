<?php
	// se vuelca todo en un array llamado listar_residencias, y se hace un while por cada elemento.
	while($listar_residencias = mysqli_fetch_array($residencias)){
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
		echo $listar_residencias['nombre'];
		echo '</span></br>';
		// se lista cada pieza de información
		echo '<p>'.$listar_residencias['localizacion'].'</p>';
		echo '<p>'.$listar_residencias['calle'].', '.$listar_residencias['numero'].'</p>';
		echo '<p>'.$listar_residencias['pisoydepto'].'</p>';
		echo '<p>$'.$listar_residencias['precio'].'</p>';
		// cerrar divisores y poner el boton de Mas informacion
		echo '</div>
				<div style="clear: both;"></div>
				<div class="residencia-saber-mas"><span><a href="ver-residencia.php?id=';
		echo $listar_residencias['id'];
		echo '" class="no-subrayado">Ver residencia.</a></span></div>
			</div>
		</hr>';
	}
?>