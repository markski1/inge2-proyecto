<?php include('componentes/funciones.php') ?>
<?php include('componentes/solo-admin.php') ?>
<!DOCTYPE html>
<html>
<head>

	<title>Home Switch Home</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<script type="text/javascript">
		
		function validar() {

			var nombre = document.getElementById("nom");
			var localizacion = document.getElementById("loc");
			var calle = document.getElementById("calle");
			var numero = document.getElementById("num");
			var pisodepto = document.getElementById("pyd");
			var precio = document.getElementById("precio");
			var descripcion = document.getElementById("desc");

			if(nombre.value.trim()=="" || localizacion.value.trim()=="" || calle.value.trim()=="" ||  numero.value.trim()=="" || precio.value.trim()=="" || descripcion.value.trim()==""){
				alert('Uno o mas campos estan vacios.');
				return false
			}
			if(isNaN(numero.value) || isNaN(precio.value)){
				alert('El numero de calle y el precio deben ser numeros.');
				return false
			}
			return true;

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
			<span id="subtitulo">Agregar una residencia.</span>
			<form class="formulario" method="post" onsubmit="return validar()">
				<table>
					<tr>
						<td style="width: 200px;"><span>Nombre:</span></td><td> <input maxlength="128" class="campo-formulario" placeholder="Breve nombre para la residencia." id="nom"></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Localización:</span></td><td> <input maxlength="64" class="campo-formulario" placeholder="Ciudad y provincia." id="loc"></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Calle:</span></td><td> <input maxlength="64" class="campo-formulario" placeholder="Calle donde se encuentra la propiedad." id="calle"></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Numero:</span></td><td> <input type="number" class="campo-formulario" placeholder="Numero de dirección." id="num"></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Piso y depto:</span></td><td> <input maxlenght="16" class="campo-formulario" placeholder="Dejar vació si no aplica." id="pyd"></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Precio base:</span></td><td> <input type="number" maxlenght="16" class="campo-formulario" placeholder="Precio en pesos." id="precio"></td>
					</tr>
					<tr>
						<td style="width: 200px;"><span>Descripción:</span></td><td> <textarea style="border: 1px solid black; width: 400px; height: 200px; padding: 15px;" placeholder="Descripción de la residencia." id="desc"></textarea></td>
					</tr>
				</table>
				<input class="boton" type="submit" value="Agregar residencia.">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>