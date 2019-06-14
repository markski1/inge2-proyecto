<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	include('componentes/funciones-residencia.php');
	include('componentes/solo-admin.php');

	$sql = mysqli_query($con, "SELECT * FROM usuarios");
?>
<!DOCTYPE html>
<html>
<head>

	<title>Home Switch Home - Panel Administrativo</title>
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
			<span id="subtitulo">Todos los usuarios.</span></br>
			<span>&nbsp;</span>
			<table>
				<tr>
					<td width="150">Nombre</td>
					<td width="100">Apellido</td>
					<td width="200">E-Mail</td>
					<td width="150">Rango</td>
					<td width="100">--</td>
				</tr>
			<?php 
				while ($listusuarios = mysqli_fetch_array($sql)) {
					echo '<tr>';
					echo '<td>'.$listusuarios['nombre'].'</td>';
					echo '<td>'.$listusuarios['apellido'].'</td>';
					echo '<td>'.$listusuarios['email'].'</td>';
					echo '<td>'.ImprimirTipoUsuario($listusuarios).'</td>';
					echo '<td><a href="perfil-admin.php?id='.$listusuarios['id'].'">Ver más</a></td>';
					echo '</tr>';
				}
			?>
			</table>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>