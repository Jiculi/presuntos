export function comprobarForma(form) {
	var mensaje = "Los campos marcados en color rojo son obligatorios";
	var error = 0;
	var frm = document.forms[form];
	var i, ele;

	for(i=0; ele=frm.elements[i]; i++) {
		//elementos += " Nombre = "+ele.name+" | Tipo = "+ele.type+" | Valor = "+ele.value+"\n";

		if((ele.value == ' ' || ele.value == '' || ele.value == 'nada') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
		{
			mensaje += '\n - '+ele.name;	
			document.getElementById(ele.name).style.borderColor = 'red';
			error++;	
		} 		
		if((ele.value != '') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
			{document.getElementById(ele.name).style.borderColor = 'silver';
			}
	}
	if(error != 0) {
			$('#mensaje').text(mensaje);
			$('#ventanita').addClass("alert error");
			//alert(mensaje);
			return false;
	}
	else  {
		return true;
	}
}