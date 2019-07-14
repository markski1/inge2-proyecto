<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	if (!$logeado) {
		header('Location: index.php');
		exit;
	}

	$datosUsuario = $sesion->obtenerDatosUsuario();
	$reservas = mysqli_query($con, "SELECT * FROM semanas INNER JOIN residencias ON semanas.residencia=residencias.id WHERE `reservado_por`='".$datosUsuario['email']."'");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Switch Home - Mi perfil</title>
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
			<span id="subtitulo" class="color-hsh"><b><?php echo utf8_decode($datosUsuario['apellido'])?>, <?php echo utf8_decode($datosUsuario['nombre'])?></b></span></br>
			<div class="contenido-pagina">
				<p id="subtitulo">Tus reservas</p>
				<?php 
				setlocale(LC_TIME, "es-AR");
				if (mysqli_num_rows($sql) > 0) {
					$fechaActual = time();
					$fechaSubasta = strtotime("+6 month", $fechaActual);
					echo '<table>
							<tr>
								<td width="300"><b>Residencia</b></td>
								<td width="200"><b>Semana</b></td>';
					echo '<td width="100">--</td>
							</tr>
							<tr><td> </td><td> </td><td> </td><td> </td></tr>';
					while ($listar_residencias = mysqli_fetch_array($sql)) {
						// generar semana y estado
						$fecha = strtotime($listar_residencias['fecha']);
						$semana = date('d', $fecha)." de ".strftime("%B", $fecha);
						// imprimir
						echo '<tr>';
						echo '<td>'.utf8_decode($listar_residencias['nombre']).'</td>';
						echo '<td>'.$semana.'</td>';
						echo '<td><a href="cancelar-reserva.php?id='.$listar_residencias['id'].'">Cancelar reserva</a></td>';
						echo '</tr>';
					}
					echo '</table>';
				} else {
					echo '<p>No tenes semanas reservadas.</p>';
				}
			?>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>