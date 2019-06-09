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
			$_SESSION['email'] = $datosuser['email'];;
			return true;
		}else{
			return false;
			exit;
		}
	}
	function cerrarSesion() {
		session_start();
		// si la sesion esta seteada se realiza, si no, se avisa.
	    if(isset($_SESSION['id'])) {
	        session_destroy();
	        session_unset();
	        header("Location: index.php");
	    }else {
	        echo "Para cerrar sesion estaria bueno que la inicies.";
	    }
	}
	function estaLogeado() {
		session_start();
		// si la sesion esta seteada retorna true, si no, false.
		if(isset($_SESSION['id'])){
			return true;
		}else{
			return false;
		}
	}
}



////////////////////////
// Retorna true o false dependiendo de si un e-mail ya esta registrado
////////////////////////
function ChequearExisteUsuario($con, $email) {
	$sql = mysqli_query($con, "SELECT * FROM usuarios WHERE e-mail='".$email);
	if (mysqli_num_rows($sql) == 0) {
		return false;
	}
	return true;
}

function esAdmin() {
	if (!isset($_COOKIE['admin'])) {
		return false;
	}
	return true;
}

?>