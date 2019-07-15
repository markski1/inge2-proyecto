<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/funciones-residencia.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Switch Home</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<?php include('js/todo.php') ?>
	<script type="text/javascript">
		function cambiarTipo() {
			var selectoraFecha = document.getElementById("selectora");
			var cajaTipo = document.getElementById("tipo");
			var semanaElegida = cajaTipo.options[cajaTipo.selectedIndex].value;
			switch (semanaElegida) {
				case "1":
					document.getElementById("advertencia").innerHTML = "<small>Consejo: Tenga en cuenta que las semanas libres solo pueden ser reservadas con una anticipacion mayor a 6 meses por usuarios premium.</small>";
					document.getElementById("rango").innerHTML = "<small>No elija un rango mayor a 2 meses.</small>";
					selectoraFecha.removeAttribute("hidden", false);
					break;

				case "2":
					document.getElementById("advertencia").innerHTML = "<small>Las busquedas por subasta no requieren especificar un rango.</small>";
					document.getElementById("rango").innerHTML = "";
					selectoraFecha.setAttribute("hidden", true);
					break;

				case "3":
					document.getElementById("advertencia").innerHTML = "";
					document.getElementById("rango").innerHTML = "<small>No elija un rango mayor a 2 meses.</small>";
					selectoraFecha.removeAttribute("hidden", false);
					break;
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
			<span id="subtitulo">Filtrar residencias por semanas.</span>
			<form action="filtrar.php" method="POST">
				<p>Quiero semanas que esten: <select id="tipo" name="tipo" onchange="cambiarTipo();">
					<option value="1">Libres</option>
					<option value="2">En subasta</option>
					<option value="3">En hotsale</option>
				</select></p>
				<div id="selectora">
					<p>Dentro de el rango (inclusivo): <select name="desde"><?php MostrarSemanasBusqueda($con) ?></select> hasta <select name="hasta"><?php MostrarSemanasBusqueda($con) ?></select></p>
				</div>
				<p id="rango"><small>No elija un rango mayor a 2 meses.</small></p>
				<p id="advertencia"><small>Consejo: Tenga en cuenta que las semanas libres solo pueden ser reservadas con una anticipacion mayor a 6 meses por usuarios premium.</small></p>
				<input type="submit" class="boton" value="Filtrar">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>