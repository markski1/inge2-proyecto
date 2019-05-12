<?php 
	include('componentes/funciones-usuarios.php') ;
	include('componentes/sql.php');
	$con = conectar();
	$error = 0;
	include('componentes/funciones-residencia.php');
	include('componentes/solo-admin.php');
	if (isset($_GET['error'])) {
		switch ($_GET['error']) {
			case 1:
				echo "<div class='error'><p>ERROR: Uno o mas campos no fueron correctamente llenados.</p></div>";
				break;
		}
	}
	if (isset($_GET['agregando']) && $_GET['agregando'] == 1) {
		$error = 0;

		// Chequear que los campos esten llenos
		$campos = array('nom', 'loc', 'cal', 'num', 'prec', 'desc'); 
		foreach($campos AS $campo) {
			if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
				$error = 1;
			}
		}

		if(!isset($_POST['pyd']) || empty($_POST['pyd'])) {
			$pyd = 'NA';
		}

		// Chequear que numero y precio sean numeros.
		if(!filter_var($_POST['num'], FILTER_VALIDATE_INT) || !filter_var($_POST['prec'], FILTER_VALIDATE_INT)){
			$error = 2;
		}

		// Chequear que se suba una imagen.
		if (!isset($_FILES['imagen']['size']) || $_FILES['imagen']['size'] == 0){
			$error = 3;
		}

		// Chequear que la imagen no pese mas de 2mb
		if ($_FILES['imagen']['size'] > 2000000){
			$error = 4;
		}

		switch ($_FILES['imagen']['type'] ) {
		    case "image/jpeg": $tipo="jpg"; break;
		    $error = 4;
		}

		// Higienizar todas las entradas.
		$nom = htmlspecialchars(mysqli_real_escape_string($con, $_POST['nom']));
		$loc = htmlspecialchars(mysqli_real_escape_string($con, $_POST['loc']));
		$cal = htmlspecialchars(mysqli_real_escape_string($con, $_POST['cal']));
		$num = htmlspecialchars(mysqli_real_escape_string($con, $_POST['num']));
		if (!isset($pyd)) {
			$pyd = htmlspecialchars(mysqli_real_escape_string($con, $_POST['pyd']));
		}
		$prec = htmlspecialchars(mysqli_real_escape_string($con, $_POST['prec']));
		$desc = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['desc'])));

		if ($error != 0) {
			switch ($error) {
				case 1:
					echo "<div class='error'><p>Error: Uno o mas campos están vacios.</p></div>";
					break;
				case 2:
					echo "<div class='error'><p>Error: Numero y precio no pueden tener letras.</p></div>";
					break;
				case 3:
					echo "<div class='error'><p>Error: No se incluyo imagen, o el archivo subido es nulo.</p></div>";
					break;
				case 4:
					echo "<div class='error'><p>Error: La imagen subida no es valida.</p></div>";
					break;
			}
		} else {
			// addslashes se utiliza para convertir la imagen en binario y asi levantarla a la DB
			$foto = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
			// se envian los datos a la base de datos, si se sube te avisa y si no tambien.
			$sql = mysqli_query($con, "INSERT INTO residencias (nombre, localizacion, calle, numero, pisoydepto, precio, imagen, descripcion) VALUES ('".$nom."', '".$loc."', '".$cal."','".$num."', '".$pyd."', '".$prec."', '".$foto."', '".$desc."')");
			if ($sql) {
				echo '<div class="exito"><p>Residencia agregada con exito.</p></div>';
				$idNuevaResidencia = mysqli_insert_id($con);
				CrearSemanas($con, $idNuevaResidencia);
			} 
			else echo '<div class="error"><p>Error al agregar residencia.</p></div>';

		}

	}
?>
<!DOCTYPE html>
<html>
<head>

	<title>Home Switch Home - Agregando residencia</title>
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
			<span id="subtitulo">Agregar una residencia.</span>
			<form class="formulario" enctype="multipart/form-data" method="post" action="agregar.php?agregando=1" onsubmit="return validarResidencia()">
				<table>
					<tr>
						<td style="width: 200px;">
							<span>Nombre:</span>
						</td>
						<td>
							<input maxlength="128" name="nom" class="campo-formulario" placeholder="Breve nombre para la residencia." id="nom" value="<?php if($error > 0 && isset($nom)) echo $nom ?>">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Localización:</span>
						</td>
						<td>
							<input maxlength="64" name="loc"class="campo-formulario" placeholder="Ciudad y provincia." id="loc" value="<?php if($error > 0 && isset($loc)) echo $loc ?>">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Calle:</span></td>
						<td>
							<input maxlength="64" name="cal" class="campo-formulario" placeholder="Calle donde se encuentra la propiedad." id="calle" value="<?php if($error > 0 && isset($cal)) echo $cal ?>">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Numero:</span></td>
						<td>
							<input maxlenght="5" name="num" type="number" class="campo-formulario" placeholder="Numero de dirección." id="num" value="<?php if($error > 0 && isset($num)) echo $num ?>">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Piso y depto:</span></td>
						<td>
							<input maxlenght="16" name="pyd" class="campo-formulario" placeholder="Dejar vació si no aplica." id="pyd" value="<?php if($error > 0 && isset($pyd)) echo $pyd ?>">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Precio base:</span>
						</td>
						<td>
							<input type="number" maxlenght="16" name="prec" class="campo-formulario" placeholder="Precio en pesos." id="precio" value="<?php if($error > 0 && isset($prec)) echo $prec ?>">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Imagen: (JPG, Max 2mb)</span>
						</td>
						<td>
							<input class="botonregistro" name="imagen" style="width: auto;" type="file">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Descripción:</span></td>
							<td>
								<textarea name="desc" style="border: 1px solid black; width: 400px; height: 200px; padding: 15px;" placeholder="Descripción de la residencia." id="desc"><?php if($error > 0 && isset($desc)) echo $desc ?></textarea>
							</td>
					</tr>
				</table>
				<input class="boton" type="submit" value="Agregar residencia.">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>