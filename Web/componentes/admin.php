<?php
// Archivo para la demo 1: Cambiar entre modo admin o modo usuario.
include('funciones-usuarios.php');
if (esAdmin()) {
	setcookie('admin', '1', time() - 3600, '/');
} else {
	setcookie('admin', '1', time() + 3600, '/');
}
header('Location: ../index.php');
?>
