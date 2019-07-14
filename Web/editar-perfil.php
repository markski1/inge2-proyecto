<?php 
	include('componentes/funciones-usuarios.php');
	include('componentes/sql.php');
	$con = conectar();
	$sesion = new sesion;
	$logeado = $sesion->estaLogeado($con);
	$error = 0;
	include('componentes/funciones-residencia.php');

	if (isset($_GET['editando']) && $_GET['editando'] == 1) {
		$continuar = true;
		$campos = array('nom', 'ape', 'email', 'cc_titular', 'cc_marca', 'cc_seg', 'cc_num'); 
		foreach($campos AS $campo) {
			if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
				MostrarError("Falto llenar un campo obligatorio.");
				$continuar = false;
			}
		}

		if ($continuar) {
			$nombre = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nom'])));
			$apellido = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['ape'])));
			$email = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['email'])));
			$cc_titular = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_titular'])));
			$cc_marca = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_marca'])));
			$cc_seg = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_seg'])));
			$cc_num = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_num'])));

			if (strlen($cc_seg) != 3) {
				MostrarError("Error: La clave de seguridad debe tener 3 caracteres.");
				$continuar = false;
			}

			if (strlen($cc_num) != 16) {
				MostrarError("Error: El numero de tarjeta de credito debe tener 16 caracteres.");
				$continuar = false;
			}
		}

		if ($continuar) {
			// Si se decide cambiar la fecha de nacimiento...
			if ((isset($_POST['nac_dia']) && isset($_POST['nac_mes']) && isset($_POST['nac_anno'])) && (!empty($_POST['nac_dia']) && !empty($_POST['nac_mes']) && !empty($_POST['nac_anno']))) {
				$nac_dia = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_dia'])));
				$nac_mes = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_mes'])));
				$nac_anno = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nac_anno'])));
				if ($nac_dia > 31 || $nac_mes > 12) {
					MostrarError("La fecha de nacimiento no es valida.");
					$continuar = false;
				}
				$nacimientofecha = $nac_anno."-".$nac_mes."-".$nac_dia;
				$nacimientoquery = ", `nacimiento`='".$nacimientofecha."'";;
			} else {
				$nacimientoquery = '';
			}

			// Si se decide cambiar la fecha de vencimiento...
			if ((isset($_POST['cc_venc_mes']) && isset($_POST['cc_venc_anno'])) && (!empty($_POST['cc_venc_mes']) && !empty($_POST['cc_venc_anno']))) {
				$cc_venc_mes = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_venc_mes'])));
				$cc_venc_anno = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['cc_venc_anno'])));
				if ($cc_venc_mes > 12) {
					MostrarError("La fecha de vencimiento no es valida.");
					$continuar = false;
				} else {
					$vencimientofecha = $cc_venc_anno."-".$cc_venc_mes."-28";
					if (strtotime($vencimientofecha) < time()) {
						MostrarError("La tarjeta de credito esta vencida.");
						$continuar = false;
					}
					$vencimientoquery = ", `cc_vencimiento`='".$vencimientofecha."'";
				}
			} else {
				$vencimientoquery = '';
			}

			// Si se decide cambiar la contraseña...
			if (isset($_POST['clv']) && !empty($_POST['clv'])) {
				$clv = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['clv'])));
				if (strlen($clv) < 6) {
					MostrarError("La clave debe tener al menos 6 caracteres.");
					$continuar = false;
				}
				$clavequery = ", `clave`='".md5($clv)."'";
			} else {
				$clavequery = '';
			}
		}

		if ($continuar) {
			if (ChequearExisteUsuario($con, $email, $_SESSION['id'])) {
				MostrarError("Ese e-mail ya esta en uso.");
				$continuar = false;
			}
		}

		if ($continuar) {
			$sql = mysqli_query($con, "UPDATE usuarios SET `nombre`='".$nombre."', `apellido`='".$apellido."', `email`='".$email."', `cc_titular`='".$cc_titular."', `cc_marca`='".$cc_marca."', `cc_segur`='".$cc_seg."', `cc_numero`='".$cc_num."'".$nacimientoquery.$vencimientoquery.$clavequery." WHERE id=".$_SESSION['id']);
			if ($sql) {
				echo '<div class="exito"><p>Perfil actualizado con éxito.</p></div>';
			} else {
				MostrarError("Error al almacenar los datos.");
			}
		}
	}

	$datosUsuario = $sesion->obtenerDatosUsuario();
	$fechaNacimiento = strtotime($datosUsuario['nacimiento']);
	$nacimiento_dia = date('d', $fechaNacimiento);
	$nacimiento_mes = date('n', $fechaNacimiento);
	$nacimiento_anno = date('Y', $fechaNacimiento);
	$fechaVencimiento = strtotime($datosUsuario['cc_vencimiento']);
	$vencimiento_mes = date('n', $fechaVencimiento);
	$vencimiento_anno = date('Y', $fechaVencimiento);
?>
<!DOCTYPE html>
<html>
<head>

	<title>Home Switch Home - Editando perfil</title>
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
			<span id="subtitulo">Editar perfil.</span>
			<form class="formulario" method="post" action="editar-perfil.php?editando=1">
				<span>&nbsp;</span>
				<center><p id="subtitulo">Información personal</p></center>
				<span>&nbsp;</span>
				<table>
					<tr>
						<td style="width: 200px;">
							<span>Nombre:</span>
						</td>
						<td>
							<input maxlength="32" value="<?php echo utf8_decode($datosUsuario['nombre']); ?>" name="nom" class="campo-formulario" id="nom">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Apellido:</span>
						</td>
						<td>
							<input maxlength="64" value="<?php echo utf8_decode($datosUsuario['apellido']); ?>" name="ape" class="campo-formulario" id="ape">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>E-Mail:</span></td>
						<td>
							<input maxlength="64" value="<?php echo utf8_decode($datosUsuario['email']); ?>" name="email" class="campo-formulario" id="email">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Fecha de Nacimiento:</span></td>
						<td>
							<input maxlenght="2" placeholder="Dia" value="<?php echo $nacimiento_dia;?>" style="width: 80px;" name="nac_dia" type="number" class="campo-formulario" id="nac_dia">
							<input maxlenght="2" placeholder="Mes" value="<?php echo $nacimiento_mes;?>" style="width: 80px;" name="nac_mes" type="number" class="campo-formulario" id="nac_mes">
							<input maxlenght="4" placeholder="Año" value="<?php echo $nacimiento_anno;?>" style="width: 150px;" name="nac_anno" type="number" class="campo-formulario" id="nac_anno">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Contraseña:</span></td>
						<td>
							<input name="clv" type="password" class="campo-formulario" placeholder="Dejar vacio para no cambiar." id="clv">
						</td>
					</tr>
				</table>
				<span>&nbsp;</span>
				<center><p id="subtitulo">Información de Tarjeta de Credito</p></center>
				<span>&nbsp;</span>
				<table>
					<tr>
						<td style="width: 200px;">
							<span>Marca:</span>
						</td>
						<td>
							<input maxlenght="16" value="<?php echo utf8_decode($datosUsuario['cc_marca']); ?>" name="cc_marca" class="campo-formulario" id="cc_marca">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Numero:</span>
						</td>
						<td>
							<input type="number" value="<?php echo utf8_decode($datosUsuario['cc_numero']); ?>" maxlenght="16" placeholder="16 caracteres" name="cc_num" class="campo-formulario" id="cc_num">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Código de seguridad:</span>
						</td>
						<td>
							<input type="number" value="<?php echo utf8_decode($datosUsuario['cc_segur']); ?>" maxlenght="16" placeholder="3 caracteres" name="cc_seg" class="campo-formulario" id="cc_seg">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Nombre de Titular:</span>
						</td>
						<td>
							<input maxlenght="16" value="<?php echo utf8_decode($datosUsuario['cc_titular']); ?>" name="cc_titular" class="campo-formulario" id="cc_titular">
						</td>
					</tr>
					<tr>
						<td style="width: 200px;">
							<span>Fecha de vencimiento:</br></span>
						</td>
						<td>
							<input maxlenght="2" value="<?php echo $vencimiento_mes;?>" placeholder="Mes" style="width: 110px;" name="cc_venc_mes" type="number" class="campo-formulario" id="cc_venc_mes">
							<input maxlenght="4" value="<?php echo $vencimiento_anno;?>" placeholder="Año" style="width: 245px;" name="cc_venc_anno" type="number" class="campo-formulario" id="cc_venc_anno">
						</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<input class="boton" type="submit" value="Actualizar perfil">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="footer">
		<?php include('modulos/footer.php') ?>
	</div>
</body>
</html>