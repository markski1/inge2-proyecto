<?php
	// se conecta a la SQL
	include('sql.php');
	$con = conectar();
	// se obtiene la imagen de la SQL y se pone en una variable. Idealmente esto estaria en un cdn o un ec2 en AWS u otro contenedor como la gente, pero como no se pide tal cosa lo metemos en la misma sql y ya esta
	$imagen = mysqli_query($con, 'SELECT imagen FROM residencias WHERE id = '.mysqli_real_escape_string($con, $_GET['id']));
	// se vuelca el contenido y el formato en un array
	$mostrarimagen = mysqli_fetch_array($imagen);
	// Setear JPEG como header.
	header('Content-type: image/jpeg');
	// se muestra la imagen haciendo echo al contenido
	echo $mostrarimagen['imagen'];
?>