<?php

function CrearSemanas($con, $id) {
	// Definimos "fecha" como un string que contiene el mes, dia y año actual.
	$fecha = date('M d, Y');
	// Convertimos fecha de string a integer/datetime
	$fecha = strtotime($fecha);
	for ($i=0; $i < 52; $i++) { // por 52 semanas..
		// Se agregan 7 dias a la fecha
		$fecha = strtotime("+7 day", $fecha);
		// Se le da formato YYYY/MM/DD que es la manera que tiene MySQL de guardar fechas
		$fechaDb = date("Y" ,$fecha)."-".date("m" ,$fecha)."-".date("d" ,$fecha);
		// Se agrega a la base de datos
		$agregar = mysqli_query($con, "INSERT INTO semanas (residencia, fecha) VALUES ('".$id."', '".$fechaDb."')");
	}
}

function ListarSemanas($con, $id, $validar = false, $semana = -1) {
	// Seleccionamos el localizador "es-AR" para listar los meses en español
	setlocale(LC_TIME, "es-AR");
	// agarramos todas las semanas de la residencia
	$subCont = 0;
	$sql = mysqli_query($con, "SELECT * FROM semanas WHERE residencia=".$id);
	// si se pide validar que este dentro de los 6 meses, establecemos una fecha limite
	if ($validar) {
		$fechaLimite = time();
		$fechaLimite = strtotime("+6 month", $fechaLimite);
	}

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
		if ($validar && $fecha > $fechaLimite) {
			echo '<option '.$tex.' style="background-color: #FF1308;" value="'.$listarsemanas['id'].'">'.$texto.'</option>';
		} else {
			if ($listarsemanas['subasta'] > 0) {
				echo '<option '.$tex.' style="background-color: #33FF1E;" value="'.$listarsemanas['id'].'">'.$texto.'</option>';
				if ($semana == -1) {
					$subCont++;
				} else if ($semana == $listarsemanas['id']) {
					$subCont++;
				}
			} else {
				echo '<option '.$tex.' value="'.$listarsemanas['id'].'">'.$texto.'</option>';
			}
		}
	}
	return $subCont;
}

function ObtenerOfertaMasAlta($con, $res, $sem, &$email, &$cantidadOfertas) {
	$sql = mysqli_query($con, "SELECT * FROM subastas WHERE residencia=".$res." AND semana=".$sem." ORDER BY oferta DESC");
	$cantidadOfertas = mysqli_num_rows($sql);
	if ($cantidadOfertas > 0) {
		$datosUltimaOferta = mysqli_fetch_array($sql);
		$email = $datosUltimaOferta['email'];
		return $datosUltimaOferta['oferta'];
	} else {
		return 0;
	}
}