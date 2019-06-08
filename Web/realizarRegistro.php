<?php

$campos = array('nom', 'ape', 'email', 'nac_dia', 'nac_mes', 'nac_anno', 'clv', 'cc_titular', 'cc_marca', 'cc_seg', 'cc_num', 'cc_venc_dia', 'cc_venc_mes', 'cc_venc_anno'); 
foreach($campos AS $campo) {
	if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
		echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de registro</h1></center><div class="reg-error"><p>Error: Uno de los campos no fue llenado.</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
		die();
	}
}

// Higienizar entradas

$nombre = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nombre'])));
$apellido = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['apellido'])));
$email = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['email'])));
$nac_dia = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_dia'])));
$nac_mes = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_mes'])));
$nac_anno = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_anno'])));
$clv = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['clv'])));
$cc_titular = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_titular'])));
$cc_marca = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_marca'])));
$cc_seg = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_seg'])));
$cc_num = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_num'])));
$cc_venc_dia = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_venc_dia'])));
$cc_venc_mes = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_venc_mes'])));
$cc_venc_anno = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_venc_anno'])));

if (strlen($clv) < 6) {
	echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de registro</h1></center><div class="reg-error"><p>Error: La clave es demaciado corta. Debe tener al menos 6 caracteres.</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
		die();
}

if (strlen($cc_seg) != 3) {
	echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de registro</h1></center><div class="reg-error"><p>Error: El codigo de seguridad debe tener 3 caracteres.</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
		die();
}

if (strlen($cc_num) != 16) {
	echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de registro</h1></center><div class="reg-error"><p>Error: El numero de la tarjeta de credito debe tener 16 caracteres.</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
		die();
}

$clv = md5($clv);
?>