<?php

////////////////////////
// Crea las 52 semanas correspondientes a una residencia en la base de datos.
// No retorna nada.
////////////////////////
function CrearSemanas($con, $id) {
	// Definimos "fecha" como un string que contiene el mes, dia y año actual.
	$fecha = date('M d, Y');
	// Convertimos fecha de string a integer/datetime
	$fecha = strtotime($fecha);
	$fecha = strtotime("next monday", $fecha);
	for ($i=0; $i < 52; $i++) { // por 52 semanas..
		// Se agregan 7 dias a la fecha
		$fecha = strtotime("+7 day", $fecha);
		// Se le da formato YYYY/MM/DD que es la manera que tiene MySQL de guardar fechas
		$fechaDb = date("Y", $fecha)."-".date("m", $fecha)."-".date("d", $fecha);
		// Se agrega a la base de datos
		$agregar = mysqli_query($con, "INSERT INTO semanas (residencia, fecha) VALUES ('".$id."', '".$fechaDb."')");
	}
}

function MostrarSemanasBusqueda($con) {
	// Definimos "fecha" como un string que contiene el mes, dia y año actual.
	setlocale(LC_TIME, "es-AR");
	$fecha = date('M d, Y');
	// Convertimos fecha de string a integer/datetime
	$fecha = strtotime($fecha);
	$fecha = strtotime("next monday", $fecha);
	for ($i=0; $i < 52; $i++) { // por 52 semanas..
		// Se agregan 7 dias a la fecha
		$fecha = strtotime("+7 day", $fecha);
		// Se le da formato YYYY/MM/DD que es la manera que tiene MySQL de guardar fechas
		$fechaDb = date("Y", $fecha)."-".date("m", $fecha)."-".date("d", $fecha);
		// Se imprime
		$comienzoSemana = date('d', $fecha)." de ".strftime("%B", $fecha);
		echo '<option value="'.$fecha.'">'.$comienzoSemana.'</option>';
	}
}

////////////////////////
// Retorna el listado de semanas para una residencia especificada, en un formato de Droplist.
// Retorna otros valores dependiendo de sus parametros
////////////////////////
function ListarSemanas($con, $id, $semana = -1, &$estado) {
	// Seleccionamos el localizador "es-AR" para listar los meses en español
	setlocale(LC_TIME, "es-AR");
	// agarramos todas las semanas de la residencia
	$estado = 0;
	$subCont = 0;
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$id);
	// si se pide validar que este dentro de los 6 meses, establecemos una fecha limite
	$fechaLimite = time();
	$fechaLimite = strtotime("+6 month", $fechaLimite);

	while($listarsemanas = mysqli_fetch_array($sql)){
		// Tomamos la fecha de la base de datos, y la convertimos del formato de fecha SQL al de PHP
		$fecha = strtotime($listarsemanas['fecha']);
		// Hacemos una segunda variable que tenga el final de esa semana (seria el domingo)
		$fechaFin = strtotime("+6 day", $fecha);
		// Creamos un string con como comienza la semana con el formato "dia de mes"
		$comienzoSemana = date('d', $fecha)." de ".strftime("%B", $fecha);
		// Creamos un string con como termina la semana con el formato "dia de mes de año"
		$finSemana = date('d', $fechaFin)." de ".strftime("%B", $fechaFin).date(', Y', $fechaFin);
		// juntamos los dos
		$texto = $comienzoSemana." hasta ".$finSemana;

		// si se pide validar, y la fecha es mayor a 6 meses, se le pone un fondo rojo.
		if ($semana == $listarsemanas['id']) {
			$tex = 'selected="true"';
		} else {
			$tex = '';
		}

		if ($listarsemanas['subasta'] > 0) {
			echo '<option '.$tex.' style="background-color: #33FF1E;" value="'.$listarsemanas['id'].'">'.$texto.'</option>';
			if ($semana != $listarsemanas['id']) {
				$subCont = $listarsemanas['id'];
			}
		} else if ($listarsemanas['reservado'] == 1){
			echo '<option '.$tex.' style="background-color: #FF1308;" value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		} else if ($listarsemanas['hotsale'] == 1){
			echo '<option '.$tex.' style="background-color: #56B7E8;" value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		} else {
			echo '<option '.$tex.' value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		}

		// Devolver estado de semana seleccionada.
		if ($semana == $listarsemanas['id']) {
			if ($listarsemanas['subasta'] > 0) $estado = 1; // En subasta
			else if ($listarsemanas['reservado'] == 1) $estado = 3; // reservado
			else if ($listarsemanas['hotsale'] == 1) $estado = 4; // en hotsale
			else if ($fecha > $fechaLimite) $estado = 2; // Solo premium
		}
	}
	return $subCont;
}

////////////////////////
// Retorna el listado de semanas para una residencia que se pueden poner en hotsale.
// Retorna otros valores dependiendo de sus parametros.
////////////////////////
function ListarSemanasHotsale($con, $id) {
	// Seleccionamos el localizador "es-AR" para listar los meses en español
	setlocale(LC_TIME, "es-AR");
	// agarramos todas las semanas de la residencia
	$estado = 0;
	$subCont = 0;
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$id);
	// si se pide validar que este dentro de los 6 meses, establecemos una fecha limite
	$fechaLimite = time();
	$fechaLimite = strtotime("+5 month +4 week", $fechaLimite);

	while($listarsemanas = mysqli_fetch_array($sql)){
		// Tomamos la fecha de la base de datos, y la convertimos del formato de fecha SQL al de PHP
		$fecha = strtotime($listarsemanas['fecha']);
		// Hacemos una segunda variable que tenga el final de esa semana (seria el domingo)
		$fechaFin = strtotime("+6 day", $fecha);
		// Creamos un string con como comienza la semana con el formato "dia de mes"
		$comienzoSemana = date('d', $fecha)." de ".strftime("%B", $fecha);
		// Creamos un string con como termina la semana con el formato "dia de mes de año"
		$finSemana = date('d', $fechaFin)." de ".strftime("%B", $fechaFin).date(', Y', $fechaFin);
		// juntamos los dos
		$texto = $comienzoSemana." hasta ".$finSemana;

		if ($fecha > $fechaLimite) break;

		if ($listarsemanas['hotsale'] == 1 && $listarsemanas['reservado'] == 0){
			echo '<option style="background-color: #56B7E8;" value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		} else if ($listarsemanas['reservado'] == 1){
			echo '<option '.$tex.' style="background-color: #FF1308;" value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		} else {
			echo '<option value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		}
	}
}

////////////////////////
// Retorna el ID de la semana a la que corresponde crear subasta en la fecha dada.
////////////////////////
function ObtenerSemanaSubastable($con, $residencia) {
	setlocale(LC_TIME, "es-AR");
	// agarramos todas las semanas de la residencia.

	$fechaActual = time();
	$fechaSubasta = strtotime("+6 month", $fechaActual);
	$fechaSubasta = strtotime("-3 day", $fechaSubasta);
	$fechaDb = date("Y", $fechaSubasta)."-".date("m", $fechaSubasta)."-".date("d", $fechaSubasta);
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$residencia." AND fecha >= '".$fechaDb."' LIMIT 1");

	$semanaSubasta = mysqli_fetch_array($sql);
	// Tomamos la fecha de la base de datos, y la convertimos del formato de fecha SQL al de PHP
	$fecha = strtotime($semanaSubasta['fecha']);
	// Hacemos una segunda variable que tenga el final de esa semana (seria el domingo)
	$fechaFin = strtotime("+6 day", $fecha);
	// Creamos un string con como comienza la semana con el formato "dia de mes"
	$comienzoSemana = date('d', $fecha)." de ".strftime("%B", $fecha);
	// Creamos un string con como termina la semana con el formato "dia de mes de año"
	$finSemana = date('d', $fechaFin)." de ".strftime("%B", $fechaFin).date(', Y', $fechaFin);
	// juntamos los dos
	$texto = $comienzoSemana." hasta ".$finSemana;
	echo $texto;
	return $semanaSubasta['id'];
}

////////////////////////
// Retorna la oferta mas alta en una subasta dada. Si no hay ofertas, retorna 0.
////////////////////////
function ObtenerOfertaMasAlta($con, $res, $sem, &$email, &$cantidadOfertas) {
	$sql = mysqli_query($con, "SELECT * FROM subastas WHERE residencia=".$res." AND semana=".$sem." ORDER BY oferta DESC");
	$cantidadOfertas = mysqli_num_rows($sql);
	if ($cantidadOfertas > 0) {
		$datosUltimaOferta = mysqli_fetch_array($sql);
		$email = $datosUltimaOferta['email'];
		return $datosUltimaOferta['oferta'];
	}
	return 0;
}

////////////////////////
// Retorna true o false dependiendo de si una oferta es suficiente para una semana y una subasta dada.
////////////////////////
function EsOfertaValida($con, $sem, $res, $oferta, $base) {
	$sql = mysqli_query($con, "SELECT * FROM subastas WHERE residencia=".$res." AND semana=".$sem." ORDER BY oferta DESC");
	if (mysqli_num_rows($sql) > 0) {
		$datosUltimaOferta = mysqli_fetch_array($sql);
		return $oferta >= ($datosUltimaOferta['oferta']+100);
	} else {
		return $oferta >= $base;
	}
	return false;
}

////////////////////////
// Retorna true o false dependiendo de si una residencia con parametros dados ya existe.
////////////////////////
function ChequearExisteResidencia($con, $nombre, $ciudad, $calle, $numero) {
	$sql = mysqli_query($con, "SELECT * FROM residencias WHERE nombre='".$nombre."' AND localizacion='".$ciudad."' AND calle='".$calle."' AND numero='".$numero."' LIMIT 1");
	if (mysqli_num_rows($sql) == 0) {
		return false;
	}
	return true;
}

////////////////////////
// Retorna un texto que especifica quien reservo una semana de una residencia dada, y a cuanto.
////////////////////////
function ObtenerInfoReserva($con, $residencia, $semana) {
	$sql = mysqli_query($con, "SELECT reservado_por, reservado_precio FROM semanas WHERE residencia=".$residencia." AND id=".$semana);
	if ($sql) {
		$infoReserva = mysqli_fetch_array($sql);
		if ($infoReserva['reservado_precio'] == -1) {
			return "Reservado por ".$infoReserva['reservado_por'].", a traves de reserva premium.";
		} else if ($infoReserva['reservado_precio'] == -2) {
			return "Reservado por ".$infoReserva['reservado_por'].", a traves de hotsale.";
		} else {
			return "Reservado por ".$infoReserva['reservado_por'].", quien pago $".$infoReserva['reservado_precio']." en subasta.";
		}
	}
	return false;
}

////////////////////////
// Retorna true o false dependiendo de si un ID semana especificado esta reservado o no.
////////////////////////
function ChequearSemanaReservada($con, $semana) {
	$sql = mysqli_query($con, "SELECT reservado FROM semanas WHERE id=".$semana);
	if ($sql) {
		$infoReserva = mysqli_fetch_array($sql);
		if ($infoReserva['reservado'] == 1) {
			return true;
		} else {
			return false;
		}
	}
	return "Error al conectar a la base de datos.";
}

///////////////////////
// Si el segundo parametro es false, retorna un string el cual marca el fin de la subasta de una semana dada.
// Si el segundo parametro es true, retorna un true/false dependiendo de si ya termino o no la subasta.
// Si se pide un string pero la subasta termino, entonces se finaliza la subasta y se envia false.
///////////////////////
function ObtenerFinSubasta($con, $semana, $devolverBool) {
	$sql = mysqli_query($con, "SELECT sub_finaliza FROM semanas WHERE id=".$semana);
	if (!$sql) {
		return false;
	}
	$arregloSql = mysqli_fetch_array($sql);
	$fechaFin = strtotime($arregloSql['sub_finaliza']);
	$fechaActual = time();
	if ($devolverBool){
		if ($fechaActual > $fechaFin) {
			/*CerrarSubasta($con, $semana);*/
			return true;
		} else {
			return false;
		}
	} else {
		if ($fechaActual > $fechaFin) {
			/*CerrarSubasta($con, $semana);*/
			return false;
		} else {
			$textoDevolver = date('d', $fechaFin)." de ".strftime("%B", $fechaFin);
			return $textoDevolver;
		}
	}
}

///////////////////////
// Esta funcion cierra una subasta.
// Retorna un mensaje con información de lo sucedido.
///////////////////////
function CerrarSubasta($con, $semana) {
	// Primero nos aseguramos que dicha semana tenga una subasta en curso, caso contrario retornamos false.
	$sql = mysqli_query($con, "SELECT subasta FROM semanas WHERE id=".$semana);
	$datoSemana = mysqli_fetch_array($sql);
	if ($datoSemana['subasta'] != 1) {
		return false;
	}
	// Los ordenamos de mayor a menor oferta, de esta manera ya tenemos en el tope del vector respuesta a la oferta ganadora.
	$sql = mysqli_query($con, "SELECT * FROM subastas WHERE semana=".$semana." AND semana=".$semana." ORDER BY oferta DESC");
	if ($sql) {
		if (mysqli_num_rows($sql) > 0) {
			$cantidadOfertas = mysqli_num_rows($sql);
			$ofertaGanadora = mysqli_fetch_array($sql);
			$ganador = $ofertaGanadora['email'];
			$ganadorPaga = $ofertaGanadora['oferta'];
			$sql = mysqli_query($con, "UPDATE semanas SET sub_precio_base=0, subasta=0, reservado=1, reservado_por='".$ganador."', reservado_precio='".$ganadorPaga."' WHERE id=".$semana);
			if ($sql) {
				$mensaje = "La subasta se cerro. El ganador fue ".$ganador." con una oferta de $".$ganadorPaga.".";
			} else {
				$mensaje = "La subasta existe y tambien existen ofertas, pero no se pudo cerrar por un error de SQL.";
			}
		} else {
			$sql = mysqli_query($con, "UPDATE semanas SET subasta=0 WHERE id=".$semana);
			$mensaje = "Se cerro la subasta sin ganadores porque nadie oferto.";
		}
	} else {
		$mensaje = "Hubo un error, la base de datos no tomo la consulta.";
	}
	return $mensaje;
}

function ListarResidencias($residencias, $admin) {
	// se vuelca todo en un array llamado listar_residencias, y se hace un while por cada elemento.
	$listados = 0;
	while ($listar_residencias = mysqli_fetch_array($residencias)) {
		if ($admin == false && $listar_residencias['oculto'] == 1) {
			continue;
		}
		// crear divisor y colocar imagen
		echo '<div class="residencia-listado">
				<div class="alinear-izquierda" style="width: 205px; margin-left: 10px;">
					<img src="componentes/imagen.php?id=';
		echo $listar_residencias['id'];
		echo '" style="width: 200px; height: 150px;"/>';
		// fin imagen, se cierra divisor y se crea divisor de info de residencia, ademas de imprimir el nombre.
		echo '</div>
				<div class="alinear-derecha" style="width: 63%; min-width: 370px; padding-top: 10px; padding-left: 14px;">
					<span id="subtitulo" class="color-hsh">';
		echo utf8_decode($listar_residencias['nombre']);
		echo '</span></br>';
		// se lista cada pieza de información
		echo '<p>'.utf8_decode($listar_residencias['localizacion']).'</p>';
		echo '<p>Calle '.utf8_decode($listar_residencias['calle']).', '.$listar_residencias['numero'].'</p>';
		if ($listar_residencias['pisoydepto'] != "NA") {
			echo '<p>'.utf8_decode($listar_residencias['pisoydepto']).'</p>';
		}
		// cerrar divisores y poner el boton de Mas informacion
		echo '</div>
				<div style="clear: both;"></div>
				<div class="residencia-saber-mas"><span><a href="ver-residencia.php?id=';
		echo $listar_residencias['id'];
		echo '" class="no-subrayado">Ver residencia.</a></span></div>
			</div>
		</hr>';
		$listados++;
	}
	if ($listados == 0) {
		echo "<p>No hay residencias cargadas ahora mismo.</p>";
	}
}

function TieneSubasta($con, $id) {
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$id);
	while($listarsemanas = mysqli_fetch_array($sql)){
		if ($listarsemanas['subasta'] > 0) return true;
	}
	return false;
}

function ObtenerInformacionHotsale($con, $semana) {
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE id=".$semana);
	while($listarsemanas = mysqli_fetch_array($sql)){
		if ($listarsemanas['hotsale'] > 0) return $listarsemanas['hotsale_precio'];
	}
	return -1;
}

function ObtenerOfertaMinimaSubasta($con, $res, $semana) {
	$obtenerDatosSubasta = mysqli_query($con, "SELECT * FROM `semanas` WHERE residencia=".$res." AND id=".$semana);
	$listarDatosSubasta = mysqli_fetch_array($obtenerDatosSubasta);
	$email = '';
	$cantidadOfertas = 0;
	$ofertaMasAlta = ObtenerOfertaMasAlta($con, $res, $semana, $email, $cantidadOfertas);
	if ($ofertaMasAlta >= $listarDatosSubasta['sub_precio_base']) {
		$ofertaMinima = $ofertaMasAlta+100;
	} else {
		$ofertaMinima = $listarDatosSubasta['sub_precio_base'];
	}
	return $ofertaMinima;
}

?>