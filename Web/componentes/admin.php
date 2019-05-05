<?php
// Archivo para la demo 1: Cambiar entre modo admin o modo usuario.
include('funciones.php');
if (esAdmin()) {
	echo '[DEMO DEBUG] Modo admin desactivado.';
	setcookie('admin', '1', time() - 3600, '/');
} else {
	echo '[DEMO DEBUG] Modo admin activado. Vas a tener acceso admin durante la siguiente hora.';
	setcookie('admin', '1', time() + 3600, '/');
}
?>
<p>Apreta <a href="../index.php">aca</a> para ir a la web.</p>