<?php

class sesion{
	function iniciarSesion($usuario, $clave) {
		// se crea una nueva conexion sql porque es necesario en esta funcion, el require no la pasa por alguna razón
		$coneccion = conectar();
		// $usuario y $clave se buscan en la SQL, si hay resultados, se hace el login, si no, retorna false
		$sql = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE email='".$usuario."' AND clave='".$clave."'");
		if($datosuser = mysqli_fetch_array($sql)){
			session_start();
			$_SESSION['id'] = $datosuser['id'];
			$_SESSION['nombre'] = $datosuser['nombre'];
			$_SESSION['email'] = $datosuser['email'];
			return true;
		}else{
			return false;
			exit;
		}
	}
	function cerrarSesion() {
		session_start();
	    if(isset($_SESSION['id'])) {
	        session_destroy();
	        session_unset();
	        header("Location: index.php");
	    } else {
	        header("Location: index.php");
	    }
	}
	function estaLogeado($con) {
		session_start();
		// si la sesion esta seteada retorna true, si no, false.
		if(isset($_SESSION['id'])){
			// Chequear los tokens del usuario, actualizarlos en caso de estar vencido
			$sql = mysqli_query($con, "SELECT tokens_upd FROM usuarios WHERE id=".$_SESSION['id']);
			$chequeo = mysqli_fetch_array($sql);
			if (strtotime($chequeo['tokens_upd']) < time()) {
				$tokens_upd_fecha = time();
				$tokens_upd_fecha = strtotime("+1 year", $tokens_upd_fecha);
				$tokens_upd_db = date("Y", $tokens_upd_fecha)."-".date("m", $tokens_upd_fecha)."-".date("d", $tokens_upd_fecha);
				mysqli_query($con, "UPDATE usuarios SET `tokens`='2', `tokens_upd`='".$tokens_upd_db."'");
			}
			return true;
		} else {
			return false;
		}
	}
	function obtenerDatosUsuario() {
		$con = conectar();
		$sql = mysqli_query($con, "SELECT * FROM usuarios WHERE id=".$_SESSION['id']);
		$retorno = mysqli_fetch_array($sql);
		return $retorno;
	}
	function esAdmin() {
		if(!isset($_SESSION['id'])) {
			return false;
		}
		$con = conectar();
		$sql = mysqli_query($con, "SELECT rango FROM usuarios WHERE id=".$_SESSION['id']);
		$resultado = mysqli_fetch_array($sql);
		if ($resultado['rango'] == 2) {
			return true;
		} else {
			return false;
		}
	}
	function esPremium() {
		if(!isset($_SESSION['id'])) {
			return false;
		}
		$con = conectar();
		$sql = mysqli_query($con, "SELECT rango FROM usuarios WHERE id=".$_SESSION['id']);
		$resultado = mysqli_fetch_array($sql);
		if ($resultado['rango'] >= 1) {
			return true;
		} else {
			return false;
		}
	}
}



////////////////////////
// Retorna true o false dependiendo de si un e-mail ya esta registrado
////////////////////////
function ChequearExisteUsuario($con, $email) {
	$sql = mysqli_query($con, "SELECT * FROM usuarios WHERE email='".$email."'");
	if (mysqli_num_rows($sql) > 0) {
		return true;
	}
	return false;
}

function ImprimirTipoUsuario($datosUsuario) {
	switch ($datosUsuario['rango']) {
		case 1:
			return 'Premium';
			break;

		case 2:
			return 'Administrador';
			break;
		
		default:
			return 'Basico';
			break;
	}
}

function ObtenerDatosUsuarioPorID($id) {
	$con = conectar();
	$sql = mysqli_query($con, "SELECT * FROM usuarios WHERE id=".$id);
	$retorno = mysqli_fetch_array($sql);
	return $retorno;
}

function MostrarError($error) {
	echo '<div class="error"><p>'.$error.'</p></div>';
}
?>