<?php 

function ImprimirError($error) {
	echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de filtro</h1></center><div class="reg-error"><p>Error: '.$error.'</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
}

if (!isset($_POST['tipo'])) {
	ImprimirError("No se ingresaron rangos validos.");
} else {
	$tipo = $_POST['tipo'];
	if ($tipo > 3 || $tipo < 1) {
		ImprimirError("No se ingresaron rangos validos.");
		exit;
	}
}

// Si no es subasta, chequear rangos
if ($tipo != 2) {
	if (!isset($_POST['desde']) || !isset($_POST['hasta'])) {
		ImprimirError("No se ingresaron rangos validos.");
		exit;
	}
	$desde = $_POST['desde'];
	$hasta = $_POST['hasta'];

	if ($desde > $hasta) {
		Imprimirerror("La fecha de inicio no puede ser mayor a la fecha de fin.");
		exit;
	}

	if ($desde == $hasta) {
		Imprimirerror("La fecha de inicio no puede ser igual a la fecha de fin.");
		exit;
	}

	$hastaLimite = strtotime("-2 month", $hasta);

	if ($hastaLimite > $desde) {
		ImprimirError("El rango no puede ser mayor a 2 meses.");
		exit;
	}

	// Agregamos un par de horas para cada extremo para evitar no encontrar semanas en situaciones limite.

	$desde = strtotime("-1 day", $desde);
	$hasta = strtotime("+1 day", $hasta);

	$desdeDb = date("Y", $desde)."-".date("m", $desde)."-".date("d", $desde);
	$hastaDb = date("Y", $hasta)."-".date("m", $hasta)."-".date("d", $hasta);
}

include('componentes/funciones-residencia.php');
include('componentes/funciones-usuarios.php');
include('componentes/sql.php');
$con = conectar();
$sesion = new sesion;
$logeado = $sesion->estaLogeado($con);
if ($logeado) $datosUsuario = $sesion->obtenerDatosUsuario();

switch ($tipo) {
	// Libre
	case 1:
		$sql = mysqli_query($con, "SELECT semanas.*,residencias.nombre FROM semanas INNER JOIN residencias ON semanas.residencia = residencias.id WHERE fecha > '".$desdeDb."' AND fecha < '".$hastaDb."' AND reservado=0 AND subasta=0 AND hotsale=0 ORDER BY fecha");
		break;

	// Subasta
	case 2:
		$sql = mysqli_query($con, "SELECT semanas.*,residencias.nombre FROM semanas INNER JOIN residencias ON semanas.residencia = residencias.id WHERE subasta=1 ORDER BY fecha");
		break;

	// Hotsale
	case 3:
		$sql = mysqli_query($con, "SELECT semanas.*,residencias.nombre FROM semanas INNER JOIN residencias ON semanas.residencia = residencias.id WHERE fecha > '".$desdeDb."' AND fecha < '".$hastaDb."' AND hotsale=1 ORDER BY fecha");
		break;
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
		<div class="pagina-alt">
			<span id="subtitulo">Resultados.</span>
			<?php 
				setlocale(LC_TIME, "es-AR");
				if (mysqli_num_rows($sql) > 0) {
					$fechaActual = time();
					$fechaSubasta = strtotime("+6 month", $fechaActual);
					echo '<p>Las siguientes residencias tienen semanas que cumplen con tu busqueda.</p>';
					echo '<center>';
					echo '<table>
							<tr>
								<td width="300"><b>Residencia</b></td>
								<td width="200"><b>Semana</b></td>
								<td width="200"><b>Estado</b></td>';
					if ($tipo == 2) {
						echo '<td width="150"><b>Oferta actual</b></td>';
					} else if ($tipo == 3) {
						echo '<td width="150"><b>Precio</b></td>';
					}
					echo '<td width="100">--</td>
							</tr>
							<tr><td> </td><td> </td><td> </td><td> </td></tr>';
					while ($listar_residencias = mysqli_fetch_array($sql)) {
						// generar semana y estado
						$fecha = strtotime($listar_residencias['fecha']);
						$semana = date('d', $fecha)." de ".strftime("%B", $fecha);
						if ($listar_residencias['reservado'] == 1) {
							$estado = '<span style="color:red;">Reservado.</span>';
						} else if ($listar_residencias['hotsale'] == 1) {
							$estado = '<span style="color:blue;">En hotsale.</span>';
						} else if ($listar_residencias['subasta'] == 1) {
							$estado = '<span style="color:green;">En subasta.</span>';
						} else {
							$fecha = strtotime($listar_residencias['fecha']);
							if ($fecha > $fechaSubasta) {
								$estado = '<span style="color:green;">Libre (Reservable premium).</span>';
							} else {
								$estado = '<span style="color:red;">Libre (No reservable).</span>';
							}
						}
						if ($tipo == 2) {
							$extra = '<td>$'.ObtenerOfertaMinimaSubasta($con, $listar_residencias['residencia'], $listar_residencias['id']).'</td>';
						} else if ($tipo == 3) {
							$extra = '<td>$'.$listar_residencias['hotsale_precio'].'</td>';
						} else {
							$extra = '';
						}
						// imprimir
						echo '<tr>';
						echo '<td>'.utf8_decode($listar_residencias['nombre']).'</td>';
						echo '<td>'.$semana.'</td>';
						echo '<td>'.$estado.'</td>';
						echo $extra;
						echo '<td><a href="ver-residencia.php?id='.$listar_residencias['residencia'].'&semana='.$listar_residencias['id'].'">Ver semana</a></td>';
						echo '</tr>';
					}
					echo '</table>';
					echo '</center>';
				} else {
					echo '<p>No hubo resultados.</p>';
				}
			?>
			<p><a href="#" onclick="window.history.back()">Volver a filtrado</a></p>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>