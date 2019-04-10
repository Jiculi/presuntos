<link rel="stylesheet" href="css/estilos_volantes.css" type="text/css" media="screen" title="default" />

<script> 
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
  		$$("#volLista").load("procesosAjax/vol_busca_volantes.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>"});
	} 
}

function exportaExcel()
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
		url: "procesosAjax/vol_busca_volantes.php",
		data:{
			texto:$$('#text').val(),
			direccion:"<?php echo $_SESSION['direccion'] ?>",
			usuario:"<?php echo $_SESSION['usuario'] ?>",
			excel:'ok'
			},
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé");
			//alert("Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			$$('#export').val(datos);
			document.forms.formExcel.submit();
			
			
		}
	});
}

function muestraCral(valor)
{
	if(valor == 2 || valor == 10 || valor == 11 || valor == 21)
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
	if(valor == 10)
	{ 
		//$$("#tablaCral").fadeIn();
		$$('#trDT').fadeIn();
		$$('#volanteDT').attr('disabled', false);
	}
	else
	{
		$$('#trDT').fadeOut();
		$$('#volanteDT').attr('disabled', true);
	}
	
	if(valor == 27)
	{ 
		//$$("#tablaCral").fadeIn();
		$$('#trConcluida1').fadeIn();
		$$('#trConcluida2').fadeIn();
		$$('#ofConcluida').attr('disabled', false);
		$$('#feConcluida').attr('disabled', false);
	}
	else
	{
		$$('#trConcluida1').fadeOut();
		$$('#trConcluida2').fadeOut();
		$$('#ofConcluida').attr('disabled', true);
		$$('#feConcluida').attr('disabled', true);
	}
	
	if(valor == "administracion")
	{ 
		$$('#accionvolante').attr('disabled', true);
		$$('.inputsSig').attr('disabled',false); //activa todos los campos
		$$('#volanteDT').attr('disabled', true);
		$$('#ofConcluida').attr('disabled', true);
		$$('#feConcluida').attr('disabled', true);
		cargaFechaOficio();
	}
	else 
	{
		$$('#accionvolante').attr('disabled', false);
		//$$('.inputsSig').attr('disabled',true);
	}
}
// ------------ carga fechas de oficios---------------------------------------
function cargaFechaOficio(fecha)
{
	//alert(fecha)
	$$( "#fechaOficio" ).datepicker({
	// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 //minDate: fecha,
		 //---------------------------
		 minDate: "01/02/2015",
	  	 //maxDate: "29/02/2015",
		 //-----------------------------
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$$( "#fechaAcuse" ).datepicker( "option", "minDate", selectedDate );  
		 }
	});
	
	$$( "#fechaAcuse" ).datepicker({
		// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 //minDate: fecha,
		 //---------------------------
		 minDate: "01/02/2015",
	  	 //maxDate: "29/02/2015",
		 //-----------------------------
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$$( "#fechaOficio" ).datepicker( "option", "maxDate", selectedDate );  
		 }
	});
}
//-------------------- función agrega Campos -----------------------------------------------
var nextinput = 0;
var accionesNum = 0;
//---------------------------------------
//function agregarCampos(valor,estado,estadoTxt,turnado,remitente,cargo,dependencia,oficio,ref,asunto)
function agregarCampos(estado,edoTxt,turnado,direccion,accion,ref,asunto,remitente,cargo,dependencia,oficio,ofiFec,ofiFecAcu,cral,cralFe,cralFecAcu,dt,ofConcluida,feConcluida)
{
	var igual = 0;
	var totalAcciones = $$("#totalAcciones").val();

	$$('.camposInputAcciones').each( function(){
	  var $$this = $$(this);
	  //$this.css( 'text-decoration' , 'underline' );
	  if(accion == $$this.val()) igual++;
	});
	//-------------------------------------------------------------------------
	if(igual == 0)
	{
		nextinput++;
		accionesNum++;
		$$("#accionesNo").html(accionesNum);
		$$("#totalNoAcciones").val(accionesNum);
		campo = '<tr id="rut'+nextinput+'" class="filasVol">';
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputAcciones" id="accionVinculada_' + nextinput + '"  name="accionVinculada[]" value="'+accion+'"  readonly/>'+accion+'</td>';
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputEdoTxt" id="accionEdoTxt_' + nextinput + '"  name="accionEdoTxt[]" value="'+edoTxt+'"  readonly/>'+edoTxt+'</td>';		
		campo += '<input type="hidden" size="" class="redonda5 campoInputVol camposInputEstados" id="accionEstado_' + nextinput + '"  name="accionEstado[]" value="'+estado+'"  readonly/>'+estado+' ';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputTurnado" id="accionTurnado_' + nextinput + '"  name="accionTurnado[]" value="'+turnado+'"  readonly/>'+turnado+'</td>';		
		campo += '<input type="hidden" size="" class="redonda5 campoInputVol camposInputTurnado" id="accionDireccion_' + nextinput + '"  name="accionDireccion[]" value="'+direccion+'"  readonly/> ';		
		campo += '<input type="hidden" size="" class="redonda5 campoInputVol camposInputRef" id="accionRef_' + nextinput + '"  name="accionRef[]" value="'+ref+'"  readonly/>'+ref+' ';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputAsunto" id="accionAsunto_' + nextinput + '"  name="accionAsunto[]" value="'+encodeURIComponent(asunto)+'"  readonly/>'+asunto+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputRemitente" id="accionRemitente_' + nextinput + '"  name="accionRemitente[]" value="'+remitente+'"  readonly/>'+remitente+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputCargo" id="accionCargo_' + nextinput + '"  name="accionCargo[]" value="'+encodeURIComponent(cargo)+'"  readonly/>'+cargo+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputDependencia" id="accionDependencia_' + nextinput + '"  name="accionDependencia[]" value="'+dependencia+'"  readonly/>'+dependencia+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputOficio" id="accionOficio_' + nextinput + '"  name="accionOficio[]" value="'+encodeURIComponent(oficio)+'"  readonly/>'+oficio+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputOfiFec" id="accionOfiFec_' + nextinput + '"  name="accionOfiFec[]" value="'+ofiFec+'"  readonly/>'+ofiFec+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputOfiFecAcu" id="accionOfiFecAcu_' + nextinput + '"  name="accionOfiFecAcu[]" value="'+ofiFecAcu+'"  readonly/>'+ofiFecAcu+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputCral" id="accionCral_' + nextinput + '"  name="accionCral[]" value="'+encodeURIComponent(cral)+'"  readonly/>'+cral+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputCralFe" id="accionCralFe_' + nextinput + '"  name="accionCralFe[]" value="'+cralFe+'"  readonly/>'+cralFe+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputCralFecAcu" id="accionCralFecAcu_' + nextinput + '"  name="accionCralFecAcu[]" value="'+cralFecAcu+'"  readonly/>'+cralFecAcu+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputDt" id="accionDt_' + nextinput + '"  name="accionDt[]" value="'+encodeURIComponent(dt)+'"  readonly/>'+dt+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputOfiCon" id="accionOfiCon_' + nextinput + '"  name="accionOfiCon[]" value="'+ofConcluida+'"  readonly/>'+ofConcluida+'</td>';		
		campo += '<td class=""><input type="hidden" size="" class="redonda5 campoInputVol camposInputOfiFeCon" id="accionOfiFeCon_' + nextinput + '"  name="accionOfiFeCon[]" value="'+feConcluida+'"  readonly/>'+feConcluida+'</td>';		
		campo += '<td><span class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </span> </td>';
		campo += '</tr>';
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalAcciones").val(totalAcciones.concat(accion+"|"));
		//----------- agregamos campo y boirramos value de accion -------------
		$$("#product-table").append(campo);
		//$$('#accionvolante').attr('value') = "";
		//$$('#accionvolante').val('');
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
	//$$("#accionesNo").html(accionesNum);
	$$("#totalNoAcciones").val(accionesNum);
	$$('#accionesNo').html(accionesNum);
}
//---------------------------- INSERTAR ACCION -------------------------------------
function insertaAccion(){
	if(comprobarForm('volanteForm')){
		//-------------- validar de estados ---------------------
		var errorEdos = 0;
		var menEdo = "";
		var edo = $$('#estado').val();
		var edoPFRR = $$('#estadoPFRR').val();
		var mov = $$('#movimiento').val();
		//------------ asignamos los valore en la funcion -------
		var estado = $$('#estado').val();
		var edoTxt = $$('#edoTxt').val();
		var turnado = $$('#turnado').val();
		var direccion = $$('#direccion').val();
		var accion = $$('#accionVol').val();
		var ref = $$('#movimiento').val();
		var asunto = $$('#asunto').val();
		var remitente = $$('#remitente').val();
		var cargo = $$('#cargo').val();
		var dependencia = $$('#dependencia').val();
		var oficio = $$('#oficio').val();
		var ofiFec = $$('#fechaOficio').val();
		var ofiFecAcu = $$('#fechaAcuse').val();
		var cral = $$('#cral').val();
		var cralFe = $$('#fechaCral').val();
		var cralFecAcu = $$('#acuseCral').val();
		//-------------------------------------------------------
		if(mov != 10) var dt = "";
		else var dt = $$('#volanteDT').val();
		//-------------------------------------------------------
		if(mov != 27) {
			var ofConcluida = "";
			var feConcluida = "";
		}
		else {
			var ofConcluida = $$('#ofConcluida').val();
			var feConcluida = $$('#feConcluida').val();
		}
		agregarCampos(estado,edoTxt,"Miguel Ángel Santos Ramírez",direccion,accion,ref,asunto,remitente,cargo,dependencia,oficio,ofiFec,ofiFecAcu,cral,cralFe,cralFecAcu,dt,ofConcluida,feConcluida)
		$$('.inputsSig').val('');// inputs del form
		$$('#volTxt').html("");
	}
}
//---------------------------- VALIDA ACCIONES ---------------------------------------------
function validaAcciones(nvoTurnado)
{
	var cont = 0;
	var error = 0;
	var estado = "";
	var mensaje = "";
	var mensaje1 = "";
	
	$$(".camposInputTurnado").each(function() {
		if(cont == 0) turnado = $$(this).val();
		if(nvoTurnado != turnado){
			//alert("Las acciones deben tener el mismo estado");
			error++;
			return false
		}
		cont++;
	});	
	
	if(error == 0) return true;
	else return false;
}
//----------------------------  CARGA SELECT -----------------------------------------------
function cargaSelect(estado)
{
			// ocultamos todos --------
	$$(".opciones").css("display","none");
	// segun su estado mostramos options
	/*
	if(estado == 1)
	{
		$$(".opciones").css("display","none");
		$$(".grupoPFRR").css("display","none");
		$$(".grupoMEDIOS").css("display","none");
		
		$$("select[name='movimiento'] option[value='2']").show();
		//$$("select[name='movimiento'] option[value='5']").show();
		$$("select[name='movimiento'] option[value='x_otros']").show();
		$$("select[name='movimiento'] option[value='8']").show();

	}
	if(estado == 2) 
	{
		//$$("select[name='movimiento'] option[value='3']").show();
		$$(".opciones").css("display","none");
		$$(".grupoPFRR").css("display","none");
		$$(".grupoMEDIOS").css("display","none");
		$$(".grupoADM").css("display","none");
	}
	if(estado == 3 || estado == 4)
	{
		$$(".opciones").css("display","none");
		$$(".grupoPFRR").css("display","none");
		$$(".grupoMEDIOS").css("display","none");
		$$(".grupoADM").css("display","none");

		$$("select[name='movimiento'] option[value='2']").show();
		$$("select[name='movimiento'] option[value='5']").show();
		$$("select[name='movimiento'] option[value='8']").show();
		$$("select[name='movimiento'] option[value='x_otros']").show();
	}
	if(estado == 5) 
	{
		$$(".opciones").css("display","none");
	}
	if(estado == 5 || estado == 6) 
	{
		$$(".opciones").css("display","none");
		//$$("select[name='movimiento'] option[value='2']").show();
		//$$("select[name='movimiento'] option[value='5']").show();
		//$$("select[name='movimiento'] option[value='8']").show();
	}
	/*
	if(estado >= 3 && estado < 6) 
	{
		$$(".opciones").css("display","none");
		$$("select[name='movimiento'] option[value='2']").show();
		$$("select[name='movimiento'] option[value='5']").show();
		$$("select[name='movimiento'] option[value='8']").show();
	}
	if(estado == 6) 
	{
		$$(".opciones").css("display","none");
	}
	if(estado == 7) 
	{
		$$(".opciones").css("display","none");
		$$(".grupoPFRR").css("display","none");
		$$(".grupoMEDIOS").css("display","none");
		$$(".grupoADM").css("display","none");

		$$("select[name='movimiento'] option[value='9']").show();
		$$("select[name='movimiento'] option[value='27']").show();
		$$("select[name='movimiento'] option[value='10']").show();
		$$("select[name='movimiento'] option[value='x_otros']").show();
	}
	if(estado == 11) 
	{
		$$(".opciones").css("display","none");
		$$(".grupoPO").css("display","none");
		$$(".grupoMEDIOS").css("display","none");
		$$(".grupoADM").css("display","none");

		$$("select[name='movimiento'] option[value='13']").show();
		$$("select[name='movimiento'] option[value='x_otros']").show();
	}
	if(estado == 13) 
	{
		$$(".opciones").css("display","none");
		$$(".grupoPO").css("display","none");
		$$(".grupoMEDIOS").css("display","none");
		$$(".grupoADM").css("display","none");

		$$("select[name='movimiento'] option[value='11']").show();
		$$("select[name='movimiento'] option[value='14']").show();
		//$$("select[name='movimiento'] option[value='28']").show();
		$$("select[name='movimiento'] option[value='x_otros']").show();
	}
	*/
	if(estado == 19) 
	{
		$$(".opciones").css("display","none");
		$$(".grupoPO").css("display","none");
		$$(".grupoMEDIOS").css("display","none");
		$$(".grupoADM").css("display","none");

		$$("select[name='movimiento'] option[value='28']").show();
		$$("select[name='movimiento'] option[value='x_otros']").show();
	}

}
//---------------------- COMPLETA REMITANTES ----------------------------------------------
function completaRemitentes(accion,tipo,seleccion)
{
	//muestra o oculta inputs del cral
	//alert(accion+" * "+tipo+" * "+seleccion);
	muestraCral(seleccion);
	//mostramor asunto dependiendo la seleccion
	if(seleccion == 2) 
		$$("#asunto").val('La UAA remite a esta DGR, el PPO de la acción '+$$("#accionvolante").val()+' junto con su ET para su Asistencia Jurídica.');		
	
	if(seleccion == 5) 
		$$("#asunto").val('La oficina del AEGF remitió a esta DGR el PO '+$$("#acccionPo").val()+' firmado. Se inició trámite de certificación y el proceso para su notificación correspondientes.');		
	
	if(seleccion == 8) 
		$$("#asunto").val('La UAA hace de nuestro conocimiento que se notificó a la EF la Baja por Conclusión, previa a la emisión del PO '+$$("#acccionPo").val()+'.');		
	
	if(seleccion == 9) 
		$$("#asunto").val('La UAA hace de nuestro conocimiento que se notificó a la EF la Solventación del PO '+$$("#acccionPo").val()+'.');

	if(seleccion == 27) 
		$$("#asunto").val('La UAA hace de nuestro conocimiento que la acción '+$$("#accionvolante").val()+' se da por Concluida.');

	if(seleccion == 10) 
		$$("#asunto").val('La UAA remitió a esta DGR, el DTNS del PO '+$$("#acccionPo").val()+', acompañado de su ET y proyecto de DT para que se inicie el PFRR. ');

	if(seleccion == 11) 
		$$("#asunto").val('La UAA devuelve el DT y ET, se determinaron diversas observaciones para que sean tomadas en consideración y poder valorar si es procedente el inicio del PFRR.');

	if(seleccion == 14) 
		$$("#asunto").val('La  UAA hace de nuestro conocimiento que se notificó a la EF la Solventación del PO número '+$$("#acccionPo").val()+'. ');

	if(seleccion == 28) 
		$$("#asunto").val('');
		
	if( seleccion == 'x_otros')
	{
		$$("#volTxt").html("Turnado: Miguel Ángel Santos Ramírez	 <br>Edo Trámite: Medios de Defensa  ");
		
		$$("#turnado").val("Miguel Ángel Santos Ramírez");
		$$("#direccion").val("C");
		$$("#estado").val("Medios de Defensa");
		$$("#estadoPFRR").val("Medios de Defensa");
		$$("#prescripcion").val("");
		$$("#presuntos").val("");
		$$("#montototal").val("");
	}
		
	//la UAA hace de nuestro conocimiento que se notificó a la EF la Solventación del PO número PO0000/14
	if(seleccion == 'otro' || seleccion == 'pfrr_otros' || seleccion == 'medios_otros' || seleccion == 'x_otros' || seleccion == 'administracion' )
	{
		$$("#remitente").val('');
		$$("#cargo").val('');
		$$("#dependencia").val('');
		$$("#asunto").val('');
	}
	else
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
			data: {acciones:accion, tipo:tipo, seleccion:seleccion},
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//alert(datos);
				var remi= datos.split("|");
	
				$$("#remitente").val(remi[0]);
				$$("#cargo").val(remi[1]);
				$$("#dependencia").val(remi[2]);
			}
		});		
	}
}
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------
function generarVolante()
{
	//alert($$("#todasAccionesVol").serialize())
	
	if(comprobarForm('todasAccionesVol') && ($$("#totalNoAcciones").val() != 0 || $$("#totalNoAcciones").val() != "")){
		$$.ajax
		({
			beforeSend: function(objeto)
			{
				$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				$$('#generaVolante').attr("disabled",true);
				$$('#generaVolante').val('Generando Oficio espere...');
				$$('#generaVolante').css( "background", "gray" );
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/vol_genera_volante.php",
			//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
			data: $$("#todasAccionesVol").serialize(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//alert(datos)
				//generamos ultimo ID
				var ultimoId = datos;
				new mostrarCuadro(450,800,"Volante de Correspondencia",70,"cont/vol_volante.html.php","folio="+datos)
				$$(".redonda5").val(""); // campos en blanco
				$$("#volTxt").html(""); // turnado en blanco c
				// deshab ilitamos campos 
				$$("#cral").attr("disabled",true);
				$$("#fechaCral").attr("disabled",true);
				$$("#acuseCral").attr("disabled",true);
				$$("#accionvolante").attr("disabled",false);
				/// ponemos en blanco datos de la accion 
				$$("#turnado").val("");
				$$("#direccion").val("");
				$$("#estado").val("");
				$$("#estadoPFRR").val("");
				$$("#prescripcion").val("");
				$$("#presuntos").val("");
				$$("#montototal").val("");
				//---------------------------------------------------------
				$$('#generaVolante').attr("disabled",false);
				$$('#generaVolante').val('Generar Volante');
				$$('#generaVolante').css( "background", "#333" );
				$$('.campoInputVol').val('');//inputs de acciones del listado
				$$('.filasVol').remove();//inputs de acciones del listado
				$$('#volTxt').html("");
				$$('#accionesNo').html("");
			}
		});
		
	}else{ alert("Ingrese una acción ") }
	
}
//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function(){
	// configuramos el control para realizar la busqueda de los productos
	$$("#remitente").autocomplete({
	 //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						type: "POST",
						url: "procesosAjax/po_busqueda_remitente.php",
						dataType: "json",
						data: {
							term: request.term
						},
						success: function( data ) {
							response(data);
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
		$$("#oficio").focus();
		
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
						beforeSend: function(objeto)
						{
							$$('#idLoad').html('<img src="images/load_chico.gif">');
						},
						type: "POST",
						url: "procesosAjax/vol_busqueda_volaccion_mr.php",
						dataType: "json",
						data: {
							term: 	request.term,
						},
						success: function( data ) {
							//alert(data)
							response(data);
							$$('#idLoad').html('');
		 //muestraListados();
						}
					});
			},
		  minLength: 2,
	 select: 
	 function( event, ui ) {  
		//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
		//muestraContenidoOficios(ui.item.label);
		$$(".inputVolantes").val("");
		$$('.inputsSig').attr('disabled',false);
		
		//$$("#volTxt").html("Turnado: "+ui.item.turnado+" <br>"+ui.item.edoTxt);
		$$("#volTxt").html("Turnado: Miguel Ángel Santos Ramírez <br>Edo Trámite: Medios de Defensa  ");
		
		//$$("#accionvolante").val(ui.item.value);
		$$("#accionVol").val(ui.item.value);
		$$("#turnado").val(ui.item.turnado);
		$$("#direccion").val(ui.item.direccion);
		$$("#estado").val(ui.item.estado);
		$$("#edoTxt").val(ui.item.edoTxt);
		//$$("#estadoPFRR").val(ui.item.estadoPFRR);
		$$("#prescripcion").val(ui.item.prescripcion);
		$$("#presuntos").val(ui.item.presuntos);
		$$("#montototal").val(ui.item.montototal);
		$$("#acccionPo").val(ui.item.po);
		
		//$$("#oficio").val(ui.item.referencia);
		//$$("#fechaOficio").val(ui.item.referenciaFecha);
		//$$("#fechaAcuse").val(ui.item.referenciaAcuse);
		cargaFechaOficio(ui.item.referenciaAcuse);
		
		//----- validamos accion -------------------
		//alert("Modulo: "+ui.item.edoModulo+"\n Funcion: "+validaAcciones(ui.item.turnado))
		/*
		if( validaAcciones(ui.item.turnado) && ui.item.edoModulo == "MEDIOS" ) {
			cargaSelect(ui.item.estado);
			//agregarCampos(ui.item.value,ui.item.estado,ui.item.edoTxt,ui.item.turnado);
		} else {
			var msj = "";
			if(!validaAcciones(ui.item.turnado)) msj += " Las acciones deben tener el mismo destinatario \n";
			if(ui.item.modulo != "MEDIOS") msj += " La acción esta en el módulo de "+ui.item.edoModulo+" debe ir al módulo Leaflets PFRR ";
			$$("#volTxt").html("");
			alert(msj)

			return false
		}
		*/
	 },
	 change: function (event, ui) {
		  if(!ui.item)  $$(event.target).val("");
    	},
	 focus: function (event, ui) {
        return false;
    }
	});//end
}); 

//----------------------- FECHA DE VOLANTES ------------------------------
//---------------------------------------------------------------------	
$$(function() {
//---------------------------------------------------------------------	
//---------------------------------------------------------------------	
	$$( "#feConcluida" ).datepicker({
		// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 beforeShowDay: noLaborales
		 /*onClose: function( selectedDate ) 
		 { 
			$$( "#acuseCral" ).datepicker( "option", "minDate", selectedDate );  
		 }*/
	});
	
	$$( "#fechaCral" ).datepicker({
		// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$$( "#acuseCral" ).datepicker( "option", "minDate", selectedDate );  
		 }
	});
	
	$$( "#acuseCral" ).datepicker({
		// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$$( "#fechaCral" ).datepicker( "option", "maxDate", selectedDate );  
		 }
	});
}); 
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

}
.grupoPO{ background:#BFDFFF}
.grupoPFRR{ background:#AFA !important}
.grupoMEDIOS{ background:#F88}
.grupoADM{ background:#FF6CFF}
.grupoOTROS{ background:#CCC}
.PO{ background:#BFDFFF}
.PFRR{ background:#AFA !important}
.MEDIOS{ background:#F88}
.ADM{ background:#FF6CFF}
.OTROS{ background:#CCC}
.grupo{ }
.opciones{ display:none}
.numAccion{ font-weight:bold !important; font-size:14px !important }
</style>


<div id="pagVolantes" style="padding:10px 20px;background: #FFB0B0 " class="redonda10">
    <!--

	<div class="encVol">
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
        <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR VOLANTE </div>
    <?php } ?>
       
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR VOLANTES </div>
    </div>
    -->
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
    <div id='p1' class=" redonda10 todosContPasos" >
        
        <form name="volanteForm" method="post" action="#">
        <table width="100%" align="center">
        <tr>
            <td width="25%" valign="top">
                <div class="volanteDivCont redonda5"  style="height:200px;background: #FFB0B0 ">
                 <table align="center" width="100%" border="0" class="tablaPasos tablaVol"> 
                  <tr>
                    <td width="70" class="etiquetaPo"> <p>Acción:</p></td>
                    <td valign='top'>
                      <input type="text" name="accionvolante" id="accionvolante" class="redonda5 numAccion campoInputVol inputsSig"  size="28"  style="float:left">
                      <span id="idLoad"  style="float:left; padding:0 5px; width:30px"></span>

                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="direccion" id="direccion" size="25" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="turnado" id="turnado" size="25" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="estado" id="estado" size="25" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="edoTxt" id="edoTxt" size="25" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="estadoPFRR" id="estadoPFRR" size="25" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="prescripcion" id="prescripcion" size="25" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="presuntos" id="presuntos" size="25" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="montototal" id="montototal" size="25" readonly="readonly">
                   	</td>
                   </tr>
                   <!-- ----------------- -->
                   <tr>
					 <td colspan="3">
                      <table width="100%">
                        <tr>
                            <td valign='top' id='volTxt'></td>
                        </tr>
                      </table>
                      </td>
                  </tr>
                   <!-- ----------------- -->
                    </td>
                  </tr>
                  <tr>
                    <td  width="" class="etiquetaPo"><p>Referencia:</p></td>
                    <td>
                        <input type="hidden" name="accionVol" id="accionVol" />
                        <input type="hidden" name="acccionPo" id="acccionPo" />
                        
                          <select name="movimiento" id="movimiento" style="width:200px"  class="redonda5 inputVolantes  inputsSig " onchange="completaRemitentes($$('#accionVol').val(),'remitentesUAA',this.value)" >
                            <option value=""><b>Tipo de movimiento...</b></option>
                             <!--
                            <optgroup class="grupo grupoPO" label="Pliego de Observaciones... " class="PO">
                                <option class="opciones PO" value="2" class="PO"> - <?php echo dameEstado(2) ?></option>
                                <option class="opciones PO" value="5" class="PO"> - Recepción PO firmado </option>
                                <option class="opciones PO" value="9" class="PO"> - <?php echo dameEstado(9) ?></option>
                                <option class="opciones PO" value="27" class="PO"> - <?php echo dameEstado(27) ?></option>
                                <option class="opciones PO" value="10" class="PO"> - <?php echo dameEstado(10) ?> </option>
                                <option class="opciones PO" value="8" class="PO"> - <?php echo dameEstado(8) ?> </option>
                                <option class="grupoPO PO" value="otro" class="PO"> - Otros Oficios</option>
                             </optgroup>
                             <optgroup class="grupo grupoPFRR" label="Procedimiento Resarcitorio" class="PFRR">
                                <option class="opciones PFRR" value="11" class="PFRR"> - Recepción DTNS</option>
                                <option class="opciones PFRR" value="14" class="PFRR"> - Solventación PFRR</option>
                                <option class="opciones PFRR" value="28" class="PFRR"> - Respuesta Técnica de la UAA</option>
                                <option class="grupoPFRR PFRR" value="pfrr_otros" class="PFRR"> - Otros Oficios</option>
                             </optgroup>
                             -->
                             <optgroup class="grupo grupoMEDIOS" label="Medios de Defensa" class="MEDIOS">
                                <option class="opciones MEDIOS" value="medios_recursos_consideracion" class="MEDIOS"> - Recurso de Reconsideración</option>
                                <option class="opciones MEDIOS" value="medios_juicio_nulidad" class="MEDIOS"> - Juicio Nulidad</option>
                                <option class="opciones MEDIOS" value="medios_amparo" class="MEDIOS"> - Amparo</option>
                                <option class="grupoMEDIOS MEDIOS" value="medios_otros" class="MEDIOS"> - Otros Oficios</option>
                             </optgroup>
                             
                              <?php if( $_SESSION['direccion'] == "DG" && $_SESSION['usuario'] == "esolares") { ?>
                              <!--
                             <optgroup class="grupo grupoADM" label="Administración" class="ADM">
                                <option class="grupoADM ADM" value="administracion" class="ADM"> - Administración</option>
                             </optgroup>
                             -->
                              <?php } ?>
                             <optgroup class="grupo grupoOTROS" label="Otros Movimientos" class="OTROS">
                                <option class="grupoOTROS OTROS" value="x_otros" class="OTROS"> - Otros Movimientos</option>
                             </optgroup>
                          </select>
                        <!-- <input type="checkbox" name="chkAdm" id="chkAdm" onclick=" $$('.inputsSig').attr('disabled',true) "/> Adm -->
                      </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo"> <p>Asunto:</p></td>
                    <td>
                      <textarea cols="30" rows="1" class="redonda5 inputVolantes  inputsSig" id='asunto' name='asunto'></textarea>
                    </td>
                  </tr>
                </table>
                </div>
            </td>
            <td  width="25%" >
            <div class="volanteDivCont redonda5"  style=" background:#FFB0B0">
            <table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
              <tr>
                <td  class="etiquetaPo" width="70"><p>Remitente:</p></td>
                  
                <td >
                    <input type="text" name="remitente" id="remitente"  size="25"  class="redonda5 inputVolantes inputsSig " >
                    <!-- <input type="hidden" name="idRem" id="idRem"  size="40"  class="redonda5  inputVolantes" > -->
                </td>
              </tr>
              <tr>
                <td class="etiquetaPo">  <p>Cargo:</p></td>
                <td>
                  <input type="text" name="cargo" id="cargo"  size="25"  class="redonda5 inputVolantes inputsSig ">
                </td>
              </tr>
                <tr>
                <td class="etiquetaPo">  <p>Dependencia:</p></td>
                <td>
                  <input type="text" name="dependencia" id="dependencia"  size="25"  class="redonda5 inputVolantes inputsSig ">
                </td>
              </tr>
              </table> 
              </div>
                
                
            </td>
    
          <td valign='top' width="25%" >
               <div class="volanteDivCont redonda5" style="height:200px;background:#FFB0B0">
                <table align="center" width="100%" border="0" class="tablaPasos tablaVol">                        
                <tr>
                    <td class="etiquetaPo" width="70"><p>Oficio:</p></td>
                    <td>
                      <input type="text" name="oficio"  size="25"  id="oficio" class="redonda5 inputVolantes inputsSig ">
                      </td>
                  </tr>
                    <tr>
                      <td class="etiquetaPo">Fecha Oficio:</td>
                      <td><input type="text" name="fechaOficio" size="25" id="fechaOficio" class="redonda5 inputVolantes inputsSig " /></td>
                    </tr>
                    <tr>
                    <td class="etiquetaPo">Fecha Acuse:</td>
                    <td><input type="text" name="fechaAcuse" size="25" id="fechaAcuse" class="redonda5 inputVolantes inputsSig " /></td>
                  </tr>
                 <!--- ---------------------------------------------------------------------------- --> 
                  <tr id="trDT" style="display:none">
                    <td  width="70" class="etiquetaPo">
                    <p>Dictamen Técnico:</p></td>
                    <td>
                      <input type="text" name="volanteDT" id="volanteDT" class="redonda5 inputVolantes inputsSig "  size="25"  disabled="disabled">
                      </td>
                  </tr>
                 <!--- ---------------------------------------------------------------------------- --> 
                  <tr id="trConcluida1" style="display:none">
                    <td  width="70" class="etiquetaPo">Cedula:</td>
                    <td>
                      <input type="text" name="ofConcluida" id="ofConcluida" class="redonda5 inputVolantes inputsSig "  size=""  disabled="disabled">
                      </td>
                  </tr>
                  <tr id="trConcluida2" style="display:none">
                    <td  width="70" class="etiquetaPo">Fecha Cedula:</td>
                    <td>
                      <input type="text" name="feConcluida" id="feConcluida" class="redonda5 inputVolantes inputsSig "  size=""  disabled="disabled">
                      </td>
                  </tr>
                 <!--- ---------------------------------------------------------------------------- --> 
                  
                 </table>
                </div>
            </td>
            <td  width="25%" >
                <div class="volanteDivCont redonda5" id="tablaCral"  style="height:100px;background:#FFB0B0">
                <table align="center" width="100%" border="0" class="tablaPasos tablaVol" >                        
                    <tr>
                    <td class="etiquetaPo" width="70"><p>CRAL:</p></td>
                    <td>
                      <input type="text" name="cral"  size="25"  id="cral" class="redonda5  inputVolantes inputsSig " disabled="disabled">
                      </td>
                  </tr>
                    <tr>
                      <td class="etiquetaPo">Fecha CRAL:</td>
                      <td><input type="text" name="fechaCral" size="25" id="fechaCral" class="redonda5  inputVolantes inputsSig " disabled="disabled" /></td>
                    </tr>
                    <tr>
                    <td class="etiquetaPo">Acuse Cral:</td>
                    <td><input type="text" name="acuseCral" size="25" id="acuseCral" class="redonda5  inputVolantes inputsSig " disabled="disabled" /></td>
                  </tr>
                 </table>
                 <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                </div>
          </td>
          <td>
                  <input type="button" class="submit-login redonda10" value="Insertar" id="insertaAccionBtn" onclick="insertaAccion()" style="width:60px;height:100px" />
                 </form>

          </td>
        </tr>
       <tr>
        	<td colspan="5" valign="top">
            <!-- -------------------------------------------------------------- -->
            	<div class="volDivAcci redonda5" id="contAcciones" style="height:330px; overflow:auto; background:#FFB0B0">
                    <!-- <h3>Acciones Vinculadas <span id="accionesNo">0</span> </h3> -->
                    <form name="todasAccionesVol" id="todasAccionesVol" enctype="application/x-www-form-urlencoded" method="post" >
                        <div>
                            <table  width="2000" id="product-table">
                            	<tr>
                                	<th class="trmedios ancho200">Accion</th>
                                	<th class="trmedios ancho150">Estado</th>
                                	<th class="trmedios ancho150">Turnado</th>
                                	<th class="trmedios ancho250">Asunto</th>
                                	<th class="trmedios ancho150">Remitente</th>
                                	<th class="trmedios ancho150">Cargo</th>
                                	<th class="trmedios ancho150">Dependencia</th>
                                	<th class="trmedios ancho100">Oficio</th>
                                	<th class="trmedios ancho100">Of. Fecha</th>
                                	<th class="trmedios ancho100">Of. Acuse</th>
                                	<th class="trmedios ancho100">CRAL</th>
                                	<th class="trmedios ancho100">C. Fecha</th>
                                	<th class="trmedios ancho100">C. Acuse</th>
                                	<th class="trmedios ancho100">DT</th>
                                	<th class="trmedios ancho100">Of. Conclución</th>
                                	<th class="trmedios ancho100">Of. Acuse</th>
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                        <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
                        <!-- <input type="hidden" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion'] ?>"> -->
                        <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario'] ?>" >
                        <input type="hidden" name="nivel" id="nivel" value="<?php echo $_SESSION['nivel'] ?>" >
                    </form>
                </div>
            <!-- -------------------------------------------------------------- -->
            </td>
	  </tr>
      <tr>
        <td colspan="5">
        	<div style="text-align:left; float:left; width:500px">Acciones Vinculadas: <span id="accionesNo">Ninguna</span></div>
        	<div style="text-align:center">
            	<input type="button" class="submit-login" value="Generar Volante" id="generaVolante" onclick="generarVolante()" />
            </div>
        </td>
      </tr>

	</table>
      </div><!-- end cont vol1 volantes -->
      <?php } ?>
</div><!-- end cont volantes -->
