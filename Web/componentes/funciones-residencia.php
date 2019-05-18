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
		$fechaDb = date("Y" ,$fecha)."-".date("m" ,$fecha)."-".date("d" ,$fecha);
		// Se agrega a la base de datos
		$agregar = mysqli_query($con, "INSERT INTO semanas (residencia, fecha) VALUES ('".$id."', '".$fechaDb."')");
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
		} else {
			echo '<option '.$tex.' value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		}

		// Devolver estado de semana seleccionada.
		if ($semana == $listarsemanas['id']) {
			if ($listarsemanas['subasta'] > 0) $estado = 1; // En subasta
			if ($fecha > $fechaLimite) $estado = 2; // Solo premium
			if ($listarsemanas['reservado'] == 1) $estado = 3; // reservado
		}
	}
	return $subCont;
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
	$fechaDb = date("Y" ,$fechaSubasta)."-".date("m" ,$fechaSubasta)."-".date("d" ,$fechaSubasta);
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
		return "Reservado por ".$infoReserva['reservado_por'].", quien pago $".$infoReserva['reservado_precio'];
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