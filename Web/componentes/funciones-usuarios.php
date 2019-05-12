<?php

function esAdmin() {
	if (!isset($_COOKIE['admin'])) {
		return false;
	}
	return true;
}

?>