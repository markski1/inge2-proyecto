<?php
include('componentes/funciones-usuarios.php') ;
include('componentes/sql.php');
$con = conectar();

function ImprimirError($error) {
	echo '<link rel="stylesheet" type="text/css" href="estilo.css"><body style="background-color:gray;"><center><h1>Home Switch Home - Error de registro</h1></center><div class="reg-error"><p>Error: '.$error.'</p><p><a href="#" onclick="window.history.back()">Volver</a></p></div></body>';
}

$campos = array('nom', 'ape', 'email', 'nac_dia', 'nac_mes', 'nac_anno', 'clv', 'cc_titular', 'cc_marca', 'cc_seg', 'cc_num', 'cc_venc_mes', 'cc_venc_anno'); 
foreach($campos AS $campo) {
	if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
		ImprimirError("Uno de los campos no fue llenado.");
		exit;
	}
}

// Higienizar entradas

$nombre = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nom'])));
$apellido = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['ape'])));
$email = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['email'])));
$nac_dia = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_dia'])));
$nac_mes = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_mes'])));
$nac_anno = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_anno'])));
$clv = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['clv'])));
$cc_titular = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_titular'])));
$cc_marca = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_marca'])));
$cc_seg = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_seg'])));
$cc_num = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_num'])));
$cc_venc_mes = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_venc_mes'])));
$cc_venc_anno = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_venc_anno'])));

if (strlen($clv) < 6) {
	ImprimirError("La clave es demaciado corta. Debe tener al menos 6 caracteres.");
	exit;
}

if (strlen($cc_seg) != 3) {
	ImprimirError("El codigo de seguridad debe tener 3 caracteres.");
	exit;
}

if (strlen($cc_num) != 16) {
	ImprimirError("El numero de la tarjeta de credito debe tener 16 caracteres.");
	exit;
}

$clv = md5($clv);

if ($nac_dia > 31 || $nac_mes > 12) {
	ImprimirError("La fecha de nacimiento no es valida.");
	exit;
} 

if ($cc_venc_mes > 12) {
	ImprimirError("La fecha de vencimiento de la tarjeta de credito no es valida.");
	exit;
} 

$nacimientofecha = $nac_anno."-".$nac_mes."-".$nac_dia;
$fechacheck = strtotime($nacimientofecha);
$vencimientofecha = $cc_venc_anno."-".$cc_venc_mes."-28";

if (strtotime($vencimientofecha) < time()) {
	ImprimirError("Esa tarjeta de credito ha vencido.");
	exit;
}

if (strtotime("+18 years", $fechacheck) > time()) {
	ImprimirError("Necesitas ser mayor de 18 años para utilizar este servicio.");
	exit;
}

$tokens_upd_fecha = time();
$tokens_upd_fecha = strtotime("+1 year", $tokens_upd_fecha);
$tokens_upd_db = date("Y", $tokens_upd_fecha)."-".date("m", $tokens_upd_fecha)."-".date("d", $tokens_upd_fecha);

if (!ChequearExisteUsuario($con, $email)) {
	$sql = mysqli_query($con, "INSERT INTO usuarios (nombre, apellido, email, nacimiento, clave, cc_titular, cc_marca, cc_segur, cc_numero, cc_vencimiento, tokens_upd) VALUES ('".$nombre."', '".$apellido."', '".$email."','".$nacimientofecha."', '".$clv."', '".$cc_titular."', '".$cc_marca."', '".$cc_seg."', '".$cc_num."', '".$vencimientofecha."', '".$tokens_upd_db."')");
	if ($sql) {
		header('Location: index.php?exito=4');
		exit;
	} 
	else {
		ImprimirError("Hubo un error al registrar la cuenta.");
		exit;
	}
} else {
	ImprimirError("Ya existe una cuenta con esa direccion de e-mail.");
	exit;
}
?>