<?php

setlocale(LC_TIME, "es-AR");

$date = date('M d, Y');
$date = strtotime($date);
for ($i=0; $i < 52; $i++) { 
	$date = strtotime("+7 day", $date);
	$dateAux = strtotime("+6 day", $date);
	echo date('d', $date);
	echo " de ";
	echo strftime("%B", $date);
	echo " hasta ";
	echo date('d', $dateAux);
	echo " de ";
	echo strftime("%B", $dateAux);
	echo date(', Y', $dateAux);
	echo "</p>";
}

?>