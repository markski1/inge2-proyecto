<?php

include('../componentes/funciones-usuarios.php') ;
include('../componentes/sql.php');
$con = conectar();

$nombre = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['nick'])));
$clave_get = utf8_encode(htmlspecialchars(mysqli_real_escape_string($con, $_POST['pass'])));

$clave = md5($clave_get);

$usuario = new sesion;
$accionLogeo = $usuario->iniciarSesion($nombre, $clave);

if($accionLogeo){
	header('Location: ../index.php');
}else{
	header('Location: ../index.php?error=5');
}

?>