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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Switch Home</title>
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
			<p>Para ser premium, es necesario que te acerques a una de nuestras oficinas personalmente.</p>
			<p>
				<?php 
					$sql = mysqli_query($con, "SELECT valor FROM variables WHERE `nombre`='premium'");
					$arregloSql = mysqli_fetch_array($sql);
					echo 'Tendras que proveernos con tu dirección de e-mail y abonar, en efectivo, la cantidad de $'.$arregloSql['valor'].'.';
				?>
			</p>
			<p>El estado Premium se te dara de manera instantanea una vez completado el pago.</p>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>