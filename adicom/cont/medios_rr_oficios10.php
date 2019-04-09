<style>
.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
}
.volLista
{
	height:300px;
	overflow:auto;	
}
</style>
<link href="css/estilos_medios.css" rel="stylesheet" type="text/css" media="all" />

<script> 
$$(function() {
	$$( "#fechaPO" ).datepicker({
		// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 maxDate: 0,
		 beforeShowDay: noLaborales
		 /*onClose: function( selectedDate ) 
		 { 
			$$( "#acuseCral" ).datepicker( "option", "minDate", selectedDate );  
		 }*/
	});
});

function muestraPestanaVol(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
	
	if(divId == 2){
		$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volLista").load("procesosAjax/medios_rr_oficio_busca.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 
	if(divId == 3){
		$$('#volListaOtros').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volListaOtros").load("procesosAjax/po_oficio_busca_otros.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 
	if(divId == 4){
		$$('#volLista2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volLista2").load("procesosAjax/po_oficio_busca_2013.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 
}

function comprobarFormulario(form,estado,volantes,oficios,cral,SolventacionBaja)
{
	//alert(' Campos = '+oficios);
	
	var mensaje = "";
	var elementos = "";
	var error = 0;
	var adver = 0;
	var VcsMenEdos = 0;
	var VcsMenCita = 0;
	var VcsMenEdos2 = 0;
	var VcsMenEdos3 = 0;
	var VcsMenEdos4 = 0;
	var VcsMenEdos5 = 0;
	//--------------- validamos acciones segun tipo oficio -------------
	var mut_edos = document.oficioForm.elements["accionEstado[]"];
	//var mut_edos = document.getElementsByName["accionEstado[]"];
	//------------------------------------------------------------------
	frm = document.forms[form];
	for(i=0; ele=frm.elements[i]; i++)
	{
		//elementos += " Nombre = "+ele.name+" | Tipo = "+ele.type+" | Valor = "+ele.value+"\n";
		if(ele.name != 'accionvolante' && (ele.value == ' ' || ele.value == '' || ele.value == 'nada') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
		{
			//mensaje += '\n - '+ele.name;	
			document.getElementById(ele.name).style.borderColor = 'red';
			error++;	
		} 		
		if((ele.value != '') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
			document.getElementById(ele.name).style.borderColor = 'silver';
	}
	if(error != 0) mensaje += " - Los campos marcados en color rojo son obligatorios";
	//---------------- validamos acciones segun tipo oficio ----------------------
	if( $$('#tipoOficio').val() == 'asistencia')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 2)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) acción(es) debe(n) estar en estado *** Opinion del PPO *** ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
		$$(".oficioAS").each(function() {
			if($$(this).val() != 0)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - Esta acción tiene un oficio de Asistencia Jurídica pendiente. Acuse el oficio para poder generar otro. ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}

	/*if( $$('#tipoOficio').val() == 'remisionUAA')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 6)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La acción debe estar en estado *** Notificado *** ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}
	// validaciones EF e ICC 
	if(($$('#tipoOficio').val() == 'notificacionEF' || $$('#tipoOficio').val() == 'notificacionICC') && $$('#monto').val() == '')
	{
		mensaje += "\n - La accion no tiene monto, favor de chacar el Monto IR o Monto Modificado.";
		error++;
	}

	
	if($$('#tipoOficio').val() == 'notificacionEF' && $$("#totalNoAcciones").val() > 1)
	{
		mensaje += "\n - La notificacion a Entidad Fiscalizada solo debe contener una acción";
		error++;
	}
		
	if($$('#tipoOficio').val() == 'notificacionICC' && $$("#totalNoAcciones").val() > 1)
	{
		mensaje += "\n - La notificacion a I.C.C. solo debe contener una acción";
		error++;	
	}


	if( $$('#tipoOficio').val() == 'notificacionEF' || $$('#tipoOficio').val() == 'notificacionICC' )
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 5)
			{
				if(VcsMenEdos2 == 0)
				{
					mensaje += "\n\n - Para notificar esta acción debe estar en estado: \n\n *** En proceso de Notificación *** \n\n ";
					VcsMenEdos2++;
				}
				error++;	
			}
		});
		// notificacion a EF comprobamos oficios
		if($$('#tipoOficio').val() == 'notificacionEF')
		{
			$$(".oficioEF").each(function() {
				if($$(this).val() != 0)
				{
						mensaje += "\n\n - Esta acción ya tiene un oficio EF pendiente ";
						error++;	
				}
			});
		}
		// notificacion a ICC comprobamos oficios
		if($$('#tipoOficio').val() == 'notificacionICC')
		{
			$$(".oficioICC").each(function() {
				if($$(this).val() != 0)
				{
						mensaje += "\n\n - Esta acción ya tiene un oficio ICC pendiente ";
						error++;	
				}
			});
		}
		
	}*/

//----------------------------------------------------------------------------
	if(error != 0)
	{
			alert(mensaje);
			return false;
	}
	else 
	{//-------------------------
		return true;
	}
}
//--------------------------------------
var nextinput = 0;
var accionesNum = 0;
//--------------------------------------
function agregarCampos(valor,estado,estadoTxt,idPresunto,accion,presunto)
{
	var igual = 0;
	var totalAcciones = $$("#totalAcciones").val();
	var totalPresuntos = $$("#totalPresuntos").val();
	//---------------- Quitamos mensaje al agregar ----------------------------
	$$('#mensajeRec').fadeOut();
	//-------------------------------------------------------------------------
	$$('.camposInputAcciones').each( function(){
	  var $$this = $$(this);
	  //$this.css( 'text-decoration' , 'underline' );
	  if(valor == $$this.val()) igual++;
	});
	//-------------------------------------------------------------------------
	if(igual == 0)
	{
		nextinput++;
		accionesNum++;
		$$("#accionesNo").html(accionesNum);
		$$("#totalNoAcciones").val(accionesNum);
		campo = '<li id="rut'+nextinput+'" class="camposLi">';
		campo += '<input type="text" size="80" class="redonda5 camposInputAcciones" id="preAccion[]"  name="preAccion[]" value="'+valor+'"  readonly/>';
		campo += '<input type="text" size="80" class="redonda5 camposInputAcciones" id="nomPresunto[]"  name="nomPresunto[]" value="'+presunto+'"  readonly/>';
		campo += '<input type="text" size="35" class="redonda5 camposInputAcciones" id="idPresunto[]"  name="idPresunto[]" value="'+idPresunto+'"  readonly/>';
		campo += '<input type="text" size="35" class="redonda5 camposInputAcciones" id="accion[]"  name="accion[]" value="'+accion+'"  readonly/>';
		campo += '<input type="text" size="5" class="redonda5 camposInputEstados" id="accionEstado[]"  name="accionEstado[]" value="'+estado+'"  readonly/>';		
		//campo += '<input type="hidden" size="5" class="redonda5 oficioEF" id="oficioEF"  name="oficioEF[]" value="'+oficioEF+'"  readonly/>';		
		//campo += '<input type="hidden" size="5" class="redonda5 oficioICC" id="oficioICC"  name="oficioICC[]" value="'+oficioICC+'"  readonly/>';		
		//campo += '<input type="hidden" size="5" class="redonda5 oficioAS" id="oficioAS"  name="oficioAS[]" value="'+oficioAS+'"  readonly/>';		
		//campo += '<input type="hidden" size="5" class="redonda5 monto" id="monto"  name="monto[]" value="'+monto+'"  readonly/>';		
		campo += '<span class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </span>';
		campo += '<div>'+estadoTxt+'</div>';
		campo += '</li>';
		
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalAcciones").val(totalAcciones.concat(accion+"|"));
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalPresuntos").val(totalPresuntos.concat(presunto+"|"));
		//----------- agregamos campo y boirramos value de accion -------------
		$$("#camposAcciones").append(campo);
		//$$('#accionvolante').attr('value') = "";
		//$$('#accionvolante').val('');
		//-------------------------------------------------------
	}
	else 
	{ 
		//$$("#accionvolante").focus();
		//alert ("Esta acción ya la ha ingresado...");
		//$$('#accionvolante').attr('value') = "";
	}
}
//----------------------------------------------------------------------------
function elimina_me(elemento)
{
	$$("#"+elemento).remove();
	accionesNum--;
	$$("#accionesNo").html(accionesNum);
	$$("#totalNoAcciones").val(accionesNum);
}
//---------------------------------------
function muestraCral(valor)
{
	 if(valor == 2 || valor == 10)
	 { 
	 	//$$("#tablaCral").fadeIn();
		$$('#cral').attr('disabled', false);
		$$('#fechaCral').attr('disabled', false);
		$$('#acuseCral').attr('disabled', false);
	 }
	 else 
	 {
		//$$("#tablaCral").fadeOut();
		$$('#cral').attr('disabled', true);
		$$('#fechaCral').attr('disabled', true);
		$$('#acuseCral').attr('disabled', true);
	 }
}

//----------------- completa remitentes ------------------------
/*function completa()
{
	$$.ajax
	({
		beforeSend: function(objeto)
		{
			//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
		},
		complete: function(objeto, exito)
		{
			//alert("Me acabo de completar")
			//if(exito=="success"){ alert("Y con éxito"); }
		},
		type: "POST",
		url: "procesosAjax/po_busqueda_remitente_oficios.php",
		data: {accion1:$$('#accionVinculada_1').val(),acciones:$$('#totalAcciones').val(), tipo:$$('#tipoOficio').val(), },
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé");
			//alert("Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			//alert(datos);
			var remi= datos.split("|");

			if(remi[5]!=0 && $$('#tipoOficio').val() =="asistencia") alert("Las UUA's deben ser las mismas.") 
			else {
				//$$("#remitente").val(remi[0]);
				//$$("#cargo").val(remi[1]);
				//$$("#dependencia").val(remi[2]);
				$$("#oficioRef").val(remi[3]);
				$$("#asunto").val(remi[4]);
			}
		}
	});
}
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------*/

function generarOficio()
{
	//alert($$("#oficioForm").serialize());
	//alert($$('#accionVinculada_1').val())
	var na = $$('#accionVinculada_1').val();
	var tipoOficio = $$("#tipoOficio").val();
	if(comprobarFormulario('oficioForm'))
	{
		//---------- verificamos que existan acciones --------------
		if($$('.camposInputAcciones').length)
			var totalAcciones = 1;
		else 
		{
			var totalAcciones = 0;
			 alert("Ingrese por lo menos una acción...");
		}
		//-------------------------------------------------------
		if(totalAcciones)
		{
			//-------------------------------------------------------
			$$.ajax
			({
				beforeSend: function(objeto)
				{
					$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					$$('#generaOficio').attr("disabled",true);
					$$('#generaOficio').val('Generando Oficio espere...');
					$$('#generaOficio').css( "background", "gray" );
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/medios_rr_oficio_genera.php",
				//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
				data: $$("#oficioForm").serialize(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					
					var dat = datos.split("|");
					fo = dat[0];
					po = dat[1];
					cp = dat[2];
					ef = dat[3];
					mm = dat[4];
					ua = dat[5];
					dir = dat[6];
					car = dat[7];
					nRe = dat[8];
					cRe = dat[9];
					dRe = dat[10];
					fOf = dat[11];
					foj = dat[12];
					fSi = dat[13];
					hSi = dat[14];
					ini = dat[15];
					acc = dat[16];
					folioef = dat[17];
					gobernador = dat[18];
					cargo = dat[19];
					fechaofi = dat[20];
					folioicc = dat[21];
					fechaofiicc = dat[22];
					acuse=dat[23];
					titular=dat[24];
					cargoicc=dat[25];
										
					var urlCadena = "na="+acc+"&fo="+fo+"&po="+po+"&cp="+cp+"&ef="+ef+"&mm="+mm+"&ua="+ua+"&dir="+dir+"&car="+car+"&nRe="+nRe+"&cRe="+cRe+"&dRe="+dRe+"&fOf="+fOf+"&foj="+foj+"&fSi="+fSi+"&hSi="+hSi+"&ini="+ini+"&folioef="+folioef+"&gobernador="+gobernador+"&cargo="+cargo+"&fechaofi="+fechaofi+"&folioicc="+folioicc+"&fechaofiicc="+fechaofiicc+"&acuse="+acuse+"&titular="+titular+"&cargoicc="+cargoicc;
					
					// ------------------ RESET campos en blanco --------------
					$$(".redonda5").val("");
					$$("#camposAcciones").html(""); 
					//------------ reiniciamos conteo de acciones -------------
					$$("#totalNoAcciones").val("0"); 
					accionesNum = 0;
					//---------------------------------------------------------
					$$('#generaOficio').attr("disabled",false);
					$$('#generaOficio').val('Generar Oficio');
					$$('#generaOficio').css( "background", "#333" );
					
											//mostramos cuadro donde se insertara el html en el id 'cuadroRes'
						new mostrarCuadro(200,500,"Oficio generado...",150)
						$$("#cuadroRes").html("<center><h2> <br><br> Se generó el oficio <br> "+fo+" </h2></center>");	

				}
			});
		}//end estados
	}//end confirm
}

//------------------------------- AUTOCOMPLETE ACCION --------------------------------

$$(function() {
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#remitente").autocomplete({
		  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
				source: function( request, response ) {
					
					if($$('#tipoOficio').val() == 'notificacionEF')	var tipo = "notificacionEF";
					else var tipo = "normal";
					
					$$.ajax({
						type: "POST",
						url: "procesosAjax/po_busqueda_remitente.php",
						dataType: "json",
						data: {
							term: request.term,
							acciones: $$("#totalAcciones").val(),
							tipo: tipo
						},
						success: function( data ) {
							response(data);
							//alert(urlAjax+" - "+$$("#totalAcciones").val());
							//muestraListados();
						}
					});
				 },
			   minLength: 2,
		   select: 
		   function( event, ui ) 
		   {  
			//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
			$$("#cargo").val(ui.item.cargo);
			$$("#dependencia").val(ui.item.dependencia);
			$$("#oficioRef").focus();
			
		  }
			});//end
}); 
//---------------------------------------------------------------------------
$$(function() {
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#remitente").autocomplete({
		  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
				source: function( request, response ) {
					
					if($$('#<strong>tipoOficio</strong>').val() == 'notificacionICC')
						var tipo = "notificacionICC";
					else 
						var tipo = "normal";
					
						$$.ajax({
							type: "POST",
							url: "procesosAjax/po_busqueda_remitente.php",
							dataType: "json",
							data: {
								term: request.term,
								acciones: $$("#totalAcciones").val(),
								tipo: tipo
							},
							success: function( data ) {
								response(data);
								//alert(urlAjax+" - "+$$("#totalAcciones").val());
			  					//muestraListados();
							}
						});
				 },
			   minLength: 2,
		   select: 
		   function( event, ui ) 
		   {  
			//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
			$$("#cargo").val(ui.item.cargo);
			$$("#dependencia").val(ui.item.dependencia);
			$$("#oficioRef").focus();
			
		  }
			});//end
}); 
//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function() 
{
	 // configuramos el control para realizar la busqueda de los productos
	 $$("#txtRecurrente").autocomplete({
	  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						beforeSend: function(objeto){ $$('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "procesosAjax/medios_rr_busca_recurrente.php",
						dataType: "json",
						data: {
							term: request.term,
							direccion: $$("#indexDir").val(),
							nivel: $$("#indexNivel").val()
							//accion: $$("#---").val()
						},
						success: function( data ) {
							$$('#idLoad').html('');
							response(data);
							
		  					//muestraListados();
						}
					});
			 },
		   minLength: 2,
	  select: function( event, ui ) {  
//reseteamos campos al seleccionar accion
		$$("#tipoOficio").val('');
		$$("#recurso").val('');
		$$("#remitente").val('');
		$$("#cargo").val('');
		$$("#dependencia").val('');
		$$("#oficioRef").val('');
		$$("#asunto").val('');
//ocultamos todos los campos 
 		$$(".opciones").css("display","none");
//mostramos solo los options que se debe
			if(ui.item.estado == 35) {
				$$("#tipoOficio").append(' <option class="recurso" value="35"> Requerimientos al Recurrente </option> ');
			}
			if(ui.item.estado == 39) {
				$$("#tipoOficio").append(' <option class="recurso" value="34">Oficio de Admisión del RR</option> ');
				$$("#asunto").val("Con fundamento en lo dispuesto por el artículo 70, I y II, párrafo segundo de la LFRCF, se admite a trámite el Recurso de Reconsideración interpuesto.");
			}
			if(ui.item.estado == 39.1) {
				 $$("#tipoOficio").append(' <option class="recurso" value="36">Oficio de Desechamiento del RR</option> ');
				 $$("#asunto").val("Se desecha.");
			}
			if(ui.item.estado == 38) {
				 $$("#tipoOficio").append(' <option class="recurso" value="45"> </option> ');
				 //$$("#oficioRef").val("");
				 $$("#asunto").val("Se solicita la documentación solicitada que se indica.");
			}
			//-------------------------------------------------
			//$$("#remitente").val(ui.item.presunto);
			//$$("#cargo").val(ui.item.cargo);
			$$("#oficioRef").val(ui.item.referencia);
			
			//-------------------------------------------------
			agregarCampos(ui.item.value,ui.item.estadoTxt,ui.item.estado,ui.item.accion,ui.item.presunto);   /////////////////////////////
	  },
	  change: function (event, ui) {
		   if(!ui.item)  $$(event.target).val("");
    	},
	  focus: function (event, ui) {
        return false;
    }
	});//end
}); 
//---------------------------------- BUSCAR OFICIOS -----------------------------------	
//--------------------------------------------------------------------------------------
$$( document ).ready(function() {
	
	if($$("#indexDir").val() == "DG") userDirec = "D";
	else userDirec = $$("#indexDir").val();
	
	$$("#userForm").val($$("#indexUser").val());
	$$("#dirForm").val(userDirec);
	$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  	$$("#volLista").load("procesosAjax/medios_rr_oficio_busca.php");
	// --------------- AGREGA el option administrativo a select ---------------
	//if($$("#indexDir").val() == "DG") $$('#tipoOficio').append('<option value="administrativo" selected="selected">Administrativo</option>');
	$$("#txtRecurrente").focus();
	
});
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
$$(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
	$$("#text").keyup(function() {
		$$.ajax
			({
				beforeSend: function(objeto)
				{
				 $$('#volLista').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
				 //alert('hola');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar \n - Exito = "+exito)
					//if(exito=="success"){ alert("Y con éxito");	}
				},
				type: "POST",
				url: "procesosAjax/po_oficio_busca.php",
				data: {
						texto:$$('#text').val(),
						usuario:$$('#indexUser').val(),
						direccion:$$('#indexDir').val(),
						nivel:$$('#indexNivel').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
					//alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					$$('#volLista').html(datos); 
				}
			});
	});
});
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
$$(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
	$$("#textOtros").keyup(function() {
		$$.ajax
			({
				beforeSend: function(objeto)
				{
				 $$('#volListaOtros').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
				 //alert('hola');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar \n - Exito = "+exito)
					//if(exito=="success"){ alert("Y con éxito");	}
				},
				type: "POST",
				url: "procesosAjax/po_oficio_busca_otros.php",
				data: {
						texto:$$('#textOtros').val(),
						usuario:$$('#indexUser').val(),
						direccion:$$('#indexDir').val(),
						nivel:$$('#indexNivel').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
					//alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					$$('#volListaOtros').html(datos); 
				}
			});
	});
});
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
$$(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
	$$("#text2").keyup(function() {
		$$.ajax
			({
				beforeSend: function(objeto)
				{
				 $$('#volLista2').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
				 //alert('hola');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar \n - Exito = "+exito)
					//if(exito=="success"){ alert("Y con éxito");	}
				},
				type: "POST",
				url: "procesosAjax/po_oficio_busca_2013.php",
				data: {
						texto:$$('#text2').val(),
						usuario:$$('#indexUser').val(),
						direccion:$$('#indexDir').val(),
						nivel:$$('#indexNivel').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
					//alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					$$('#volLista2').html(datos); 
				}
			});
	});
});
function verOficio(folio,tipo)
{
	new mostrarCuadro(550,900,"Oficio...",20);
	if(tipo == 'notificacionEF')
		$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/formatoPM.pdf.php?consultaOficio=1&numFolio="+folio+"'></iframe>");	
	
	if(tipo == 'notificacionICC')
		$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/formatoICC.pdf.php?consultaOficio=1&numFolio="+folio+"'></iframe>");	

	if(tipo == 'remisionUAA')
		$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/formatoUAA.pdf.php?consultaOficio=1&numFolio="+folio+"'></iframe>");	
}
</script>
<style>
.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
}
.volLista
{
	height:300px;
	overflow:auto;	
}
.opciones{ display:none}
</style>


<div style="padding:10px">
    <!-- <div id='colorSelector'>hola</div> -->

	<div class="encVol">
        <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR OFICIO </div>
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR OFICIOS EMITIDOS </div>
        <div id='paso3' onclick="muestraPestanaVol(3)" class="todosPasos pasos"> BUSCAR OFICIOS ADMITIDOS (VOLANTES) </div>
        <div id='paso4' onclick="muestraPestanaVol(4)" class="todosPasos pasos"> OFICIOS 2013 </div>
    </div>
    
    <div id='p1' class="contOficios redonda10 todosContPasos">
        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="oficioForm" id="oficioForm" method="post" action="#">
        
        <table width="100%" align="center">
        <tr>
        	<td width="30%">
                <div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                                  <tr>
                    <td class="etiquetaPo" width="100"> <p>Recurrente:</p></td>
                    <td style="position:relative">

                      <input type="text" name="txtRecurrente" id="txtRecurrente" class="redonda5" size="35"  style="float:left;" > <span id="idLoad" style="float:left; padding:0 5px"></span>
                    </td>
                  </tr>
                    </td>
                  </tr>

                
                <?php //echo $_SESSION['nivel']; ?>
                
                                 <tr>
                    <td class="etiquetaPo" width="100"> <p>Tipo de oficio:</p></td>
                    <td>
                      <select name="tipoOficio" id="tipoOficio" class="redonda5" onchange="completa()">

                             <optgroup label="Proceso...">
								<?php
                                     $sql = $conexion->select("SELECT * FROM oficios_options WHERE estado = 'medios_rr' AND tipo = 'proceso' ", false); 
                                     while($r = mysql_fetch_array($sql)) echo "<option class='opciones' value='".$r['value']."'> &nbsp;&nbsp;&nbsp; - ".$r['texto']."</option>";
                                ?>
							</optgroup>
                      </select>
                    </td>
                  </tr>
                  
                 <tr id='trFecha' style="display:none">
                    <td class="etiquetaPo" width="100"> <p>Fecha del PO:</p></td>
                    <td>
                          <input type="text" name="fechaPO" id="fechaPO" class="redonda5" size="30" disabled="disabled">
                    </td>
                 </tr>
                 
                 <tr id='trFojas' style="display:none">
                    <td id="tdNomFojas" class="etiquetaPo" width="100"> <p>Fojas</p></td>
                    <td id="tdFojas">
         				

                    </td>
                 </tr>
                 
                    </td>
                  </tr>
                  </table> 
                </div>

              <td width="70%" rowspan="2" valign="top">
                   <div class="camposAcciones redonda5" id="camposAcciones" style="overflow:auto; padding:20px 20px 20px 30px">
                   <h3>Acciones Vinculadas <span id="accionesNo">0</span> </h3>
                   
              		</div>
                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                    <input type="hidden" name="totalPresuntos" id="totalPresuntos" size="35" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
              </td>
            </tr>
            <tr>
            	<td width="40%">
					<div class="volDivCont redonda5">
                     <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
                      <tr>
 
 
                        <td class="etiquetaPo" width="100"> <p>Dependencia:</p></td>
                        
                        <td>
                          <input type="text" name="dependencia" id="dependencia" class="redonda5" size="35">
                        </td>
                        <tr>
                        
                   
                        <td class="etiquetaPo" width="100"> <p>Referencia:</p></td>
                        
                        <td>
                          <input type="text" name="oficioRef" id="oficioRef" class="redonda5" size="35">
                        </td>
                      </tr>
                        <td class="etiquetaPo"> <p>Asunto:</p></td>
                        <td>
                          <textarea cols="50" rows="3"  class="redonda5" id='asunto' name='asunto'></textarea>
                        </td>
                      </tr>
                    </table>
                    </div>
                </td>
                <td width="50%" valign="top">
                <!--
                	celdas vacias
                -->
                </td>
            </tr>
            <tr>
            	<td colspan="3" align="center">
                <input name='userForm' id='userForm' type="hidden" value="" />
                <input name='dirForm' id='dirForm' type="hidden" value="" />
                <input type="button" class="submit-login" value="Generar Oficio" onclick="generarOficio()" id="generaOficio" />
                </td>
            </tr>
        </table>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
      <!-- ---------------------------------------------------------------------------- -->
      <div id='p2' style="display:none" class="contOficios redonda10 todosContPasos">
      	    <!-- <div style="float:right"><img src="images/help.png" /></div> -->
            <!-- <h3 class="poTitulosPasos">Listado de Oficios</h3> -->
            <h2>Buscar Oficio: 
            <input type="text" name="text" id="text" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista" id="volLista">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
        </div>
      <!-- ---------------------------------------------------------------------------- -->
      <div id='p3' style="display:none" class="contOficios redonda10 todosContPasos">
        <h2>Buscar Oficio: 
            <input type="text" name="textOtros" id="textOtros" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volListaOtros" id="volListaOtros">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
      </div>
      <!-- ---------------------------------------------------------------------------- -->
      <div id='p4' style="display:none" class="contOficios redonda10 todosContPasos">
        <h2>Buscar Oficio 2013: 
            <input type="text" name="text2" id="text2" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista2" id="volLista2">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
      </div>
      
</div><!-- end cont
 volantes -->