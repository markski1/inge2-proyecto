<?php

class sesion{
	function login($usuario, $clave){
		// se crea una nueva conexion sql porque es necesario en esta funcion, el require no la pasa por alguna razón
		$coneccion = conectar();
		mysqli_real_escape_string($usuario);
		md5($clave.strtolower($usuario));
		// $usuario y $clave se buscan en la SQL, si hay resultados, se hace el login, si no, retorna false
		$sql = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE nombreusuario='".$usuario."' AND clave='".$clave."'");
		if($datosuser = mysqli_fetch_array($sql)){
			session_start();
			$_SESSION['id'] = $datosuser['id'];
			$_SESSION['usuario'] = $datosuser['nombreusuario'];
			return true;
		}else{
			return false;
			exit;
		}
	}
	function logout(){
		session_start();
		// si la sesion esta seteada se realiza, si no, se avisa.
	    if(isset($_SESSION['usuario'])) {
	        session_destroy();
	        session_unset();
	        header("Location: index.php");
	    }else {
	        echo "Para cerrar sesion serviria mas que primero la incies.";
	    }
	}
	function logeado(){
		session_start();
		// si la sesion esta seteada retorna true, si no, false.
		if(isset($_SESSION['usuario'])){
			return true;
		}else{
			return false;
		}
	}
}

?>