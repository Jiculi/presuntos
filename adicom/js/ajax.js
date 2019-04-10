// JavaScript Document
function objetoAjax()
{
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
//---------------------------------------------------------------------------
//var $ = jQuery.noConflict();
//------------------------------ FUNCION LOGIN -------------------------------
function login()
{
	$.ajax
	({
		beforeSend: function(objeto)
		{
		 $('#r').html('<img src="images/load_bar_black.gif">');
		 //alert('hola');
		},
		complete: function(objeto, exito)
		{
			//alert("Me acabo de completar")
			//if(exito=="success"){ alert("Y con éxito");	}
		},
		type: "POST",
		url: "procesosAjax/ajax_login.php",
		data: "user="+$('#user').val()+"&pass="+$('#pass').val(),
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé");
			//alert("Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			$('#r2').html(datos); 
			if(datos == 'ok') $(location).attr('href','index.php');
			else $('#r').html("<p style='color:white'> <img src='images/excla_red.png '><b> El usuario no existe...!!!</b></p>"); 
		}
	});
}
//--------------------------------------------------------------------------------------
//CONTROL DE SESSION EN JQUERY
var timeSesion;

function inicio() { 
  timeSesion = setTimeout(function() { 
    $(document).ready(function(e) {
    $.ajax({
		url:'procesosAjax/sys_controlaSesion.php',
		type:'POST',
		data:{accion : 1},
		success: function(data){			
			if(data == 1)
			{
				alert("Sesion Caducada");
			        document.location.href='index.html';			   
			}			
		}	
		
	});
});
	},1800000);//fin timeout
}//fin inicio

function reset() {
  clearTimeout(timeSesion);//limpia el timeout para resetear el tiempo desde cero 
  timeSesion = setTimeout(function() { 
    $(document).ready(function(e) {
    $.ajax({
		url:'procesosAjax/sys_controlaSesion.php',
		type:'POST',
		data:{accion : 1},
		success: function(data){			
			if(data == 1)
			{
			   alert("Sesion Caducada");
			   document.location.href='index.html';			   
			}			
		}	
		
	});
});
	},1800000);//fin timeout
}//fin reset
//setTimeout("compruebaNot()",150000);//milisegundos 1000 =  un segundo
//------------------------------ funcion para monedas ----------------------------------
function formatoMoneda(input)
{
	var numero = input.value;
	var id = input.id; 
	
	$.ajax
	({
		beforeSend: function(objeto)
		{ },
		type: "POST",
		url: "procesosAjax/formatoMoneda.php",
		data: {numero:numero},
		success: function(datos)
		{ 
			if(datos == 'error') 
			{
				alert("Introduzca un número");
				$("#"+id+"").val("");
				$("#"+id+"").focus();
			}
			else $("#"+id+"").val(datos);
		}
	});
}

//--------------------------------------------------------------------------------------
//------------------------------ FUNCION NUEVO PRESUNTO -------------------------------
function guardaPresunto()
{
	if(comprobarForm('presunto_NEW'))
	{
		var accion = $('#num_accion').val();
		var usuario = $('#usuarioActual').val();
		var direccion = $('#dirPre').val();
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_presunto.php",
			data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoPresunto="+$('#new_tipoPresunto').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#cargo').val()+"&irregularidad="+$('#new_irregularidad').val()+"&monton="+$('#monton').val()+"&fecha_de_cargo_inicio="+$('#fecha_de_cargo_inicio').val()+ "&fecha_de_cargo_final="+$('#fecha_de_cargo_final').val()+ "&normatividad=" + $('#normatividad').val() +"&fecha_irre="+$('#fecha_irre').val(),
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
			//alert(datos)
				
				//mostrarCuadro(500,800,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&mensaje=Presunto Guardado");
				new mostrarCuadro(500,800,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				//mostrarCuadro(500,110,"Accion "+accion+" | ",50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
			}
		});
	}
}
function guardaPresunto_2()
{
	if(comprobarForm('presunto_NEW'))
	{
		var accion = $('#num_accion').val();
		var usuario = $('#usuarioActual').val();
		var direccion = $('#dirPre').val();
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_presunto.php",
			data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoPresunto="+$('#new_tipoPresunto').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#new_cargo_servidor').val()+"&irregularidad="+$('#new_irregularidad').val()+"&monto="+$('#new_monto').val(),
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
			//alert(datos)
				
				//mostrarCuadro(500,800,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&mensaje=Presunto Guardado");
				new mostrarCuadro2(500,800,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				//mostrarCuadro(500,110,"Accion "+accion+" | ",50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
			}
		});
	}
}

//------------------------------ FUNCION ACTUALIZA PRESUNTO -------------------------------
function actualizaPresunto(accion,usuario,direccion)
{
	if(comprobarForm('presunto_MOD'))
	{
	
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_presunto.php",
			data: "funcion=actualiza&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoPresunto="+$('#tipoPresunto').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&norma="+$('#norma').val()+"&nuevo_monto="+$('#nuevo_monto').val()+"&irregularidad="+$('#irregularidad').val()+"&fechairre="+$('#fechairre').val()+"&fecha_de_cargo_inicio_n="+$('#fecha_de_cargo_inicio_n').val()+"&fecha_de_cargo_final_n="+$('#fecha_de_cargo_final_n').val(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				cerrarCuadro2();
				cerrarCuadro3();
				//alert(datos)
				new mostrarCuadro(550,1000,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")

				//$('#actualizaP2').html(datos);
			}
		});
	}
}
//------------------------------FUNCION ACTUALIZA PRESUNTO PFRR ----------------------------------
function actualizaPresuntoPFRR(accion,usuario,direccion,presunto)
{
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			type: "POST",
			url: "procesosAjax/pfrr_agrega_datos_presunto.php",
			//data: "funcion=agrega&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoPresunto="+$('#tipoPresunto').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&irregularidad="+$('#irregularidad').val()+"&monto="+$('#monto').val()+"&rfc="+$('#rfc').val() +"&domicilio="+$('#domicilio').val(),
			data: $("#presunto_MOD_pfrr").serialize()+"&funcion=actualiza",
			success: function(datos)
			{ 
				var espacios = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
 				//new mostrarCuadro2(520,800,presunto+espacios+accion+espacios+$("#estadoPFRR").val(),50,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion);
				new mostrarCuadro(580,1000,accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#entidadAcc").val()+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#estadoAcc").val(),30,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				cerrarCuadro2();
			}
		});
}
//------------------------------FUNCION ACTUALIZA MONTOS PFRR ----------------------------------
function actualizaMontosPFRR(accion,usuario,direccion)
{
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/pfrr_agrega_datos_presunto.php",
			//data: "funcion=agrega&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoPresunto="+$('#tipoPresunto').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&irregularidad="+$('#irregularidad').val()+"&monto="+$('#monto').val()+"&rfc="+$('#rfc').val() +"&domicilio="+$('#domicilio').val(),
			data: $("#presunto_MOD_pfrr").serialize()+"&funcion=agrega",
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				//cerrarCuadro2();
				//cerrarCuadro3();
				//alert(datos)
				//new mostrarCuadro(550,1000,"Presuntos de la Accion '"+accion+"' ",50,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				$("#subir_1").submit();
				$("#subir_2").submit();
				//$('#actualizaP2').html(datos);
			}
		});
}
//------------------------------ FUNCION BORRA PRESUNTO -------------------------------
function borraPresunto(id_presunto,usuario,direccion)
{
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_borra_presunto.php",
			data: "funcion=borra&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+id_presunto+"&tipoPresunto="+$('#tipoPresunto').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&irregularidad="+$('#irregularidad').val()+"&monto="+$('#monto').val(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				cerrarCuadro2();
				cerrarCuadro3();
				//alert(datos)
				new mostrarCuadro(550,1000,"Presuntos de la Accion '"+$('#num_accion').val()+"' ",50,"cont/po_presuntos.php","numAccion="+$('#num_accion').val()+"&usuario="+usuario+"&direccion="+direccion+"")

				//$('#actualizaP2').html(datos);
			}
		});
	
}

////-----------------------ELIMINA PRESUNTOS PFRR

function borraPresuntopfrr(id_presunto,usuario,direccion)
{
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/pfrr_borra_presunto.php",
			data: "funcion=borra&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+id_presunto+"&tipoPresunto="+$('#tipoPresunto').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&irregularidad="+$('#irregularidad').val()+"&monto="+$('#monto').val(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				cerrarCuadro2();
				cerrarCuadro3();
				//alert(datos)
				new mostrarCuadro(580,1200,"Presuntos de la Accion '"+$('#num_accion').val()+"' ",50,"cont/pfrr_presuntos.php","numAccion="+$('#num_accion').val()+"&usuario="+usuario+"&direccion="+direccion+"")

				//$('#actualizaP2').html(datos);
			}
		});
	
}

//------------------------------ FUNCION ACTUALIZA PRESUNTO 2 DOS -------------------------------
function actualizaPresunto_2(accion,usuario,direccion)
{
	if(comprobarForm('presunto_MOD'))
	{
	
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_presunto.php",
			data: "funcion=actualiza&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoPresunto="+$('#tipoPresunto').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&dependencia="+$('#dependencia_servidor').val()+"&irregularidad="+$('#irregularidad').val()+"&monto="+$('#monto').val(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				cerrarCuadro3();
				//cerrarCuadro3();
				//alert(datos)
				new mostrarCuadro2(550,1000,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")

				//$('#actualizaP').html(datos);
			}
		});
	}
}
//----------------------------------------------------- AUTORIDAD PO --------------------------------------
function guardaAutoridad()
{
	if(comprobarForm('presunto_NEW'))
	{
		var accion = $('#num_accion').val();
		var usuario = $('#usuarioActual').val();
		var direccion = $('#dirPre').val();
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_autoridad.php",
			data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoAutoridad="+$('#new_tipoAutoridad').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#new_cargo_servidor').val()+"&dependencia="+$('#new_dependencia').val(),
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
			//alert(datos)
				
				//mostrarCuadro(500,800,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&mensaje=Presunto Guardado");
				new mostrarCuadro(550,1000,"Autoridades de la Accion '"+accion+"' ",50,"cont/po_autoridades.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				//mostrarCuadro(500,110,"Accion "+accion+" | ",50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
			}
		});
	}
}
function guardaAutoridad_2()
{
	if(comprobarForm('presunto_NEW'))
	{
		var accion = $('#num_accion').val();
		var usuario = $('#usuarioActual').val();
		var direccion = $('#dirPre').val();
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_autoridad.php",
			data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoAutoridad="+$('#new_tipoAutoridad').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#new_cargo_servidor').val()+"&dependencia="+$('#new_dependencia').val(),
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//alert(datos)
				new mostrarCuadro2(550,1000,"Autoridades de la Accion '"+accion+"' ",50,"cont/po_autoridades_2.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
			}
		});
	}
}

//------------------------------ FUNCION ACTUALIZA PRESUNTO -------------------------------
function actualizaAutoridad(accion,usuario,direccion)
{
	if(comprobarForm('autoridad_MOD'))
	{
	
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_autoridad.php",
			data: "funcion=actualiza&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoAutoridad="+$('#tipoAutoridad').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&dependencia="+$('#dependencia').val(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				cerrarCuadro2();
				cerrarCuadro3();
				//alert(datos)
				new mostrarCuadro(550,1000,"Autoridades de la Accion '"+accion+"' ",50,"cont/po_autoridades.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")

				//$('#actualizaP2').html(datos);
			}
		});
	}
}
//------------------------------ FUNCION ACTUALIZA PRESUNTO 2 DOS -------------------------------
function actualizaAutoridad_2(accion,usuario,direccion)
{
	if(comprobarForm('autoridad_MOD'))
	{
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/po_actualiza_autoridad.php",
			data: "funcion=actualiza&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoAutoridad="+$('#tipoAutoridad').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&dependencia="+$('#dependencia').val(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				cerrarCuadro3();
				//cerrarCuadro3();
				//alert(datos)
				new mostrarCuadro2(550,1000,"Autoridades de la Accion '"+accion+"' ",50,"cont/po_autoridades.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")

				//$('#actualizaP2').html(datos);
			}
		});
	}
}
//----------------------------------------------------- AUTORIDAD PFRR --------------------------------------
function guardaAutoridadPFRR()
{
	if(comprobarForm('presunto_NEW'))
	{
		var accion = $('#num_accion').val();
		var usuario = $('#usuarioActual').val();
		var direccion = $('#dirPre').val();
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/pfrr_actualiza_autoridad.php",
			data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoAutoridad="+$('#new_tipoAutoridad').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#new_cargo_servidor').val()+"&dependencia="+$('#new_dependencia').val(),
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
			//alert(datos)
				
				//mostrarCuadro(500,800,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&mensaje=Presunto Guardado");
				new mostrarCuadro(550,1000,"Autoridades de la Accion '"+accion+"' ",50,"cont/pfrr_autoridades.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				//mostrarCuadro(500,110,"Accion "+accion+" | ",50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
			}
		});
	}
}
//-------------------------------------------------------------------DTNS-------------------------------
function guardaMonto()
{
	if(comprobarForm('fmonto'))
	{
		var confirma = confirm("El importe de Inicio del PFRR cambiara a "+$('#monto_pfrr').val()+" \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_actualiza_monto_inicio.php",
				data: {
						num_accion:$('#num_accion2').val(),
						monto_inicio:$('#monto_pfrr').val(),
						edotram:$('#edtramfrr').val(),
						usm:$('#usfrr').val(),
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
//-------------------------------------------------------------------PDR-------------------------------
function guardaMonto1()
{
	if(comprobarForm('fmonto1'))
	{
		var confirma = confirm("El importe de PDR cambiara a "+$('#monto_pdr').val()+" \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_actualiza_monto_inicio.php",
				data: {
						num_acc:$('#num_accion3').val(),
						montopdr:$('#monto_pdr').val(),
						edotram:$('#edtrampdr').val(),
						usm:$('#usfrr').val(),
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
//-------------------------------------------------------------------Clv SICSA-------------------------------
function clvsicsa()
{
	if(comprobarForm('fclvsicsa'))
	{
		var confirma = confirm("Guardara la clave SICSA "+$('#clv_sicsa').val()+" \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_actualiza_monto_inicio.php",
				data: {
						num_acc:$('#accionsic').val(),
						clv_sicsa:$('#clv_sicsa').val(),
						edotram:$('#edtramsic').val(),
						usm:$('#ussic').val(),
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
//-------------------------------------------------------------------N° DT-------------------------------
function pfrndt()
{
	if(comprobarForm('fdt'))
	{
		var confirma = confirm("Guardara el Número de DT: "+$('#ndt').val()+" \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_actualiza_monto_inicio.php",
				data: {
						num_acc:$('#acciondt').val(),
						ndt:$('#ndt').val(),
						edotram:$('#edtramdt').val(),
						usm:$('#usdt').val(),
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
//-------------------------------------INICIO CODIGO Clave SICSA DTNS--------------------------------------------------------------
function guardaclave()
{
	if(comprobarForm('formpres'))
	{
		var confirma = confirm("Guardara la Clave SICSA: "+$('#sicsa_clv').val()+" \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_clave_sicsa.php",
				data: {
						num_accion:$('#num_accionsicsa').val(),
						prescripcion:$('#sicsa_clv').val(),
						edt:$('#sicsa_et').val(),
						usu:$('#sicsa_usu').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert(datos);
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
//-------------------------------------FIN CODIGO Clave SICSA DTNS-------------------------------
//-------------------------------------INICIO CODIGO Irregularidad General DTNS--------------------------------------------------------------
function guardairreg()
{
	if(comprobarForm('forirreg'))
	{
		var confirma = confirm("Guardara la Irregularidad General \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_irregularidad.php",
				data: {
						num_accion:$('#irreg_accion').val(),
						irreg:$('#txiregg').val(),
						edt:$('#irreg_et').val(),
						usu:$('#irreg_usu').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert(datos);
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
//-------------------------------------FIN CODIGO Irregularidad General DTNS-------------------------------
//////////////////////amp
function ampliado()
{
	if($('#reintegro:checked').val() || $('#subejercicio:checked').val() || $('#mixto:checked').val())
	{
		var confirma = confirm("Se guardaran los Campos seleccionados  \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_ampliado.php",
				data: {
						num_accion:$('#num_accion2').val(),
						chk1:$('#reintegro:checked').val(),
						chk2:$('#subejercicio:checked').val(),
						chk3:$('#mixto:checked').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
///////////////////// amp
function guardaPrescripcion()
{
	if(comprobarForm('fpress'))
	{
		var confirma = confirm("La fecha de Irregularidad cambiara a "+$('#f1_fecha_presc').val()+" ¿Desea continuar? ");
		//var confirma = confirm("La fecha de Prescripción cambiara a "+$('#f1_fecha_presc').val()+" \n\n ¿Desea continuar? ");		
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/po_actualiza_prescripcion.php",
				data: {
						num_accion:$('#num_accion2').val(),
						prescripcion:$('#f1_fecha_presc').val(),
						presc:$('#f1_fecha_presc_p').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}
//-------------------------------------------------------------------DTNS-------------------------------
/*function guardaPrescripcionpfrr()
{
	if(comprobarForm('fpress'))
	{
		var confirma = confirm("La fecha de Irregularidad(pr) cambiara a "+$('#f1_fecha_presc').val()+" \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resultado').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/pfrr_actualiza_prescripcion.php",
				data: {
						num_accion:$('#num_accion2').val(),
						prescripcion:$('#f1_fecha_presc').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert(datos);
					$('#resultado').html(datos); 
					$('#message-green').fadeIn(); 
					//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
}*/
//---------------------- COMPRUEBA DEVOLUCIONES IMPORTANTE ------------------
function compruebaNot()
{
	//var segundos = 300;
	//segundos = segundos*1000;
	
	$.ajax
	({
		beforeSend: function(objeto)
		{
			$('#listaCralSol').html('<center><br><br><br> Cargando ... <br><br> <img src="images/load_chico.gif" style=" "></center>');
		},
		complete: function(objeto, exito)
		{
			//alert("Me acabo de completar")
			//if(exito=="success"){ alert("Y con éxito"); }
		},
		type: "POST",
		url: "procesosAjax/po_verificaNotificaciones.php",
		data: {
				direccion:$('#indexDir').val(),
				nivel:$('#indexNivel').val(),
				usuario:$('#indexUser').val()
			},
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé \n Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			altura = $("#content").height();
			$("#related-act-inner").height(altura);
			$("#related-act-inner").height(altura);
			
			var partes = datos.split("|");
			
			var pen = 0;
			pen = partes[1];
			
			if(pen == 'undefined') pen = 0;
			
			$("#encNoti").html("<span id='numDevPen' class='redonda5'>"+pen+"</span> Avisos");
			$("#listaCralSol").html(partes[0]);
			
		}
	});
	setTimeout("compruebaNot()",150000);//milisegundos 1000 =  un segundo
}
//------------------------------------
//------------------------------------
$(document).ready(function(){
	// compruebaNot();
});
//------------------------------------
function marcaCralVisto(folio,accion,tipo)
{
	var confirma = confirm("Una vez marcado como 'visto' ya no podra volver a ver el CRAL en las notificaciones. \n Solo en la bitacora de la accion \n\n ¿Desea Continuar? ");
	if(confirma)
	{
		$.ajax({
			type: "POST",
			url: "procesosAjax/po_CralVisto.php",
			//beforeSend: function(){  },
			data: {
					folio:folio,
					accion:accion,
					tipo:tipo
				},
			success: function(data) 
				{ 	
				//alert(data)
					compruebaNot();
					cerrarCuadro();
				}
		});
	}
}
//------------------------------FUNCION AGREGA DATOS----------------------------------
//------------------------------FUNCION AGREGA DATOS----------------------------------
function agregaDatosDano(accion,usuario,direccion)
{
	var error = 0;
	var mensaje = "";
	if( ($('#monto_reintegrado').val() != "" || $('#fecha_dep_monto').val() != "")  && $('#ficha2').val() == "" ) {error = 1; mensaje += "\n - Introduzca la Ficha de Reintegro.";}
	if( $('#monto_reintegrado').val() != "" && $('#fecha_dep_monto').val() == "" ) {error = 1; mensaje += "\n - Introduzca la Fecha de Reintegro.";}
	
	if(error != 0)
	{
		alert(mensaje);
	}
	else
	{
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/pfrr_agrega_datos_presunto.php",
			//data: "funcion=agrega&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&tipoPresunto="+$('#tipoPresunto').val()+"&servidor="+$('#servidor_contratista').val()+"&cargo="+$('#cargo_servidor').val()+"&irregularidad="+$('#irregularidad').val()+"&monto="+$('#monto').val()+"&rfc="+$('#rfc').val() +"&domicilio="+$('#domicilio').val(),
			data: {
				  funcion:"actualizaMontosDano",
				  idPresunto:$('#cont').val(),  
				  monto_dano:$('#monto_dano').val(), 
				  monto_aclaradoUAA:$('#monto_aclaradoUAA').val(), 
				  monto_aclarado:$('#monto_aclarado').val(), 
				  fecha_dep_monto:$('#fecha_dep_monto').val(), 
				  monto_reintegrado:$('#monto_reintegrado').val(), 
				  fecha_dep_int:$('#fecha_dep_int').val(), 
				  intereses:$('#intereses').val(),
				  interesesD:$('#interesesDano').val(),
				  importe_frr:$('#importe_frr').val(),
  				  fecha_registro:$('#fecha_registro').val(), 
				  usuario:usuario,
				  direccion:direccion
				       
			},
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				//new mostrarCuadro(550,1000,"Presuntos de la Accion '"+accion+"' ",50,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				$("#subir_2").submit();
				mostrarCuadro(550,1000,accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actualiza",20,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion)
				alert("Importes Actualizados...");
				$("#tablaSuma").load("procesosAjax/pfrr_cargaSuma.php","numAccion="+accion+"&idPresuntop="+$('#cont').val());
				//mostrarCuadro2(540,800,accion,50,"cont/pfrr_presuntos_montos.php","idPresuntop="+$('#cont').val()+"&numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion);

				//$('#actualizaP2').html(datos);
			}
		});
	}// end else 
}
//-----------------------------------------------------------------
//-----------------------------------------------------------------
function agregaDatosIntereses(accion,usuario,direccion)
{
	var error = 0;
	var mensaje = "";
	
	if(($('#intereses').val() != "" || $('#fecha_dep_int').val() != "")  && $('#ficha1').val() == "") {error = 1; mensaje += "\n - Introduzca la Ficha de Intereses.";}
	if($('#intereses').val() != "" && $('#fecha_dep_int').val() == "")  {error = 1; mensaje += "\n - Introduzca la Fecha de Intereses.";}
	//alert("aqui ando");
	
	if(error != 0)
	{
		alert(mensaje);
	}
	else
	{
		$.ajax
		({
			beforeSend: function(objeto)
			{
				//$('#actualizaP2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/pfrr_agrega_datos_presunto.php",

			data: {
				  funcion:"actualizaMontosIntereses",
				  idPresunto:$('#cont').val(),  
				  monto_dano:$('#monto_dano').val(), 
				  monto_aclarado:$('#monto_aclarado').val(), 
				  fecha_dep_monto:$('#fecha_dep_monto').val(), 
				  monto_reintegrado:$('#monto_reintegrado').val(), 
				  fecha_dep_int:$('#fecha_dep_int').val(), 
				  intereses:$('#intereses').val(),
				  interesesD:$('#interesesDano').val(),
  				  importe_frr:$('#importe_frr').val(),
				  usuario:usuario,
				  direccion:direccion
			},
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//carga cuasdro devuelve el resultado al id presuntoRes y muestra p2
				//mostrarCuadro(550,1000,"Presuntos de la Accion '"+accion+"' ",50,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				$("#subir_1").submit();
				mostrarCuadro(550,1000,accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actualiza",20,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion)
				alert("Importes Actualizados...");
				$("#tablaSuma").load("procesosAjax/pfrr_cargaSuma.php","numAccion="+accion+"&idPresuntop="+$('#cont').val());
				//mostrarCuadro2(540,800,accion,50,"cont/pfrr_presuntos_montos.php","idPresuntop="+$('#cont').val()+"&numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion);

				//$('#actualizaP2').html(datos);
			}
		});
	}// end else 
}
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
//--------------------------------Guarda Fechas----------------------------------------
function fechadeCitatorio(accion,usuario,direccion, cambiaEdo)
{
	if(comprobarForm('presunto_guarda_pfrr'))
	{
		if(cambiaEdo) var msjEdo = "Cambiara el estado de la accion a \n\n - ' Oficio(s) Citatorio(s) Notificado(s) del PFRR ' ";
		var confirma = confirm("Se creara la fecha de citación con fecha "+$("#fecha_citacion").val()+"\n\n"+msjEdo+"\n\n¿Desea continuar?");
		if(confirma)
		{
			$.ajax
			({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//data: $("#presunto_guarda_pfrr").serialize()+"&tipoFecha=citatorio&idpresunto="+$("#idFpresunto").val()+"&presunto="+$("#nomPresunto").val()+"&cargo="+$("#carPresunto").val()+"dependencia="+$("#depPresunto").val()+"&rfc="+$("#rfcPresunto").val()+"&accion="+$("#accPresunto").val()+"&usuario="+usuario,
				data:{
					tipoFecha: 			'citatorio',
					idpresunto:			$("#idFpresunto").val(),
					presunto:			$("#nomPresunto").val(),
					cargo:				$("#carPresunto").val(),
					dependencia:		$("#depPresunto").val(),
					rfc:				$("#rfcPresunto").val(),
					oficio_citatorio:	$("#oficio_citatorio").val(),
					fecha_oficio_cit:	$("#fecha_oficio_cit").val(),
					fecha_noti_cit:		$("#fecha_noti_cit").val(),
					tipo_noti:			$("#tipo_noti").val(),
					fecha_citacion:		$("#fecha_citacion").val(),
					accion:		$("#accPresunto").val(),
					usuario:	usuario,
					direccion:	direccion,
					cambiaEdo:			cambiaEdo
					},
				success: function(datos)
				{
					//alert(datos)
					cargarAccionespfrr();
					compruebaNot();
					new mostrarCuadro2(530,1100,$("#nomPresunto").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto").val()+"&numAccion="+$("#accPresunto").val()+"&usuario="+$("#usuarioAud").val()+"&direccion=")
					cerrarCuadro3();
				}
			});
		}
	}
}
//--------------------------------------------------------------------------------
function fechaDiferimiento(accion,usuario,direccion,comparecio,idAud)
{
	if(comparecio == 0){
			var confirma = confirm("El presunto como No Comparecio a la Audiencia \n\n ¿Desea continuar?");
			if(confirma)
			{
				$.ajax({
					type: "POST",
					url: "procesosAjax/pfrr_presuntos_proceso.php",
					//beforeSend: function(){  },
					data: {
							tipoFecha: 		'noCompareceNunca',
							idpresunto:		$("#idFpresunto").val(),
							idAud:			idAud,
							presunto:		$("#nomPresunto").val(),
							cargo:			$("#carPresunto").val(),
							dependencia:	$("#depPresunto").val(),
							rfc:			$("#rfcPresunto").val(),
							accion:			$("#accPresunto").val(),
							oficioAcuse:	$("#oficioAcuseDif").val(),
							//oficio:			$("#oficioDif").val(),
							fechaDif:		$("#fechaDif").val(),
							usuario:		usuario,
							direccion:		direccion 
							},
					success: function(data) 
						{ 
							//alert(data)	
							compruebaNot();
							new mostrarCuadro2(530,1100,$("#nomPresunto").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto").val()+"&numAccion="+$("#accPresunto").val()+"&usuario="+$("#usuarioAud").val()+"&direccion=")
							cerrarCuadro3();
						}
				});
			}
	}
	else
	{
		if(comprobarForm('formDiferimiento'))
		{
			var confirma = confirm("Se creara la fecha de Diferimiento con fecha "+$("#fechaDif").val()+"\n\n ¿Desea continuar?");
			if(confirma)
			{
				$.ajax({
					type: "POST",
					url: "procesosAjax/pfrr_presuntos_proceso.php",
					//beforeSend: function(){  },
					data: {
							tipoFecha: 		'diferimiento',
							idpresunto:		$("#idFpresunto").val(),
							presunto:		$("#nomPresunto").val(),
							cargo:			$("#carPresunto").val(),
							dependencia:	$("#depPresunto").val(),
							rfc:			$("#rfcPresunto").val(),
							accion:			$("#accPresunto").val(),
							oficioAcuse:	$("#oficioAcuseDif").val(),
							oficio:			$("#oficioDif").val(),
							fechaDif:		$("#fechaDif").val(),
							usuario:		usuario,
							direccion:		direccion 
							},
					success: function(data) 
						{ 	
							compruebaNot();
							new mostrarCuadro2(530,1100,$("#nomPresunto").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto").val()+"&numAccion="+$("#accPresunto").val()+"&usuario="+$("#usuarioAud").val()+"&direccion=")
							cerrarCuadro3();
						}
				});
			}
		}
	}// end comparecio
}
//--------------------------------------------------------------------------------
function fechaDeContinuacion(accion,usuario,direccion)
{
	if(comprobarForm('formContinuacionX'))
	{
		var confirma = confirm("Se creara la fecha de Continuacion con fecha "+$("#fechaContinuacion").val()+"\n\n ¿Desea continuar?");
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: {
						tipoFecha: 	'continuacion',
						idPresunto:	$("#idFpresunto").val(),
						presunto:	$("#nomPresunto").val(),
						cargo:		$("#carPresunto").val(),
						dependencia:$("#depPresunto").val(),
						rfc:		$("#rfcPresunto").val(),
						accion:		$("#accPresunto").val(),
						usuario:	usuario,
						direccion:	direccion,
						oficio:		$("#audOficio").val(),
						fecha:		$("#fechaContinuacion").val() 
						},
				success: function(data) 
					{ 
						//alert(data)	
						compruebaNot();
						new mostrarCuadro2(530,1100,$("#nomPresunto").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto").val()+"&numAccion="+$("#accPresunto").val()+"&usuario="+$("#usuarioAud").val()+"&direccion=")
						cerrarCuadro3();
					}
			});
		}
	}
}
//------------------------------------------------------------------------
function pendientesAUD(res,accion,cambiaEdo17,ultimaRonda,ultimaFecha,usuario,idPresunto,tipoAudiencia,idAud)
{
	//alert("Accion"+$("#accPresunto").val()+"\nAccion1"+$("#accPresunto1").val());
	if(res == 0) // NO COMPARECIO
		var confirma = confirm("El presunto se guardara como 'No Comparecio' \n\n ¿Desea continuar? ");
	else
	{
		if(cambiaEdo17 == 1 && tipoAudiencia == 1) 
			var confirma = confirm('Cambiara el estado de la accion a:  \n\n  " En desahogo de Audiencia de Ley " \n\n ¿Desea continuar?');
		else confirma = true;
	}
	//---------- si todo se acepta ---------------
	if(confirma)
	{
		$.ajax({
			type: "POST",
			url: "procesosAjax/pfrr_presuntos_proceso.php",
			//beforeSend: function(){  },
			data: 
			{
				tipoFecha: 		'compareceOno',
				idAud:			$("#idAudiencia").val(),
				idPresunto:		idPresunto,
				cambiaEdo17:	cambiaEdo17,
				accion:			$("#accPresunto").val(),
				oficio:			$("#audOficio").val(),
				usuario: 		usuario,
				comparece: 		res,
				ultimaFecha:	ultimaFecha,
				tipoAudiencia:	tipoAudiencia
			},
			success: function(data) 
			{ 
				//alert(data);
				cargarAccionespfrr();	
				compruebaNot();
				if(res == 0) new mostrarCuadro3(400,600,$("#nomPresunto").val(),100,"cont/pfrr_presuntos_proceso_agregarFechas.php","idAud="+idAud+"&idPresunto="+$("#idFpresunto1").val()+"&accion="+$("#accPresunto1").val()+"&usuario="+usuario+"&tipoDeFecha=fechaDiferimiento");
				else 
				{
					cerrarCuadro3();
					new mostrarCuadro2(530,1100,$("#nomPresunto").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto1").val()+"&numAccion="+$("#accPresunto").val()+"&usuario="+usuario+"&direccion=");
				}
			}
		});
		
	}
}
//------------------------------------------------------------------------
function pendientesDIF(res,idDif)
{
	if(res == 0) // NO COMPARECIO
		var confirma = confirm("El presunto se guardara como 'No Comparecio' \n\n ¿Desea continuar? ");
	else
		var confirma = confirm("El presunto se guardara como 'Si Comparecio' \n\n ¿Desea continuar? ");
	//---------- si todo se acepta ---------------
	if(confirma)
	{
		$.ajax({
			type: "POST",
			url: "procesosAjax/pfrr_presuntos_proceso.php",
			//beforeSend: function(){  },
			data: 
			{
				tipoFecha: 	'compareceOnoDIF',
				idAud:		idDif,
				idPresunto:	$("#idFpresunto").val(),
				accion:		$("#accPresunto").val(),
				oficio:		$("#oficioDif").val(),
				usuario: 	$("#usuarioAud").val(),
				comparece: 	res
			},
			success: function(data) 
			{ 	
				compruebaNot();
				new mostrarCuadro2(530,1100,$("#nomPresunto").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto").val()+"&numAccion="+$("#accPresunto").val()+"&usuario="+$("#usuarioAud").val()+"&direccion=")
				cerrarCuadro3();
			}
		});
		//cerrarCuadro();
	}
}
//------------------------------------------------------------------------
function ofrecimientoPruebas(cambiaEdo18,usuario)
{
	if(comprobarForm('formPruebas'))
	{
		if(cambiaEdo18 == 1) 
			var confirma = confirm('Fecha de Pruebas '+$("#fechaOfrecimientoPruebas").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " Formulación y desahogo de pruebas " \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Fecha de Pruebas '+$("#fechaOfrecimientoPruebas").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'ofrecimientoPruebas',
					idPresunto:	$("#idFpresunto1").val(),
					presunto:	$("#nomPresunto1").val(),
					rfc:		$("#rfcPresunto1").val(),
					cambiaEdo18:cambiaEdo18,
					accion:		$("#accPresunto1").val(),
					oficio:		$("#audOficio1").val(),
					usuario: 	usuario,
					fecha :		$("#fechaOfrecimientoPruebas").val()
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					compruebaNot();
					new mostrarCuadro2(530,1100,$("#nomPresunto1").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto1").val()+"&numAccion="+$("#accPresunto1").val()+"&usuario="+usuario+"&direccion=")
					cerrarCuadro3();
				}
			});
			//cerrarCuadro();
		}
	}
}
//------------------------------------------------------------------------
function ofrecimientoAdmision(cambiaEdo18,usuario)
{
	if(comprobarForm('formPruebas'))
	{
		if(cambiaEdo18 == 1) 
			var confirma = confirm('Fecha de Pruebas '+$("#fechaOfrecimientoPruebas").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " Formulación y desahogo de pruebas " \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Fecha de Pruebas '+$("#fechaOfrecimientoPruebas").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'ofrecimientoAdmision',
					idPresunto:	$("#idFpresunto1").val(),
					presunto:	$("#nomPresunto1").val(),
					rfc:		$("#rfcPresunto1").val(),
					cambiaEdo18:cambiaEdo18,
					accion:		$("#accPresunto1").val(),
					oficio:		$("#audOficio1").val(),
					usuario: 	usuario,
					fecha :		$("#fechaAdmision").val()
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					compruebaNot();
					new mostrarCuadro2(530,1100,$("#nomPresunto1").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto1").val()+"&numAccion="+$("#accPresunto1").val()+"&usuario="+usuario+"&direccion=")
					cerrarCuadro3();
				}
			});
			//cerrarCuadro();
		}
	}
}
//------------------------------------------------------------------------
function ofrecimientoDesahogo(cambiaEdo18,usuario)
{
	if(comprobarForm('formPruebas'))
	{
		if(cambiaEdo18 == 1) 
			var confirma = confirm('Fecha de Pruebas '+$("#fechaOfrecimientoPruebas").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " Formulación y desahogo de pruebas " \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Fecha de Pruebas '+$("#fechaOfrecimientoPruebas").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'ofrecimientoDesahogo',
					idPresunto:	$("#idFpresunto1").val(),
					presunto:	$("#nomPresunto1").val(),
					rfc:		$("#rfcPresunto1").val(),
					cambiaEdo18:cambiaEdo18,
					accion:		$("#accPresunto1").val(),
					oficio:		$("#audOficio1").val(),
					usuario: 	usuario,
					fecha :		$("#fechaDesahogo").val()
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					compruebaNot();
					new mostrarCuadro2(530,1100,$("#nomPresunto1").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto1").val()+"&numAccion="+$("#accPresunto1").val()+"&usuario="+usuario+"&direccion=")
					cerrarCuadro3();
				}
			});
			//cerrarCuadro();
		}
	}
}
//------------------------------------------------------------------------
function periodoAlegatos(cambiaEdo31,usuario)
{
	if(comprobarForm('formAlegatos'))
	{
		if(cambiaEdo31 == 1) 
			var confirma = confirm('Fecha de Alegatos '+$("#fechaAlegatos").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " Período de alegatos " \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Fecha de Alegatos '+$("#fechaAlegatos").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'periodoAlegatos',
					idPresunto:	$("#idFpresunto1").val(),
					presunto:	$("#nomPresunto1").val(),
					rfc:		$("#rfcPresunto1").val(),
					cambiaEdo31:cambiaEdo31,
					accion:		$("#accPresunto1").val(),
					oficio:		$("#audOficio1").val(),
					usuario: 	usuario,
					fecha :		$("#fechaAlegatos").val()
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					compruebaNot();
					new mostrarCuadro2(530,1100,$("#nomPresunto1").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$("#idFpresunto1").val()+"&numAccion="+$("#accPresunto1").val()+"&usuario="+usuario+"&direccion=")
					cerrarCuadro3();
				}
			});
			//cerrarCuadro();
		}
	}
}
//------------------------------------------------------------------------
function FeultimaActuacion(cambiaEdo28)
{
	if(comprobarForm('formUltimaActuacion'))
	{
		if(cambiaEdo28 == 1) 
			var confirma = confirm('Ultima Actuación '+$("#fechaUltimaActuacion").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " Ultima Actualización " \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Ultima Actuación '+$("#fechaUltimaActuacion").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'fechaUltimaActuacion',
					cambiaEdo28:cambiaEdo28,
					accion:		$("#num_accion").val(),
					usuario: 	$("#txtUser").val(),
					fecha :		$("#fechaUltimaActuacion").val()
				},
				success: function(data) 
				{ 	
					cargarAccionespfrr();
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+$("#num_accion").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#entidad_fiscalizada").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#edoTraPro").val(),50,"cont/pfrr_proceso.php","numAccion="+$("#num_accion").val()+"&usuario="+$("#userDir").val()+"&direccion="+$("#userDir").val()+"");
				}
			});
			//cerrarCuadro();
		}
	}
}
//------------------------------------------------------------------------
function acuseOpinionUAA(cambiaEdo19)
{
	//alert($("#num_accion").val());
	
	if(comprobarForm('formOpinionUAA'))
	{
		if(cambiaEdo19 == 1) 
			var confirma = confirm('Cambiara el estado de la accion a:  \n\n  " En Opinión técnica de la UAA " \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('No se cambiara el estado  \n\n ¿Desea continuar? ');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_proceso_pasos.php",
				//beforeSend: function(){  },
				data: 
				{
					proceso: 	'acuseOpinionUAA',
					cambiaEdo19:cambiaEdo19,
					accion:		$("#num_accion").val(),
					usuario: 	$("#indexUser").val(),
					oficio :	$("#folioUAA").val(),
					fechaOf :	$("#fechaUAA").val(),
					fechaAc :	$("#fechaAcuseUAA").val()
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+$("#num_accion").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#entidad_fiscalizada").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#edoTraPro").val(),50,"cont/pfrr_proceso.php","numAccion="+$("#num_accion").val()+"&usuario="+$("#userDir").val()+"&direccion="+$("#userDir").val()+"");
				}
			});
			//cerrarCuadro();
		}
	}
}
//------------------------------------------------------------------------
function FecierreInstruccionx(cambiaEdo22)
{
	if(comprobarForm('formCierreInstruccion'))
	{
		if(cambiaEdo22 == 1) 
			var confirma = confirm('Cierre de instrucción '+$("#fechaCierreInstruccion").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " En Elaboración de resolución y, en su caso, PDR" \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Cierre de instrucción '+$("#fechaCierreInstruccion").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'FecierreInstruccionx',
					cambiaEdo22:cambiaEdo22,
					accion:		$("#num_accion").val(),
					usuario: 	$("#indexUser").val(),
					fecha :		$("#fechaCierreInstruccion").val()
				},
				success: function(data) 
				{ 	
					alert(data);
					cargarAccionespfrr();
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+$("#num_accion").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#entidad_fiscalizada").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#edoTraPro").val(),50,"cont/pfrr_proceso.php","numAccion="+$("#num_accion").val()+"&usuario="+$("#userDir").val()+"&direccion="+$("#userDir").val()+"");
				}
			});
			//cerrarCuadro();
		}
	}
}

//------------------------------------------------------------------------
//------------------------------------------------------------------------
//------------------------------SOBRESEIMIENTO----------------------------
function FecierreInstruccionxx(cambiaEdo22)
{
	if(comprobarForm('formCierreInstruccion_2'))
	{
		if(cambiaEdo22 == 1) 
			var confirma = confirm('Cierre de instrucción '+$("#fechaCierreInstruccion_2").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " En Elaboración de resolución" \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Cierre de instrucción '+$("#fechaCierreInstruccion_2").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'FecierreInstruccionxx',
					cambiaEdo22:cambiaEdo22,
					accion:		$("#num_accion").val(),
					usuario: 	$("#indexUser").val(),
					fecha :		$("#fechaCierreInstruccion_2").val()
				},
				success: function(data) 
				{ 	
					alert(data);
					cargarAccionespfrr();
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+$("#num_accion").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#entidad_fiscalizada").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#edoTraPro").val(),50,"cont/pfrr_proceso.php","numAccion="+$("#num_accion").val()+"&usuario="+$("#userDir").val()+"&direccion="+$("#userDir").val()+"");
				}
			});
			//cerrarCuadro();
		}
	}
}










//--------------------------------------------------------------------------
function Sobreseer(cambiaEdo22)
{
		muestraPestana(5);
		$('#p5').fadeIn();	
		
		
		if(cambiaEdo22 == 1) 
			var confirma = confirm('Sobreseimiento \n\n Cambiara el estado de la accion a:  \n\n  " En Elaboración de resolución y, en su caso, PDR" \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Sobreseimiento  \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'FecierreInstruccionx',
					cambiaEdo22:cambiaEdo22,
					accion:		$("#num_accion").val(),
					usuario: 	$("#indexUser").val(),
					fecha :		$("#fechaCierreInstruccion").val()
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+$("#num_accion").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#entidad_fiscalizada").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#edoTraPro").val(),50,"cont/pfrr_proceso.php","numAccion="+$("#num_accion").val()+"&usuario="+$("#userDir").val()+"&direccion="+$("#userDir").val()+"");
				}
			});
			//cerrarCuadro();
		}
	}
//--------------------------------------------------------------------------
//------------------------------------------------------------------------
function Emisionresolucionx(cambiaEdo29)
{
	if(comprobarForm('resolucionx'))
	{
		if(cambiaEdo29 == 1)
		{
			var confirma = confirm('Fecha de Resolución: '+$("#fechaResolucion").val()+' \n\n Cambiara el estado de la accion a:  \n\n  "Emisión de la Resolución" \n\n ¿Desea continuar?');
			//---------- si todo se acepta ---------------
			if(confirma)
			{
				$.ajax({
					type: "POST",
					url: "procesosAjax/pfrr_presuntos_proceso.php",
					//beforeSend: function(){  },
					data: 
					{
						tipoFecha: 	'fechaResolucion',
						cambiaEdo29:cambiaEdo29,
						accion:		$("#num_accion").val(),
						usuario: 	$("#indexUser").val(),
						fecha :		$("#fechaResolucion").val(),
						tipo: 		$("#tiporesolucion").val()
					},
					success: function(datos) 
					{ 
						cargarAccionespfrr();
						var variablesx = "numAccionx="+$("#num_accion").val()+"&usuariox="+$("#indexUser").val()+"&tipox="+$("#tiporesolucion").val()+"&pdrx="+encodeURI(datos);
						new mostrarCuadro2(500,1100,"Responsabilidad de Presuntos",50,"cont/pfrr_presuntos_responsabilidades.php",variablesx);
					}
				});
				//cerrarCuadro();
			}
		}//---Fin Abstencion
	}
}
//------------------------------------------------------------------------
function Fechatipores(cambiaEdo, nombretipo, tipoNot)
{
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var dirAccion = $('#dirAccion').val();
	var cp = $('#cp').val();
	var user = $('#txtUser').val();
	var entidad_fiscalizada = $('#entidad').val();
	var edoTraPro = $("#edoTraPro").val();
	
	
	if(tipoNot == "presunto"){
		var comprobar = comprobarForm('NotiresoP');
		var fecha = $("#notificacionresoP").val();
		var tipo = nombretipo;
		//var oficio = $("#oficioP").val();
	}
	if(tipoNot == "tesofe"){
		var comprobar = comprobarForm('NotiresoT');
		var fecha = $("#notificacionresoT").val();
		var tipo = nombretipo;
		var oficio = $("#oficioT").val();
		var tipoRes = $("#tipoResolucionTESOFE").val();
	}
	if(tipoNot == "ef"){
		 var comprobar = comprobarForm('NotiresoE');
		var fecha = $("#notificacionresoE").val();
		var tipo = nombretipo;
		var oficio = $("#oficioE").val();
		var tipoRes = $("#tipoResolucionEF").val();
	}
	if(tipoNot == "icc"){
		 var comprobar = comprobarForm('NotiresoI');
		var fecha = $("#notificacionresoI").val();
		var tipo = nombretipo;
		var oficio = $("#oficioI").val();
		var tipoRes = $("#tipoResolucionICC").val();
	}
	
	if(comprobar)
	{
		var texto = "";
		if(tipoNot == "presunto") texto += ' \n\n Cambiara el estado de la accion a:  \n\n  '+nombretipo+' ';
		
		texto += 'Fecha de Notificación de la Resolución a '+tipoNot+': '+fecha;
		texto += '\n\n ¿Desea continuar?';
		
		var confirma = confirm(texto);
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'fechanotires',
					//cambiaEdo:cambiaEdo,
					cambiaEdo:	1,
					accion:		$("#num_accion").val(),
					usuario: 	$("#indexUser").val(),
					fecha :		fecha,
					tipo: 		tipo,
					tipoNot: 	tipoNot,
					oficio: 	oficio,
					tipoRes: 	tipoRes
				},
				success: function(data) 
				{ 	
					//alert(data)
					cargarAccionespfrr();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad_fiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/pfrr_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				}
			});
			//cerrarCuadro();
		}
	}//---Fin Abstencion
}
//------------------------------------------------------------------------
//function presuntoYresponsabilidad()
function presuntoYresponsabilidad()
{
//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var dirAccion = $('#dirAccion').val();
	var user = $('#txtUser').val();
	var entidad_fiscalizada = $('#entidad_fiscalizada').val();
	var edoTraPro = $('#edoTraPro').val();
	//var tipo_abs = $('#tipo_abs').val();
	var	nopropor=$('#nopropor').val();
	var dano=$('#dano').val();
	var doctos=$('#doctos').val();
	var respon=$('#respon').val();
	var reintegro=$('#reintegro').val();
	var aclara=$('#aclara').val();
	var resp=$('#resp').val();
	var sobre=$('#sobre').val();

var error=0;		
var mensaje ="";

if(comprobarForm('presuntosResponsabilidad'))
	
//------------------------------------------------------------------------------------------
if (resp= "responsabilidad" )
{
	error==0;
	
	} else {
		
		if (sobre= "sobreseimiento" )
{
	error==0;
	
	} else{ 
	
if ($('#nopropor:checked').val() == "on" || $('#dano:checked').val() == "on" || $('#doctos:checked').val() == "on"  || $('#respon:checked').val() == "on" || $('#reintegro:checked').val() == "on" || $('#aclara:checked').val() == "on" )
		{
			
		}
		else 
		{
			error++;
			mensaje+= "\n -Elija al menos una opción";
		}
}




	}





if(error != 0) alert(mensaje);
		//------------------------------------------------------------------------------------------
		if(error == 0)
		{
var confirma = confirm("Se guardarán las opciónes seleccionadas \n\n ¿Desea continuar? ");
		if(confirma)
		{
			var accion=$('#num_accion').val();
			$.ajax
			({
				beforeSend: function(objeto)
					{
						$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar")
						//if(exito=="success"){ alert("Y con éxito"); }
					},
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				data: 
				{
	proceso: 'responsabilidadYpresuntos',
	num_accion:$('#num_accion').val(),
	direccion:$('#userDir').val(),//userDir
	dirAccion:$('#dirAccion').val(),
	cp:$('#cp').val(),
	user:$('#txtUser').val(),
	entidad_fiscalizada:$('#entidad').val(),
	edoTraPro:$('#edoTraPro').val(),
	nopropor:$('#nopropor:checked').val(),
	dano:$('#dano:checked').val(),
	doctos:$('#doctos:checked').val(),
	respon:$('#respon:checked').val(),
	reintegro:$('#reintegro:checked').val(),
	aclara:$('#aclara:checked').val(),
	
	
	
	
},
//
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé");
						//alert("Ha ocurrido un error en Asistencia Jurídica!!! \n\n - Pasó lo siguiente: "+quepaso);
					},
				success: function(data) 
				{ 	
					alert(data);
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad_fiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/pfrr_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				}
				});
			}//end confirma
		}// end if error
	}// end if comprbarform			
//------------------------------------------------------------------------
//------------------------------ FUNCION NUEVO PRESUNTO -------------------------------
function guardaPresuntoPFRR()
{
	//alert($("#entidadPRFF").val()+" --- "+$("#estadoPFRR").val());
	if(comprobarForm('presunto_NEW'))
	{
		var accion = $('#num_accion').val();
		var usuario = $('#usuarioActual').val();
		var direccion = $('#dirPre').val();
		var entidad = $("#entidadPRFF").val();
		var estado = $("#estadoPFRR").val();
		//alert("aqui ando");
		$.ajax
		({
			beforeSend: function(objeto)
			{
				$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/pfrr_actualiza_presunto.php",
			data: $("#presunto_NEW").serialize()+"&funcion=nuevo",
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//alert(datos)
				//mostrarCuadro(500,800,"Presuntos de la Accion '"+accion+"' ",50,"cont/po_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&mensaje=Presunto Guardado");
				new mostrarCuadro(580,1000,accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+estado,30,"cont/pfrr_presuntos.php","numAccion="+accion+"&usuario="+usuario+"&direccion="+direccion+"")
				//mostrarCuadro(500,110,"Accion "+accion+" | ",50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
			}
		});
	}
}






