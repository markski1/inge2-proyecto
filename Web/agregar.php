<?php include('componentes/funciones.php') ?>
<?php include('componentes/solo-admin.php') ?>
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
			<span id="subtitulo">Agregar una residencia.</span>
			<form class="formulario" method="post" action="componentes/agregar-residencia.php">
				<table>
					<tr>
						<td style="width: 200px;"><span>Nombre:</span></td><td> <input maxlength="128" class="campo-formulario" placeholder="Breve nombre para la residencia."></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Localización:</span></td><td> <input maxlength="64" class="campo-formulario" placeholder="Ciudad y provincia."></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Calle:</span></td><td> <input maxlength="64" class="campo-formulario" placeholder="Calle donde se encuentra la propiedad."></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Numero:</span></td><td> <input type="number" class="campo-formulario" placeholder="Numero de dirección."></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Piso y depto:</span></td><td> <input maxlenght="16" class="campo-formulario" placeholder="Dejar vació si no aplica."></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Descripción:</span></td><td> <textarea style="border: 1px solid black; width: 400px; height: 200px; padding: 15px;" placeholder="Descripción de la residencia."></textarea></td>
					</tr>
				</table>
				<input class="boton" type="submit" value="Agregar residencia.">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>