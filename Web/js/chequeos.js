function validarResidencia() {

	var nombre = document.getElementById("nom");
	var localizacion = document.getElementById("loc");
	var calle = document.getElementById("calle");
	var numero = document.getElementById("num");
	var pisodepto = document.getElementById("pyd");
	var precio = document.getElementById("precio");
	var descripcion = document.getElementById("desc");

	if(nombre.value.trim()=="" || localizacion.value.trim()=="" || calle.value.trim()=="" ||  numero.value.trim()=="" || precio.value.trim()=="" || descripcion.value.trim()==""){
		alert('Uno o mas campos estan vacios.');
		return false
	}
	if(isNaN(numero.value) || isNaN(precio.value)){
		alert('El numero de calle y el precio deben ser numeros.');
		return false
	}
	return true;

}

function validarResidencia() {

	var precio = document.getElementById("precio");
	var semana = document.getElementById("semana");

	if(isNaN(semana.value) || isNaN(precio.value)){
		alert('Uno de los campos no es valido.');
		return false
	}
	return true;

}