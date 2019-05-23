function validarResidencia() {

	var nombre = document.getElementById("nom");
	var localizacion = document.getElementById("loc");
	var calle = document.getElementById("calle");
	var numero = document.getElementById("num");
	var pisodepto = document.getElementById("pyd");
	var descripcion = document.getElementById("desc");

	if(nombre.value.trim()=="" || localizacion.value.trim()=="" || calle.value.trim()=="" ||  numero.value.trim()=="" || descripcion.value.trim()==""){
		alert('Uno o mas campos estan vacios.');
		return false
	}
	if(isNaN(numero.value)){
		alert('El numero de calle debe ser numero.');
		return false
	}
	return true;

}

function validarCrearSubasta() {

	var precio = document.getElementById("precio");
	var semana = document.getElementById("semana");

	if(isNaN(semana.value) || isNaN(precio.value)){
		alert('Uno de los campos no es valido.');
		return false
	}
	return true;

}