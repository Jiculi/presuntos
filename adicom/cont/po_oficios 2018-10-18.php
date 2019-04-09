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
	if(divId == 2)
	{
		$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volLista").load("procesosAjax/po_oficio_busca.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 
	if(divId == 3)
	{
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

	if( $$('#tipoOficio').val() == 'remisionUAA')
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
		//remision UAA
		if($$('#tipoOficio').val() == 'remisionUAA')
		{
			$$(".remuaa").each(function() {
				if($$(this).val() != 0)
				{
						mensaje += "\n\n - Esta acción ya tiene un oficio pendiente ";
						error++;	
				}
			});
		}
	}
	// validaciones EF e ICC 
	if(($$('#tipoOficio').val() == 'notificacionEF' || $$('#tipoOficio').val() == 'notificacionICC' || $$('#tipoOficio').val() == 'notificacionASOFIS' || $$('#tipoOficio').val() == 'notificacionICC2') && $$('#monto').val() == '')
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
	
   // if($$('#tipoOficio').val() == 'notificacionASOFIS' && $$("#totalNoAcciones").val() > 2)
	//{
		//mensaje += "\n - La notificacion ASOFIS solo debe contener una acción";
		//error++;	
	//}
	 if($$('#tipoOficio').val() == 'notificacionICC2' && $$("#totalNoAcciones").val() > 1)
	{
		mensaje += "\n - La notificacion al 2do. ICC solo debe contener una acción";
		error++;	
	}

	if( $$('#tipoOficio').val() == 'notificacionEF' || $$('#tipoOficio').val() == 'notificacionICC'|| $$('#tipoOficio').val() == 'notificacionASOFIS' || $$('#tipoOficio').val() == 'notificacionICC2' )
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
		// notificacion a ASOFIS comprobamos oficios
		if($$('#tipoOficio').val() == 'notificacionASOFIS')
		{
			$$(".oficioASOFIS").each(function() {
				if($$(this).val() != 0)
				{
						mensaje += "\n\n - Esta acción ya tiene un oficio de ASOFIS pendiente ";
						error++;	
				} 
			});
			}
		// notificacion aL 2do. ICC comprobamos oficios
		if($$('#tipoOficio').val() == 'notificacionICC2')
		{
			$$(".oficioICC2").each(function() {
				if($$(this).val() != 0)
				{
						mensaje += "\n\n - Esta acción ya tiene un oficio pendiente ";
						error++;	
				}
			});
		}
		
	}

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
function agregarCampos(valor,estado,estadoTxt,oficioEF,oficioICC,oficioAS,remuaa,monto,oficioICC2)
{
	var igual = 0;
	var totalAcciones = $$("#totalAcciones").val();

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
		campo += '<input type="text" size="35" class="redonda5 camposInputAcciones" id="accionVinculada_' + nextinput + '"  name="accionVinculada_' + nextinput + '" value="'+valor+'"  readonly/>';
		campo += '<input type="hidden" size="5" class="redonda5 camposInputEstados" id="accionEstado"  name="accionEstado" value="'+estado+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 oficioEF" id="oficioEF"  name="oficioEF" value="'+oficioEF+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 oficioICC" id="oficioICC"  name="oficioICC" value="'+oficioICC+'"  readonly/>';				
		campo += '<input type="hidden" size="5" class="redonda5 oficioAS" id="oficioAS"  name="oficioAS" value="'+oficioAS+'"  readonly/>';	
		campo += '<input type="hidden" size="5" class="redonda5 remuaa" id="remuaa"  name="remuaa" value="'+remuaa+'"  readonly/>';
		campo += '<input type="hidden" size="5" class="redonda5 monto" id="monto"  name="monto" value="'+monto+'"  readonly/>';		
		campo += '<span class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </span>';
		campo += '<span>'+estadoTxt+'</span>';
		campo += '</li>';
		
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalAcciones").val(totalAcciones.concat(valor+"|"));
		//----------- agregamos campo y boirramos value de accion -------------
		$$("#camposAcciones").append(campo);
		$$('#accionvolante').attr('value') = "";
		$$('#accionvolante').val('');
		
			//-------------------------------------------------------
	}
	else 
	{ 
		$$("#accionvolante").focus();
		alert ("Esta acción ya la ha ingresado...");
		$$('#accionvolante').attr('value') = "";
	}
}
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


function completa()
{
	$$.ajax
	({
		beforeSend: function(objeto)
		{
			//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
		},
		complete: function(objeto, exito)
		{
			//alert("Me acabo de r")
			//if(exito=="success"){ alert("Y con éxito"); }
		},
		type: "POST",
		url: "procesosAjax/po_busqueda_remitente_oficios.php",
		data: {accion1:$$('#accionVinculada_1').val(),acciones:$$('#totalAcciones').val(), tipo:$$('#tipoOficio').val()},
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé");
			//alert("Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			//alert(datos);
			var remi= datos.split("|");

			if(remi[5]!=0 && $$('#tipoOficio').val() =="asistencia") 
				alert("Las UUA's deben ser las mismas. Error = "+remi[5]) 
			else
			{
				$$("#remitente").val(remi[0]);
				$$("#cargo").val(remi[1]);
				$$("#dependencia").val(remi[2]);
				$$("#oficioRef").val(remi[3]);
				$$("#asunto").val(remi[4]);
			}
			//}
		
			if ($$('#tipoOficio').val() != "notificacionEF" || $$('#tipoOficio').val() != "notificacionICC" || $$('#tipoOficio').val() != "notificacionICC2" || $$('#tipoOficio').val() !="asistencia"  || $$('#tipoOficio').val() !="remisionUAA")
			{
 				$$("#cargo").removeAttr("readonly"); 
				$$("#remitente").removeAttr("readonly");
				$$("#dependencia").removeAttr('readonly');	 
				$$("#oficioRef").removeAttr('readonly');	
				$$("#asunto").removeAttr('readonly');	 
			}
			else
			{
				$$("#remitente").attr('readonly',false);
				$$("#cargo").attr('readonly',false);	 
				$$("#dependencia").attr('readonly',false);	
				$$("#oficioRef").attr('readonly',false);
				$$("#asunto").attr('readonly',false);	 
			}
			/*
			if ($$('#tipoOficio').val() == "notificacionEF" || $$('#tipoOficio').val() == "notificacionICC" || $$('#tipoOficio').val() == "remisionUAA")
			{
				$$("#trFecha").show(); 
				$$("#trFojas").show(); 
				$$("#fechaPO").removeAttr("disabled"); 
				$$("#fechaPO").attr('disabled',false);
				$$("#fojas").attr('disabled',false);
			}
			else
			{
				$$("#trFecha").css("display","none");
				$$("#trFojas").css("display","none");  
				$$("#fechaPO").attr('disabled',true);
				$$("#fojas").attr('disabled',true);	 
			}
			//-------- OFICIOS ICC Y EF +--------------------------------------
			if ($$('#tipoOficio').val() == "notificacionEF" || $$('#tipoOficio').val() == "notificacionICC")
			{
				$$("#trFecha").show(); 
				$$("#trFojas").show(); 
				$$("#fechaPO").removeAttr("disabled"); 
				$$("#fechaPO").attr('disabled',false);
				$$("#fojas").attr('disabled',false);
				$$("#tdNomFojas").html('<p>Fojas del PO</p>');
				
				var sf = '<select name="fojas" id="fojas" class="redonda5">';
				sf += '<option value="">Núm.</option>';
				sf += '<option value="1">1</option>';
				sf += '<option value="2">2</option>';
				sf += '<option value="3">3</option>';
				sf += '<option value="4">4</option>';
				sf += '<option value="5">5</option>';
				sf += '<option value="6">6</option>';
				sf += '<option value="7">7</option>';
				sf += '<option value="8">8</option>';
				sf += '<option value="9">9</option>';
				sf += '<option value="10">10</option>';
				sf += '<option value="11">11</option>';
				sf += '<option value="12">12</option>';
				sf += '<option value="13">13</option>';
				sf += '<option value="14">14</option>';
				sf += '<option value="15">15</option>';
				sf += '<option value="16">16</option>';
				sf += '<option value="17">17</option>';
				sf += '<option value="18">18</option>';
				sf += '<option value="19">19</option>';
				sf += '<option value="20">20</option>';
				sf += '</select>';
				
				$$("#tdFojas").html(sf);		
			}
						*/

			if($$('#tipoOficio').val() == "remisionUAA")
			{
				$$("#trFecha").show(); 
				//$$("#trFojas").show(); 
				//$$("#fechaPO").removeAttr("disabled"); 
				$$("#fechaPO").attr('disabled',false);
				//$$("#fojas").attr('disabled',false);
				//$$("#tdNomFojas").html('<p>Fojas del ET</p>');
				//$$("#tdFojas").html('<input type="text" name="fojas" id="fojas" class="redonda5">');		
			}
			
			

			/*
			*/
			if ($$('#tipoOficio').val() == "solicitar")
			{
 				$$("#cargo").attr('readonly',false);
				$$("#remitente").attr('readonly',false);
				$$("#dependencia").attr('readonly',false);
				$$("#oficioRef").attr('readonly',false);
				$$("#asunto").attr('readonly',false);
			}
			else
			{
 				$$("#cargo").attr('readonly',false); //true
				$$("#remitente").attr('readonly',false); //true
				$$("#dependencia").attr('readonly',false); //true
				$$("#oficioRef").attr('readonly',false); //true
				$$("#asunto").attr('readonly',false); //true
			}
			if ($$('#tipoOficio').val() == "notificacionASOFIS")
			{
 				$$("#cargo").attr('readonly',false);
				$$("#remitente").attr('readonly',false);
				$$("#dependencia").attr('readonly',false);
				$$("#oficioRef").attr('readonly',false);
				$$("#asunto").attr('readonly',false);
			}
			else
			{
 				$$("#cargo").attr('readonly',false); //true
				$$("#remitente").attr('readonly',false); //true
				$$("#dependencia").attr('readonly',false); //true
				$$("#oficioRef").attr('readonly',false); //true
				$$("#asunto").attr('readonly',false); //true
			}
			//$$("#dependencia").val(remi[1]);
			if($$("#oficioRef").val() == '') $$("#oficioRef").attr('readonly',false);
			if($$("#cargo").val() == '') $$("#cargo").attr('readonly',false);
			if($$("#dependencia").val() == '') $$("#dependencia").attr('readonly',false);
			if($$("#asunto").val() == '') $$("#asunto").attr('readonly',false);
			if($$("#remitente").val() == '') $$("#remitente").attr('readonly',false);
		}
	});
}


























//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function generarOficio()
{
	//alert($$('#accionVinculada_1').val())
	var na = $$('#accionVinculada_1').val();
	var tipoOficio = $$("#tipoOficio").val();
	
	var acc = $$('#accionVinculada_1').val();
	
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
		if(totalAcciones != 0)
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
				url: "procesosAjax/po_oficio_genera.php",
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
					
					//alert(datos);
					
					var urlCadena = "na="+acc+"&fo="+fo+"&po="+po+"&cp="+cp+"&ef="+ef+"&mm="+mm+"&ua="+ua+"&dir="+dir+"&car="+car+"&nRe="+nRe+"&cRe="+cRe+"&dRe="+dRe+"&fOf="+fOf+"&foj="+foj+"&fSi="+fSi+"&hSi="+hSi+"&ini="+ini+"&folioef="+folioef+"&gobernador="+gobernador+"&cargo="+cargo+"&fechaofi="+fechaofi+"&folioicc="+folioicc+"&fechaofiicc="+fechaofiicc+"&acuse="+acuse+"&titular="+titular+"&cargoicc="+cargoicc;
					
					//vemos q tipo de oficio es y que mostrar en el cuadro
					if(tipoOficio == 'notificacionEF'){
						//mostramos cuadro donde se insertara el html en el id 'cuadroRes'
						new mostrarCuadro(550,900,"Oficio generado "+fo+"...",20)
						$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/formatoPM.pdf.php?"+urlCadena+"'></iframe>");	
					}else if(tipoOficio == 'notificacionICC'){
						//mostramos cuadro donde se insertara el html en el id 'cuadroRes'
						new mostrarCuadro(550,900,"Oficio generado "+fo+"...",20)
						$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/formatoICC.pdf.php?"+urlCadena+"'></iframe>");	
					}else if(tipoOficio == 'remisionUAA'){
						//mostramos cuadro donde se insertara el html en el id 'cuadroRes'
						new mostrarCuadro(550,900,"Oficio generado "+fo+"...",20)
						//$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/formatouaa.pdf.php?"+urlCadena+"'></iframe>");	
					}else{
						//mostramos cuadro donde se insertara el html en el id 'cuadroRes'
						new mostrarCuadro(200,500,"Oficio generado...",150)
						$$("#cuadroRes").html("<center><h2> <br><br> Se generó el oficio <br> "+fo+" </h2></center>");	
					}

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
					
					if($$('#tipoOficio').val() == 'notificacionICC')
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
	 $$("#accionvolante").autocomplete({
	  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						beforeSend: function(objeto){ $$('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "procesosAjax/po_oficios_buscaAccion.php",
						dataType: "json",
						data: {
							term: request.term,
							direccion: $$("#indexDir").val(),
							nivel: $$("#indexNivel").val()
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
		$$("#remitente").val('');
		$$("#cargo").val('');
		$$("#dependencia").val('');
		$$("#oficioRef").val('');
		$$("#asunto").val('');
	  	//ocultamos todos los campos 
 		$$(".opciones").css("display","none");
		//mostramos solo los options que se debe
		
		if (ui.item.estado ==2) {
		 $$("select[name='tipoOficio'] option[value='asistencia']").show();
		 		$$("#remitente").attr('readonly',false);
				$$("#cargo").attr('readonly',false);	 
				$$("#dependencia").attr('readonly',false);	 
 }
		 
		 if (ui.item.estado ==5) {
		$$("select[name='tipoOficio'] option[value='notificacionEF']").show(); 
		$$("select[name='tipoOficio'] option[value='notificacionICC']").show();
		$$("select[name='tipoOficio'] option[value='notificacionASOFIS']").show();  
		$$("select[name='tipoOficio'] option[value='notificacionICC2']").show();
		 }
		 
		 if (ui.item.estado ==6) {
		 $$("select[name='tipoOficio'] option[value='remisionUAA']").show(); }


		agregarCampos(ui.item.value,ui.item.estado,ui.item.estadoTxt,ui.item.ofiEF,ui.item.ofiICC,ui.item.ofiAS,ui.item.remuaa,ui.item.monto);
		 
		 
		//$$("#volTxt").html("Turnado: Dirección '"+ui.item.direccion+"'  "+ui.item.turnado);
		//$$("#turnado").val(ui.item.turnado);
		//$$("#direccion").val(ui.item.direccion);
		//$$("#estado").val(ui.item.estado);
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
  	$$("#volLista").load("procesosAjax/po_oficio_busca.php");
	// --------------- AGREGA el option administrativo a select ---------------
	//if($$("#indexDir").val() == "DG") $$('#tipoOficio').append('<option value="administrativo" selected="selected">Administrativo</option>');
	
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
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR OFICIOS </div>
       <!-- <div id='paso3' onclick="muestraPestanaVol(3)" class="todosPasos pasos"> OFICIOS 2013 </div> -->
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
                    <td class="etiquetaPo" width="100"> <p>Agregar Acción:</p></td>
                    <td>
                      <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="35"  style="float:left;" > <span id="idLoad" style="float:left; padding:0 5px"></span>
                    </td>
                  </tr>
                    </td>
                  </tr>
				  

                
                <?php //echo $_SESSION['nivel']; ?>
                
                 <tr>
                    <td class="etiquetaPo" width="100"> <p>Tipo de oficio:</p></td>
                    <td>
                      <select name="tipoOficio" id="tipoOficio" class="redonda5" onchange="completa()">
                      		<!--
                      		<option class="opciones" value="Seleccione el tipo de oficio..."></option>
                      		<option class="opciones" value="asistencia">Asistencia Jurídica</option>
                            <option class="opciones" value="notificacionEF">Notificación E.F.</option>
                            <option class="opciones" value="notificacionICC">Notificación I.C.C.</option>
                            <option class="opciones" value="notificacionICC2">Notificación al 2do. ICC </option>
                            <option class="opciones" value="notificacionASOFIS">Notificación ASOFIS</option>
                            <option class="opciones" value="remisionUAA">Remisión a la UAA</option> 
                            <option value="docu_uaa">Remitir Información/Documentación a la UAA</option> 
                            <option value="archivo">Archivo de Concentración</option>
                            <option value="recordatorio">Recordatorio Solicitud de Opinión Técnica</option>
                            <option value="solicitar>EF-Solicitar/Emitir Información ó Documentación</option>
                             
                           
                            
                            -->
                             <optgroup label="Proceso de la Acción">
								<?php
                                     $sql = $conexion->select("SELECT * FROM oficios_options WHERE estado = 'po' AND tipo = 'proceso' ", false); 
                                     while($r = mysql_fetch_array($sql)) echo "<option class='opciones' value='".$r['value']."'> &nbsp;&nbsp;&nbsp; - ".$r['texto']."</option>";
                                ?>
							</optgroup>
                            
                            <optgroup label="Otros Oficios">
                            <?php
								 $sql = $conexion->select("SELECT * FROM oficios_options WHERE estado = 'po' AND tipo = 'otros' ORDER BY texto", false); 
								 while($r = mysql_fetch_array($sql)) echo "<option value='".$r['value']."'> &nbsp;&nbsp;&nbsp; - ".$r['texto']."</option>";
							?>
			/*	<?php 
				if($tipoOficio == "notificacionASOFIS"){
			$sql = $conexion->update("update po set 'asofis' = '1' where num_accion='accionvolante' "); 
				} ?>*/
				
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

            	<div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  <tr>
                    <td  class="etiquetaPo" width="100"><p>Destinatario:</p></td>
                      
                    <td >
                        <input type="text" name="remitente" id="remitente" size="35" class="redonda5" >
                        <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5" > -->
                    </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo">  <p>Cargo:</p></td>
                    <td>
                      <input type="text" name="cargo" id="cargo" size="35" class="redonda5" >
                    </td>
                  </tr>
                    <tr>
                    <td class="etiquetaPo">  <p>Dependencia:</p></td>
                    <td>
                      <input type="text" name="dependencia" id="dependencia" size="35" class="redonda5">
                    </td>
                  </tr>
                  </table> 
                  </div>
              </td>
              <td width="70%" rowspan="2" valign="top">
                   <div class="camposAcciones redonda5" id="camposAcciones" style="overflow:auto; padding:20px !important">
                   <h3>Acciones Vinculadas <span id="accionesNo">0</span> </h3>
                   
              		</div>
                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
              </td>
            </tr>
            <tr>
            	<td width="40%">
					<div class="volDivCont redonda5">
                     <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
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
				<?php $genera = $_SESSION['oficios']; ?>
				
                <input name='userForm' id='userForm' type="hidden" value="" />
                <input name='dirForm' id='dirForm' type="hidden" value="" />
				<input name='dirForm' id='dirForm' type="hidden" value='<?php echo $_SESSION['oficios']; ?>' />
				<?php if($genera == 1) { ?>
                <input type="button" class="submit-login" value="Generar Oficio" onclick="generarOficio()" id="generaOficio" />
				<?php } else { echo "<H1> ¡No cuenta con permisos para generar Oficios! </H1>"; } ?>
                </td>
            </tr>
        </table>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
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

      </div>
      <!-- ---------------------------------------------------------------------------- -->
      <div id='p3' style="display:none" class="contOficios redonda10 todosContPasos">
        <h2>Buscar Oficio 2013: 
            <input type="text" name="text2" id="text2" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista2" id="volLista2">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
			 
      </div>
      
</div><!-- end cont
 volantes -->