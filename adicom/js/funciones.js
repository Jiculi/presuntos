// JavaScript Document
function mostrarCuadro(alto,ancho,titulo,top,pagina,datos)
{
	this.alto = new Number(alto);
	this.ancho = new Number(ancho);
	this.titulo = new String(titulo);
	this.top = new Number(top);
	this.pagina = String(pagina);
	this.datos = String(datos);
	
	$('#cuadroRes').html('<center><img src="images/load_bar.gif" style="margin:100px 0"></center>');
	document.getElementById('cuadroTitulo').innerHTML = this.titulo;
	this.cuadro = document.getElementById('cuadroDialogo');	
	this.cuadroRes = document.getElementById('cuadroRes');	
	this.cuadro.style.height = this.alto+"px";
	this.cuadroRes.style.height = (this.alto-50)+"px";
	this.cuadro.style.width = this.ancho+"px";
	this.cuadro.style.marginLeft = this.ancho-(this.ancho*1.5)+"px"; // mientras mas alto mas a la izquierda
	
	if(this.top != 0 || this.top != '') this.cuadro.style.top = this.top+"px";
			
	$("#fondoOscuro").fadeIn();
	$("#cuadroDialogo").fadeIn();
	
	if(this.pagina != '' || this.pagina != 'undefined') $("#cuadroRes").load(this.pagina+"?"+this.datos);
	if(this.pagina == 'undefined') $('#cuadroRes').html(" ");
}
function cerrarCuadro()
{
	$("#fondoOscuro").fadeOut();
	$("#cuadroDialogo").fadeOut();
}
//---------------------------------------------------------------------------------------------------------------------------
function mostrarCuadro2(alto,ancho,titulo,top,pagina,datos)
{
	this.alto = new Number(alto);
	this.ancho = new Number(ancho);
	this.titulo = new String(titulo);
	this.top = new Number(top);
	this.pagina = String(pagina);
	this.datos = String(datos);
	
	$('#cuadroRes2').html('<center><img src="images/load_bar.gif" style="margin:100px 0"></center>');
	document.getElementById('cuadroTitulo2').innerHTML = this.titulo;
	this.cuadro = document.getElementById('cuadroDialogo2');	
	this.cuadroRes = document.getElementById('cuadroRes2');	
	this.cuadro.style.height = this.alto+"px";
	this.cuadroRes.style.height = (this.alto-70)+"px";
	this.cuadro.style.width = this.ancho+"px";
	this.cuadro.style.marginLeft = this.ancho-(this.ancho*1.5)+"px"; // mientras mas alto mas a la izquierda
	
	if(this.top != 0 || this.top != '') this.cuadro.style.top = this.top+"px";
			
	$("#fondoOscuro2").fadeIn();
	$("#cuadroDialogo2").fadeIn();
	
	if(this.pagina != '' || this.pagina != 'undefined') $("#cuadroRes2").load(this.pagina+"?"+this.datos);
	if(this.pagina == 'undefined') $('#cuadroRes2').html(" ");
}
function cerrarCuadro2()
{
	$("#fondoOscuro2").fadeOut();
	$("#cuadroDialogo2").fadeOut();
}
//---------------------------------------------------------------------------------------------------------------------------
function mostrarCuadro3(alto,ancho,titulo,top,pagina,datos)
{
	this.alto = new Number(alto);
	this.ancho = new Number(ancho);
	this.titulo = new String(titulo);
	this.top = new Number(top);
	this.pagina = String(pagina);
	this.datos = String(datos);
	
	$('#cuadroRes3').html('<center><img src="images/load_bar.gif" style="margin:100px 0"></center>');
	document.getElementById('cuadroTitulo3').innerHTML = this.titulo;
	this.cuadro = document.getElementById('cuadroDialogo3');	
	this.cuadroRes = document.getElementById('cuadroRes3');	
	this.cuadro.style.height = this.alto+"px";
	this.cuadroRes.style.height = (this.alto-70)+"px";
	this.cuadro.style.width = this.ancho+"px";
	this.cuadro.style.marginLeft = this.ancho-(this.ancho*1.5)+"px"; // mientras mas alto mas a la izquierda
	
	if(this.top != 0 || this.top != '') this.cuadro.style.top = this.top+"px";
			
	$("#fondoOscuro3").fadeIn();
	$("#cuadroDialogo3").fadeIn();
	
	if(this.pagina != '' || this.pagina != 'undefined') $("#cuadroRes3").load(this.pagina+"?"+this.datos);
	if(this.pagina == 'undefined') $('#cuadroRes3').html(" ");
}
function cerrarCuadro3()
{
	$("#fondoOscuro3").fadeOut();
	$("#cuadroDialogo3").fadeOut();
}

//---------------------------------------------------------------------------------------------------------------------------
function mostrarCuadroFrame(alto,ancho,titulo,frame,top)
{
	document.getElementById('fondoOscuroFrame').style.display = "block";	
	document.getElementById('cuadroTituloFrameNombre').innerHTML = titulo;
	document.getElementById('cuadroTituloFrame').style.width = (ancho-25)+"px";
	cuadro = document.getElementById('cuadroDialogoFrame');	
	cuadro.style.display = "block";
	cuadro.style.height = alto+"px";
	cuadro.style.width = ancho+"px";
	cuadro.style.top = top+"px";
		
	if(frame == true) 
	{
		document.getElementById('cuadroIframeFrame').style.display = "block";
		document.getElementById('cuadroIframeFrame').style.height = (alto - 40) + 'px';
	}
	else document.getElementById('cuadroIframeFrame').style.display = "none";
}
function cerrarCuadroFrame()
{
	document.getElementById('fondoOscuroFrame').style.display = "none";	
	document.getElementById('cuadroDialogoFrame').style.display = "none";
}
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
function validaOfi(valor)
{
	var expresion = /DGR-[A-D]{1}-\d{4}\/(18|19)/;   
	var res = expresion.test(valor);
	return res;
}
function validaCral(valor)
{
	var expresion = /DGR-SS\/[A-D]{1}-\d{4}\/\d{2}$/;   
	var res = expresion.test(valor);
	return res;
}
function validaCralAsis(valor)
{
	var expresion = /DGR-SS\/\d{4}\/\d{4}$/;   
	var res = expresion.test(valor);
	return res;
}

function validaSolBaja(valor)
{
	var expresion = /AEGF-\d{4}\/2015/;   
	var res = expresion.test(valor);
	return res;
}
function validaVolante(valor)
{
	var expresion = /\d{4}\/15/;   
	var res = expresion.test(valor);
	return res;
}
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
function comprobarForm(form,estado,volantes,oficios,cral,SolventacionBaja)
{
	
	var mensaje = "Los campos marcados en color rojo son obligatorios";
	var elementos = "";
	var error = 0;
	var adver = 0;
	frm = document.forms[form];
	for(i=0; ele=frm.elements[i]; i++)
	{
		//elementos += " Nombre = "+ele.name+" | Tipo = "+ele.type+" | Valor = "+ele.value+"\n";
		if((ele.value == ' ' || ele.value == '' || ele.value == 'nada') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
		{
			mensaje += '\n - '+ele.name;	
			document.getElementById(ele.name).style.borderColor = 'red';
			error++;	
		} 		
		if((ele.value != '') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
			document.getElementById(ele.name).style.borderColor = 'silver';
	}
//----------------------------------------------------------------------------
	if(error != 0)
	{
			alert(mensaje);
			return false;
	}
	else 
	{
		//-------------------------
		if(estado != null)
		{
			if(estado == 2) var newEdo = "OPINIÓN PARA EMISION / CORRECCIÓN DEL PLIEGO";
			if(estado == 3) var newEdo = "DEVOLUCIÓN DEL PPO";
			if(estado == 4 || estado == 5) var newEdo = "EN PROCESO DE NOTIFICACION";
			if(estado == 6) var newEdo = "NOTIFICADO";
			if(estado == 7) var newEdo = "ET, PO Y OFICIOS NOTIFICADOS REMITIDOS A LA UAA";
			if(estado == 8) var newEdo = "";
			if(estado == 9) var newEdo = "";
			if(estado == 10) var newEdo = "";
			
			  var advertencia = 'La accion cambiara a: \n \n - '+newEdo;
			  advertencia += "\n \n ¿Desea Continuar?";
			  
			  var res = confirm(advertencia);
			  if(res == true) 
			  { 
			    if(correo != '') window.location = correo;
			  	frm.submit(); 
			  }
			  else { return false }
		}

		//if(extra1 == 'correo') window.location = extra2;
		//frm.submit();
		return true;
	}
	//alert(elementos);
}
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
function contador(field, countfield, maxlimit) 
{
	if (field.value.length > maxlimit)	field.value = field.value.substring(0, maxlimit);
	else document.getElementById(countfield).innerHTML = maxlimit - field.value.length;
}
//-------------------------------------------------------------------------------
function validaNum(miNum)
{
	var numDec = /^(\d{1,3}\,*)(\d{3}\,?)*(.\d{2})?$/;
	var num = document.getElementById(miNum).value;
	
 	var numero = new oNumero(num)
	var nuevoNum = numero.formato(2, true);
	
	if(nuevoNum.search(numDec) == -1) 
	{
		document.getElementById(miNum).style.borderColor = 'red';
		document.getElementById(miNum).focus();
		return false
	}
	else
	{
		document.getElementById(miNum).value = nuevoNum;
		document.getElementById(miNum).style.borderColor = 'silver';
		return true
	}
}
function calculaMontos()
{
	var mir = document.getElementById('montoIR').value;
	var mr = document.getElementById('montoR').value;
	var ma = document.getElementById('montoA').value;
	var mc = document.getElementById('montoC').value;
	var mj = document.getElementById('montoJ').value;
	
	var coma = /,/g;
	mir = parseFloat(mir.replace(coma,""));	
	mr = parseFloat(mr.replace(coma,""));
	ma = parseFloat(ma.replace(coma,""));
	mc = parseFloat(mc.replace(coma,""));
	mj = parseFloat(mj.replace(coma,""));
	
	var suma = mr+ma+mc+mj;
	var TPO = mir - suma;

	document.getElementById('montoPO').value = TPO;

	validaNum('montoIR');
	validaNum('montoR');
	validaNum('montoA');
	validaNum('montoC');
	validaNum('montoJ');
	validaNum('montoPO')
}
//---------------------------------------------------------------------------------------------------------------------------
function comprobarFormMontos(form,tipo,accion,correo,estado)
{
	//alert('m');
	var mensaje = "Los campos marcados en color rojo son obligatorios o estan mal capturadas las cantidades";
	var elementos = "";
	var error = 0;
	var mir = document.getElementById('montoIR').value;
	var mr = document.getElementById('montoR').value;
	var ma = document.getElementById('montoA').value;
	var mc = document.getElementById('montoC').value;
	var mj = document.getElementById('montoJ').value;	
	var mp = document.getElementById('montoPO').value
	
	var coma = /,/g;
	mir = parseFloat(mir.replace(coma,""));	
	mr = parseFloat(mr.replace(coma,""));
	ma = parseFloat(ma.replace(coma,""));
	mc = parseFloat(mc.replace(coma,""));
	mj = parseFloat(mj.replace(coma,""));
	
	var suma = mr+ma+mc+mj;
	var TPO = mir - suma;
	document.getElementById('montoPO').value = TPO;
	
	frm = document.forms[form];
	for(i=0; ele=frm.elements[i]; i++)
	{
		elementos += " Nombre = "+ele.name+" | Tipo = "+ele.type+" | Valor = "+ele.value+"\n";
		if((ele.value == ' ' || ele.value == '' || ele.value == 'nada') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image'))
		{
			//mensaje += '\n - '+ele.name;	
			document.getElementById(ele.name).style.borderColor = 'red';
			error++;	
		} 		
		if((ele.value != '') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image'))
			document.getElementById(ele.name).style.borderColor = 'silver';
	}
	
	if(!validaNum('montoIR')) error++;
	if(!validaNum('montoR')) error++;
	if(!validaNum('montoA')) error++;
	if(!validaNum('montoC')) error++;
	if(!validaNum('montoJ')) error++;
	if(!validaNum('montoPO')) error++;
	
	if(error != 0)	alert(mensaje);
	else 
	{
		if(tipo == 'confirma')
		{
			  var advertencia = 'El estado de la accion '+accion+' cambiara a: \n \n - '+estado;
			  advertencia += "\n\n  - Monto Irregularidad = "+formatNumber(mir,"$");
			  advertencia += "\n  - Monto Resarcido = "+formatNumber(mr,"$");
			  advertencia += "\n  - Monto Justificado= "+formatNumber(mj,"$");
			  advertencia += "\n  - Monto Comprobado = "+formatNumber(mc,"$");
			  advertencia += "\n  - Monto Aclarado = "+formatNumber(ma,"$");
			  advertencia += "\n  - Monto Pliego = "+formatNumber(document.getElementById('montoPO').value,"$");
			  
			  advertencia += "\n \n ¿Desea Continuar?";
			  
			  var res = confirm(advertencia);
			  if(res == true) 
			  { 
			    if(correo != '') window.location = correo;
			  	frm.submit(); 
			  }
			  else { return false }
		}
	}
	//alert(elementos);
}
//-------------------------------------
function formatNumber(num,prefix){
prefix = prefix || "";
num += "";
var splitStr = num.split(".");
var splitLeft = splitStr[0];
var splitRight = splitStr.length > 1 ? "." + splitStr[1] : "";
var regx = /(\d+)(\d{3})/;
while (regx.test(splitLeft)) {
splitLeft = splitLeft.replace(regx, "$1" + "," + "$2");
}
return prefix + splitLeft + splitRight;
}
//-------------------------------------------------------------
function actualizaReloj(idHora1,idHora2) 
{
	/* Capturamos la Hora, los minutos y los segundos */
	marcacion = new Date();
	/* Capturamos la Hora */
	Hora = marcacion.getHours();
	/* Capturamos los Minutos */
	Minutos = marcacion.getMinutes()
	/* Capturamos los Segundos */
	Segundos = marcacion.getSeconds()
	/*variable para el apóstrofe de am o pm*/
	dn = ""
	if (Hora == 0) Hora = 12
	/* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
	if (Hora <= 9) Hora = "0" + Hora
	if (Minutos <= 9) Minutos = "0" + Minutos
	if (Segundos <= 9) Segundos = "0" + Segundos
	/* Termina el Script del Reloj */
	
	/*Script de la Fecha */
	
	var Dia = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
	var Mes = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre","Octubre", "Noviembre", "Diciembre");
	var Hoy = new Date();
	var Anio = Hoy.getFullYear();
	var Fecha = Dia[Hoy.getDay()] + " " + Hoy.getDate() + " de " + Mes[Hoy.getMonth()] + " de " + Anio + " - ";
	
	/* Termina el script de la Fecha */
	
	/* Creamos 2 variables para darle formato a nuestro Script */
	var Script, Total
	
	/* En Reloj le indicamos la Hora, los Minutos y los Segundos */
	Script = Fecha + Hora + ":" + Minutos + ":" + Segundos + " " + dn
	
	/* En total Finalizamos el Reloj uniendo las variables */
	Total = Script
	
	/* Capturamos una celda para mostrar el Reloj */
	document.getElementById(idHora1).innerHTML = Total
	document.getElementById(idHora2).value = Hora + ":" + Minutos + ":" + Segundos;
	
	/* Indicamos que nos refresque el Reloj cada 1 segundo */
	setTimeout("actualizaReloj('hora_cambio1','hora_cambio2')",1000);
}
function cargarAcciones()
{
	$.ajax
		({
			beforeSend: function(objeto)
			{
			 $('#resAcciones').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
			 //alert('hola');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar \n - Exito = "+exito)
				//if(exito=="success"){ alert("Y con éxito");	}
			},
			type: "POST",
			url: "procesosAjax/ajax_busqueda_acciones.php",
			data: "",
			error: function(objeto, quepaso, otroobj)
			{
				alert("Fallo la Carga de acciones \n - Tipo error = "+quepaso);
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				$('#resAcciones').html(datos); 
			}
		});
}

function cargarAccionespfrr()
{
	$.ajax
		({
			beforeSend: function(objeto)
			{
			 $('#resAcciones').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
			 //alert('hola');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar \n - Exito = "+exito)
				//if(exito=="success"){ alert("Y con éxito");	}
			},
			type: "POST",
			url: "procesosAjax/pfrr_busqueda_accion.php",
			data: {
				valor:$("#noAccion").val(),
				nivel:$("#indexNivel").val(),
				direccion:$("#indexDir").val()
				},
			error: function(objeto, quepaso, otroobj)
			{
				alert("Fallo la Carga de acciones \n - Tipo error = "+quepaso);
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				var res = datos.split("-|-")
				$('#resAcciones').html(res[0]); 
			}
		});
}



function cerrarMsg()
{
	$("#message-green").fadeOut();
}
//-------------------------------------------------------------------------------------------------
//-------------------------------- funciones del calendario ---------------------------------------
//-------------------------------------------------------------------------------------------------
var fechanueva = new Date();
var ano = fechanueva.getFullYear();

var myFecha = new Date();
var MyDia = myFecha.getDate();
var myMes = myFecha.getMonth() + 1;
var myAno = myFecha.getFullYear();
//------------------------------------ deshabilita dias -------------------------------------------
var disabledDays = 
	//m-d-aaaa
	[
	"1-1-"+ano, "1-2-"+ano, "1-3-"+ano, "1-4-"+ano, "1-7-"+ano,
	"2-4"+ano, 
	"3-18-"+ano,
	"4-18-"+ano, "4-19-"+ano,
	"5-1-"+ano,
	"7-22-"+ano,"7-23-"+ano,"7-24-"+ano,"7-25-"+ano,"7-26-"+ano,
	"9-16-"+ano,
	"11-18-"+ano,
	"12-23-"+ano,"12-24-"+ano,"12-25-"+ano,"12-26-"+ano,"12-27-"+ano,"12-30-"+ano,"12-31-"+ano
	 ];
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
function fechaJS(fecha)
{
	array_fecha = fecha.split("/") 
	var dia = array_fecha[0];
	var mes = (array_fecha[1]-1); 
	var ano = (array_fecha[2]);
	var fechaDate = new Date(ano,mes,dia) 
	return fechaDate;
}
//------------------------ DEHABILITA DIAS -------------------------------------
function noLaborales(date) 
{
	var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
	var day = date.getDay();
	for (i = 0; i < disabledDays.length; i++) 
	{
		if (day == 0 || day == 6) {	return [false, ""]	}
		if($.inArray((m+1) + '-' + d + '-' + y,disabledDays) != -1) {return [false];}
	}
	return [true];
}
//------------------------ FUNCION SUMA DIAS ---------------------------------
function restaNolaborables(fecha,dias) 
{
	//fecha es dd/mm/aaaa 
	fc = fecha.split("/");
	nfecha = new Date(fc[2],(fc[1]-1),fc[0]); 

	dd = nfecha.getDate();
	mm = nfecha.getMonth();
	yy = nfecha.getFullYear();
	//alert("fecha: "+nfecha+"\nMes: "+mm);
	
	for (i = 0; i < dias; i++) 
	{
		var day = nfecha.getDay();
		
		//si la fecha es sabado o domingo ó esta en la cadena disableDays no cuenta en conteo
		if (day == 0 || day == 6) {	i-- }
		if($.inArray((mm+1) + '-' + dd + '-' + yy,disabledDays) != -1) { i-- }
		// Incrementa un dia (86400000 es un dia en milisegundos)
		nfecha.setTime(nfecha.getTime()+(86400000*1));
	}
	fechaOK = nfecha.getDate()+"/"+(nfecha.getMonth()+1)+"/"+nfecha.getFullYear();
	//alert(fechaOK);
	return nfecha;
}
//------------------------ FUNCION SUMA NATURALES ---------------------------------
function sumaNaturales(fecha,dias) 
{
	//fecha es dd/mm/aaaa 
	fc = fecha.split("/");
	nfecha = new Date(fc[2],(fc[1]-1),fc[0]); 
	//de la nueva fecha sacamos los datos
	dd = nfecha.getDate();
	mm = nfecha.getMonth();
	yy = nfecha.getFullYear();
	//alert("fecha: "+nfecha+"\nMes: "+mm);
	
	for (i = 0; i < dias; i++) 
	{
		var day = nfecha.getDay();
		
		//si la fecha es sabado o domingo ó esta en la cadena disableDays no cuenta en conteo
		//if (day == 0 || day == 6) {	i-- }
		//if($.inArray((mm+1) + '-' + dd + '-' + yy,disabledDays) != -1) { i-- }
		// Incrementa un dia (86400000 es un dia en milisegundos)
		nfecha.setTime(nfecha.getTime()+(86400000*1));
	}

	var miDia = ("0" + nfecha.getDate()).slice(-2);
	var miMes = ("0" + (nfecha.getMonth()+1)).slice(-2);
	
	fechaOK = miDia+"/"+miMes+"/"+nfecha.getFullYear();
	//alert(fechaOK);
	return fechaOK;
}
function diasMes(mes,anno) 
{	
	  mes = parseInt(mes);
	  anno = parseInt(anno);
      
	  switch (mes) 
	  {
	    case 1 : case 3 : case 5 : case 7 : case 8 : case 10 : case 12 : return 31;
		case 2 : return (anno % 4 == 0) ? 29 : 28;
	  }
	  return 30;
   }
var MyDias = diasMes(myMes,myAno);
//alert(MyDias);
//--------------------------------------------------------------
//--------------------------------------------------------------
//--------------------------------------------------------------
function oNumero(numero){ 
	//Propiedades 
	this.valor = numero || 0 
	this.dec = -1; 
	
	//Métodos 
	this.formato = numFormat; 
	this.ponValor = ponValor; 
	
	//Definición de los métodos 
	function ponValor(cad) 
	{ 
	if (cad =='-' || cad=='+') return 
	if (cad.length ==0) return 
	if (cad.indexOf('.') >=0) 
	this.valor = parseFloat(cad); 
	else 
	this.valor = parseInt(cad); 
	} 
	
	function numFormat(dec, miles) 
	{ 
	var num = this.valor, signo=3, expr; 
	var cad = ""+this.valor; 
	var ceros = "", pos, pdec, i; 
	for (i=0; i < dec; i++) 
	ceros += '0'; 
	pos = cad.indexOf('.') 
	if (pos < 0) 
	cad = cad+"."+ceros; 
	else 
	{ 
	pdec = cad.length - pos -1; 
	if (pdec <= dec) 
	{ 
	for (i=0; i< (dec-pdec); i++) 
	cad += '0'; 
	} 
	else 
	{ 
	num = num*Math.pow(10, dec); 
	num = Math.round(num); 
	num = num/Math.pow(10, dec); 
	cad = new String(num); 
	} 
	} 
	pos = cad.indexOf('.') 
	if (pos < 0) pos = cad.lentgh 
	if (cad.substr(0,1)=='-' || cad.substr(0,1) == '+') 
	signo = 4; 
	if (miles && pos > signo) 
	do{ 
	expr = /([+-]?d)(d{3}[.,]d*)/ 
	cad.match(expr) 
	cad=cad.replace(expr, RegExp.$1+','+RegExp.$2) 
	} 
	while (cad.indexOf(',') > signo) 
	if (dec<0) cad = cad.replace(/./,'') 
	return cad; 
	} 
} 
 //------------ pestañas -------------------
function ocultaAll() 
{
	$('.todosContPasos').removeClass("pActivo");
	$('.todosContPasos').hide();
	$('.todosPasos').removeClass("pasosActivo");
	$('.todosNP').removeClass('noPasoActivo');
	$('.todosNP').addClass('noPaso'); 
} 
function muestraPestana(divId)
{
	ocultaAll();
	$('#p'+divId).removeClass('pInactivo');
	
	$('#p'+divId).addClass('pActivo');	
	$('#paso'+divId).addClass('pasosActivo'); 
	$('#np'+divId).addClass('noPasoActivo');
		
	$('#p'+divId).fadeIn();
}
function verPdf(archivo)
{
 new mostrarCuadro2(600,800,"Visor de Documento "+archivo,10,"cont/po_verPdf.php","archivo="+archivo);//alto,ancho,titulo,top,pagina,datos
 //$("#cuadroRes2").html(texto);	
}
