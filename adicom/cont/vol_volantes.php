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
		 minDate: fecha,
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
		 minDate: fecha,
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$$( "#fechaOficio" ).datepicker( "option", "maxDate", selectedDate );  
		 }
	});
}
//----------------------------  CARGA SELECT -----------------------------------------------
function cargaSelect(estado)
{
			// ocultamos todos --------
	$$(".opciones").css("display","none");
	// segun su estado mostramos options
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
	/*
	if(estado == 5) 
	{
		$$(".opciones").css("display","none");
	}
	*/
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
	*/
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
		$$("#volTxt").html("Accion: "+accion+" <br>Turnado: Dirección 'C' - Miguel Angel Santos Ramirez	 <br>Estado Trámite: Medios de Defensa  ");
		
		$$("#turnado").val("Miguel Angel Santos Ramirez");
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
	if(comprobarForm('volanteForm'))
	{
		//-------------- validar de estados ---------------------
		//-------------------------------------------------------
		var errorEdos = 0;
		var menEdo = "";
		var edo = $$('#estado').val();
		var edoPFRR = $$('#estadoPFRR').val();
		var mov = $$('#movimiento').val();
		//-------------------------------------------------------
		//-------------------------------------------------------
		if(edo != 10) var dt = "";
		else var dt = $$('#volanteDT').val();
		//-------------------------------------------------------
		if(edo != 27) 
		{
			var ofConcluida = "";
			var feConcluida = "";
		}
		else 
		{
			var ofConcluida = $$('#ofConcluida').val();
			var feConcluida = $$('#feConcluida').val();
		}
		//-------------------------------------------------------
		//-------------------------------------------------------
		if(errorEdos != 0) alert(menEdo);
		//-------------------------------------------------------
		if(errorEdos == 0)
		{
			//----------------------------------------------
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
				data: {
							remitente:$$('#remitente').val(),
							cargo:$$('#cargo').val(),
							oficio:$$('#oficio').val(),
							movimiento:$$('#movimiento').val(),
							accion:$$('#accionvolante').val(),
							asunto:$$('#asunto').val(),
							dependencia:$$('#dependencia').val(),
							fechaOficio:$$('#fechaOficio').val(),
							fechaAcuse:$$('#fechaAcuse').val(),
							turnado:$$('#turnado').val(),
							direccion:$$('#direccion').val(),
							cral:$$('#cral').val(),
							fechaCral:$$('#fechaCral').val(),
							acuseCral:$$('#acuseCral').val(),
							ofConcluida:ofConcluida,
							feConcluida:feConcluida,
							dt:dt,
							//---- se elige el user del index -------------
							usuario:$$('#indexUser').val()
						},
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
					new mostrarCuadro(450,800,"Volante de Correspondencia",70,"cont/vol_volante.html.php","id="+datos)
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
					
				}
			});
		}//end estados
	}//end confirm
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
						url: "procesosAjax/vol_busqueda_volantesaccion.php",
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
		
		$$("#volTxt").html("Accion: "+ui.item.value+" <br>Turnado: Dirección '"+ui.item.direccion+"' - "+ui.item.turnado+" <br>Estado Trámite: "+ui.item.edoTxt);
		
		//$$("#accionvolante").val(ui.item.value);
		$$("#accionVol").val(ui.item.value);
		$$("#turnado").val(ui.item.turnado);
		$$("#direccion").val(ui.item.direccion);
		$$("#estado").val(ui.item.estado);
		//$$("#estadoPFRR").val(ui.item.estadoPFRR);
		$$("#prescripcion").val(ui.item.prescripcion);
		$$("#presuntos").val(ui.item.presuntos);
		$$("#montototal").val(ui.item.montototal);
		$$("#acccionPo").val(ui.item.po);
		//$$("#oficio").val(ui.item.referencia);
		//$$("#fechaOficio").val(ui.item.referenciaFecha);
		//$$("#fechaAcuse").val(ui.item.referenciaAcuse);
		//------------------------------------------------------------------------------
		cargaSelect(ui.item.estado);
		//------------------------------------------------------------------------------
		cargaFechaOficio(ui.item.referenciaAcuse);
		//------------------------------------------------------------------------------
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
//---------------------------------- BUSCAR VOLANTES -----------------------------------	
//--------------------------------------------------------------------------------------
$$( document ).ready(function() {
	$$('.inputsSig').attr('disabled',true);
	
	$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  	$$("#volLista").load("procesosAjax/vol_busca_volantes.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>"});
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
				url: "procesosAjax/vol_busca_volantes.php",
				data: {
						texto:$$('#text').val(),
						direccion:"<?php echo $_SESSION['direccion'] ?>",
						usuario:"<?php echo $_SESSION['usuario'] ?>"
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


<div id="pagVolantes" style="padding:10px 20px">
    <!-- <div id='colorSelector'>hola</div> -->

	<div class="encVol">
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
        <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR VOLANTE </div>
    <?php } ?>
       
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR VOLANTES </div>
       <!--  <div id='paso3' onclick="muestraPestanaVol(3)" class="todosPasos pasos"> OPCIONES </div> -->
    </div>
    
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
    <div id='p1' class="contVolantes redonda10 todosContPasos">
        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="volanteForm" method="post" action="#">
        
        <table width="100%" align="center">
        <tr>
            	<td width="50%" valign="top">
					<div class="volDivCont redonda5"  style="height:200px">
                     <table align="center" width="100%" border="0" class="tablaPasos tablaVol"> 
                      <tr>
                        <td class="etiquetaPo"> <p>Acción:</p></td>
                        <td valign='top'>
                          <input type="text" name="accionvolante" id="accionvolante" class="redonda5 numAccion"  size="40"  style="float:left">
                          <span id="idLoad"  style="float:left; padding:0 5px"></span>

                          <input type="hidden"  class="redonda5 inputVolantes inputsSig"  name="direccion" id="direccion" size="25" readonly="readonly">
                          <input type="hidden"  class="redonda5 inputVolantes inputsSig"  name="turnado" id="turnado" size="25" readonly="readonly">
                          <input type="hidden"  class="redonda5 inputVolantes inputsSig"  name="estado" id="estado" size="25" readonly="readonly">
                          <input type="hidden"  class="redonda5 inputVolantes inputsSig"  name="estadoPFRR" id="estadoPFRR" size="25" readonly="readonly">
                          <input type="hidden"  class="redonda5 inputVolantes inputsSig"  name="prescripcion" id="prescripcion" size="25" readonly="readonly">
                          <input type="hidden"  class="redonda5 inputVolantes inputsSig"  name="presuntos" id="presuntos" size="25" readonly="readonly">
                          <input type="hidden"  class="redonda5 inputVolantes inputsSig"  name="montototal" id="montototal" size="25" readonly="readonly">
							<br />
                          
                          <table width="100%">
                            <tr>
                                <td valign='top' id='volTxt'></td>
                            </tr>
                          </table>
                          
                        </td>
                      </tr>
                      <tr>
                        <td  width="195" class="etiquetaPo"><p>Referencia:</p></td>
                        <td>
                            <input type="hidden" name="accionVol" id="accionVol" />
                            <input type="hidden" name="acccionPo" id="acccionPo" />
                            
                              <select name="movimiento" id="movimiento"  class="redonda5 inputVolantes " onchange="completaRemitentes($$('#accionVol').val(),'remitentesUAA',this.value)" >
                                <option value=""><b>Tipo de movimiento...</b></option>
                                <optgroup class="grupo grupoPO" label="Pliego de Observaciones" class="PO">
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
                                 <optgroup class="grupo grupoMEDIOS" label="Medios de Defensa" class="MEDIOS">
                                    <option class="opciones MEDIOS" value="medios_recursos_consideracion" class="MEDIOS"> - Recurso de Reconsideración</option>
                                    <option class="opciones MEDIOS" value="medios_juicio_nulidad" class="MEDIOS"> - Juicio Nulidad</option>
                                    <option class="opciones MEDIOS" value="medios_amparo" class="MEDIOS"> - Amparo</option>
                                    <option class="grupoMEDIOS MEDIOS" value="medios_otros" class="MEDIOS"> - Otros Oficios</option>
                                 </optgroup>
                                 
                                  <?php if( $_SESSION['direccion'] == "DG" && $_SESSION['usuario'] == "esolares") { ?>
                                 <optgroup class="grupo grupoADM" label="Administración" class="ADM">
                                    <option class="grupoADM ADM" value="administracion" class="ADM"> - Administración</option>
                                 </optgroup>
                                  <?php } ?>
                                 <optgroup class="grupo grupoOTROS" label="Otros Movimientos" class="OTROS">
                                    <option class="grupoOTROS OTROS" value="x_otros" class="OTROS"> - Otros Movimientos</option>
                                 </optgroup>
                                    
                              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <!-- <input type="checkbox" name="chkAdm" id="chkAdm" onclick=" $$('.inputsSig').attr('disabled',true) "/> Adm -->
                          </td>
                      </tr>
                      <tr>
                        <td class="etiquetaPo"> <p>Asunto:</p></td>
                        <td>
                          <textarea cols="48" rows="3" class="redonda5 inputVolantes inputsSig" id='asunto' name='asunto'></textarea>
                        </td>
                      </tr>
                    </table>
                    </div>
                    
            	<div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  <tr>
                    <td  class="etiquetaPo" width="195"><p>Remitente:</p></td>
                      
                    <td >
                        <input type="text" name="remitente" id="remitente"  size="50"  class="redonda5 inputVolantes inputsSig" >
                        <!-- <input type="hidden" name="idRem" id="idRem"  size="40"  class="redonda5  inputVolantes" > -->
                    </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo">  <p>Cargo:</p></td>
                    <td>
                      <input type="text" name="cargo" id="cargo"  size="50"  class="redonda5 inputVolantes inputsSig">
                    </td>
                  </tr>
                    <tr>
                    <td class="etiquetaPo">  <p>Dependencia:</p></td>
                    <td>
                      <input type="text" name="dependencia" id="dependencia"  size="50"  class="redonda5 inputVolantes inputsSig">
                    </td>
                  </tr>
                  </table> 
                  </div>
                    
                    
                </td>
        
              <td valign='top' width="50%" >
                   <div class="volDivCont redonda5" style="height:200px">
                    <table align="center" width="100%" border="0" class="tablaPasos tablaVol">                        
                    <tr>
                        <td class="etiquetaPo" width="195"><p>Oficio:</p></td>
                        <td>
                          <input type="text" name="oficio"  size="40"  id="oficio" class="redonda5 inputVolantes inputsSig">
                          </td>
                      </tr>
                        <tr>
                          <td class="etiquetaPo">Fecha Oficio:</td>
                          <td><input type="text" name="fechaOficio" size="25" id="fechaOficio" class="redonda5 inputVolantes inputsSig" /></td>
                        </tr>
                        <tr>
                        <td class="etiquetaPo">Fecha de acuse de recepcion:</td>
                        <td><input type="text" name="fechaAcuse" size="25" id="fechaAcuse" class="redonda5 inputVolantes inputsSig" /></td>
                      </tr>
                     <!--- ---------------------------------------------------------------------------- --> 
                      <tr id="trDT" style="display:none">
                        <td  width="195" class="etiquetaPo"><br /><p>Dictamen Técnico:</p></td>
                        <td><br />
                          <input type="text" name="volanteDT" id="volanteDT" class="redonda5 inputVolantes inputsSig"  size="40"  disabled="disabled">
                          </td>
                      </tr>
                     <!--- ---------------------------------------------------------------------------- --> 
                      <tr id="trConcluida1" style="display:none">
                        <td  width="195" class="etiquetaPo"><br /><p>Cedula:</p></td>
                        <td><br />
                          <input type="text" name="ofConcluida" id="ofConcluida" class="redonda5 inputVolantes inputsSig"  size="40"  disabled="disabled">
                          </td>
                      </tr>
                 	  <tr id="trConcluida2" style="display:none">
                        <td  width="195" class="etiquetaPo"<p>Fecha Cedula:</p></td>
                        <td>
                          <input type="text" name="feConcluida" id="feConcluida" class="redonda5 inputVolantes inputsSig"  size="40"  disabled="disabled">
                          </td>
                      </tr>
                     <!--- ---------------------------------------------------------------------------- --> 
                      
                     </table>
              		</div>
                    
                	<div class="volDivCont redonda5" id="tablaCral"  style="height:100px">
                    <table align="center" width="100%" border="0" class="tablaPasos tablaVol" >                        
                        <tr>
                        <td class="etiquetaPo" width="195"><p>CRAL:</p></td>
                        <td>
                          <input type="text" name="cral"  size="40"  id="cral" class="redonda5  inputVolantes" disabled="disabled">
                          </td>
                      </tr>
                        <tr>
                          <td class="etiquetaPo">Fecha CRAL:</td>
                          <td><input type="text" name="fechaCral" size="25" id="fechaCral" class="redonda5  inputVolantes" disabled="disabled" /></td>
                        </tr>
                        <tr>
                        <td class="etiquetaPo">Acuse Cral:</td>
                        <td><input type="text" name="acuseCral" size="25" id="acuseCral" class="redonda5  inputVolantes" disabled="disabled" /></td>
                      </tr>
                     </table>
                     <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                	</div>
                    
                    
              </td>
            </tr>
            <tr>

            </tr>
            <tr>
            	<td colspan="3" align="center">
                <input type="button" class="submit-login" value="Generar Volante" id="generaVolante" onclick="generarVolante()" />
                </td>
            </tr>
        </table>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
      <?php } ?>
      
      <div id='p2' style=" <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") echo "display:none"; else  echo "display:block";?> " class="contVolantes redonda10 todosContPasos">
      	   <div style="float:right"><img src="images/help.png" /></div>
            <!-- <h3 class="poTitulosPasos">Listado de Oficios</h3> -->
            <h2>Buscar Volante: 
            <input type="text" name="text" id="text" class="redonda5" size="50" onkeyup="">
            <input type="hidden" name="dirVol" id="dirVol" value="<?php echo $_SESSION['direccion'] ?>">
            
            
            </h2>
             <div class="volLista" id="volLista">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
          <form name="formExcel" action="excel.php" method = "POST">
           <input type="hidden" class="" name="export"  id='export' value=""/>
           <input type='hidden' name='nombre_archivo' value='listado_volantes'/>
           <input type = "button" value = "Exportar a Excel" class="submit-login"onclick="exportaExcel()" />
         </form>


        </div>

      </div>
      <!--
      <div id='p3' style="display:none" class="contVolantes redonda10 todosContPasos">
      	<h3 class= "poTitulosPasos">Opciones de Volantes</h3>
      </div>
      -->
</div><!-- end cont volantes -->
