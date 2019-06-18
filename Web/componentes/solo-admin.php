<?php
// Este archivo se tiene que incluir en el tope de todas las paginas que sean solo para administradores. (debajo del include de funciones)
if (!$sesion->esAdmin()) {
	header('Location:index.php?error=1');
	exit;
}
?>