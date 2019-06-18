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

function validarRegistro() {
	
	var nombre = document.getElementById("nom");
	var apellido = document.getElementById("ape");
	var email = document.getElementById("email");
	var nac_dia = document.getElementById("nac_dia");
	var nac_mes = document.getElementById("nac_mes");
	var nac_anno = document.getElementById("nac_anno");
	var clave = document.getElementById("clv");
	var cc_marca = document.getElementById("cc_marca");
	var cc_seg = document.getElementById("cc_seg");
	var cc_titular = document.getElementById("cc_titular");
	var cc_num = document.getElementById("cc_num");
	var cc_venc_mes = document.getElementById("cc_venc_mes");
	var cc_venc_anno = document.getElementById("cc_venc_anno");

	if (nombre.value.trim()=="" || apellido.value.trim()=="" || email.value.trim()=="" || nac_dia.value.trim()=="" || nac_mes.value.trim()=="" || nac_anno.value.trim()=="" || clave.value.trim()=="" || cc_marca.value.trim()=="" || cc_seg.value.trim()=="" || cc_titular.value.trim()=="" || cc_num.value.trim()=="" || cc_venc_mes.value.trim()=="" || cc_venc_anno.value.trim()==""){
		alert('Uno o mas campos estan vacios.');
		return false;
	}

	if (isNaN(cc_venc_mes.value) || isNaN(cc_venc_anno.value) || isNaN(nac_dia.value) || isNaN(nac_mes.value) || isNaN(nac_anno.value) || isNaN(cc_seg.value) || isNaN(cc_num.value)) {
		alert('Un valor numerico contiene caracteres no numericos.');
		return false;
	}
	return true;

}

function validarLogin() {

	var email = document.getElementById("nick");
	var clv = document.getElementById("pass");

	if (email.value.trim()=="" || clv.value.trim()=="") {
		alert('Tenes que insertar tu e-mail y clave.');
		return false;
	}

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