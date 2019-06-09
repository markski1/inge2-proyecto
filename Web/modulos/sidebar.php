<span id="subtitulo">
	Menu
</span>
<?php
if ($logeado) {
?>
<p>Bienvenido, <?=$_SESSION['nombre']?></p>
<p>
	<?php if ($sesion->esAdmin()) {?>
	<a href="agregar.php">Agregar residencia</a></br>
	<?php } ?>
	<a href="perfil.php">Mi perfil</a></br>
	<a href="modulos/cerrar-sesion.php">Cerrar sesión</a></br>
</p>
<?php
} else {
?>

<form method="POST" action="modulos/login.php" onsubmit="return validarLogin()">
	<p>Iniciar Sesión</p>
	<input placeholder="Dirección de e-mail" type="text" name="nick" id="nick" class="campo-sidebar">
	<input placeholder="Contraseña" type="password" name="pass" id="pass" class="campo-sidebar">
	<input type="submit" value="Iniciar" class="boton-sidebar">
</form>

<p>¿No estas registrado?</p>
<p><a href="registro.php">Crear una cuenta</a></p>

<?php
}
?>