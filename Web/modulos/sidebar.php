<span id="subtitulo">Menu</span>
<p><b>Usuario:</b> demo.</p>
<?php 
if (esAdmin()) {
	echo '<p><a href="componentes/admin.php">Desactivar modo administrador</a></p>';
	echo '<p><a href="agregar.php">Agregar una residencia.</a></p>';
	echo '<p><a href=""></a></p>';
} else {
	echo '<p><a href="componentes/admin.php">Activar modo administrador</a></p>';
}
?> 

