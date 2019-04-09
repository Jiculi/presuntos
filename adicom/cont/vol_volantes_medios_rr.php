<link rel="stylesheet" href="css/estilos_volantes.css" type="text/css" media="screen" title="default" />

<script> 
// ------------ carga fechas de oficios---------------------------------------
function cargaFechaOficio(fecha)
{
	//alert(fecha)
	$$( "#fechaOficio" ).datepicker({
	// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		// minDate: fecha,
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
function agregarCampos(idPresunto,nombre,estado,edoTxt,turnado,direccion,accion,cargo)
{
	var presuntosAccion = nombre+' - '+accion;
	var igual = 0;
	
	var totalAcciones = $$("#totalAcciones").val();
	//checar misma accion
	$$('.presuntoAccion').each( function(){
	  var $$this = $$(this);
	  //$this.css( 'text-decoration' , 'underline' );
	  if(presuntosAccion == $$this.val()) igual++;
	});
	//-------------------------------------------------------------------------
	//alert(igual)
	if(igual == 0)
	{
		nextinput++;
		accionesNum++;
		$$("#accionesNo").html(accionesNum);
		$$("#totalNoAcciones").val(accionesNum);
		
		campo = '<input type="hidden" class="campoInputVol camposInputAcciones presuntoAccion" name="presuntoAccion" id="presuntoAccion" value="'+nombre+' - '+accion+'"   readonly/>';
		campo += '<div id="rut'+nextinput+'" class="divRecurrente redonda5">';
		campo += 'Recurrente: '+nombre+'<input type="hidden" size="" class="redonda5 campoInputVol camposInputAcciones" id="presuntoVinculada_' + nextinput + '"  name="presuntoVinculada[]" value="'+(nombre)+'"   readonly/>';
		campo += '<input type="hidden" size="" class="redonda5 campoInputVol camposInputAcciones" id="idPresuntoVinculada_' + nextinput + '"  name="idPresuntoVinculada[]" value="'+(idPresunto)+'"   readonly/>';
		campo += '<br>Cargo: '+cargo+'<input type="hidden" size="" class="redonda5 campoInputVol camposInputAcciones" id="presuntoCargo_' + nextinput + '"  name="presuntoCargo[]" value="'+(cargo)+'"   readonly/>';
		campo += '<br>Accion: '+accion+'<input type="hidden" size="" class="redonda5 campoInputVol camposInputAcciones" id="accionVinculada_' + nextinput + '"  name="accionVinculada[]" value="'+accion+'"  readonly/>';
		campo += '<br>Estado: '+edoTxt+'<input type="hidden" size="" class="redonda5 campoInputVol camposInputEdoTxt" id="accionEdoTxt_' + nextinput + '"  name="accionEdoTxt[]" value="'+(edoTxt)+'"   readonly/>';		
		campo += '<input type="hidden" size="" class="redonda5 campoInputVol camposInputEstados" id="accionEstado_' + nextinput + '"  name="accionEstado[]" value="'+estado+'"  readonly/>';		
		campo += '<br>Turnado: '+turnado+' Dirección '+direccion+'<input type="hidden" size="" class="redonda5 campoInputVol camposInputTurnado" id="accionTurnado_' + nextinput + '"  name="accionTurnado[]" value="'+turnado+'"  readonly/>';		
		campo += '<input type="hidden" size="" class="redonda5 campoInputVol camposInputTurnado" id="accionDireccion_' + nextinput + '"  name="accionDireccion[]" value="'+direccion+'"  readonly/> ';		
		campo += '<div class="eliminar-RR" onclick="elimina_me(\'rut'+nextinput+'\')">  </div> ';
		campo += '</div>';
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalAcciones").val(totalAcciones.concat(accion+"|"));
		//----------- agregamos campo y boirramos value de accion -------------
		$$("#volTxt").append(campo);
		$$('#txtRecurrente').attr('value') = "";
		$$('#txtRecurrente').val('');
	}
	else 
	{ 
		$$("#txtRecurrente").focus();
		alert ("Este Recurrente y acción ya la ha ingresado...");
		$$('#txtRecurrente').attr('value') = "";
		igual = 0;
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
/*
function insertaAccion(){
	if(comprobarForm('volanteForm')){
		//-------------- validar de estados ---------------------
		var errorEdos = 0;
		var menEdo = "";
		var edo = $$('#estado').val();
		var mov = $$('#movimiento').val();
		//------------ asignamos los valore en la funcion -------
		var estado = $$('#estado').val();
		var edoTxt = $$('#edoTxt').val();
		var turnado = $$('#turnado').val();
		var direccion = $$('#direccion').val();
		var accion = $$('#accionVol').val();
		var nombre = $$('#recurrente').val();
		var ref = $$('#movimiento').val();
		var asunto = $$('#asunto').val();
		var remitente = $$('#remitente').val();
		var cargo = $$('#cargo').val();
		var oficio = $$('#oficio').val();
		var ofiFec = $$('#fechaOficio').val();
		var ofiFecAcu = $$('#fechaAcuse').val();
		var ofiRef = $$('#referencia').val();
		//-------------------------------------------------------
		agregarCampos(nombre,estado,edoTxt,turnado,direccion,accion,ref,asunto,remitente,cargo,oficio,ofiFec,ofiFecAcu,ofiRef)
		$$('.inputsSig').val('');// inputs del form
		$$('#volTxt').html("");
	}
}
*/
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
//----------------------------  INFO -----------------------------------------------
function cargaInfo(valor)
{
	$$(".inputsSig").val("");
	if(valor == 33.1) {
		$$("#asunto").val("Recepción de la Solicitud de Recurso de Reconsideración");
		$$("#oficio").val("Escrito-RR");
		$$("#asunto").prop("readonly",true);
		$$("#oficio").prop("readonly",true);
	}
	if(valor == 33.2) {
		$$("#asunto").val("Recepción de Información de Recurso de Reconsideración");
		$$("#oficio").val("Información-RR");
		$$("#asunto").prop("readonly",true);
		$$("#oficio").prop("readonly",true);
	}
	if(valor == "x_otros") {
		//$$("#txtRecurrente").prop("disabled",true);
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
		$$("#volTxt").html("Turnado: Dirección 'C' - Miguel Angel Santos Ramirez	 <br>Edo Trámite: Medios de Defensa  ");
		
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
			}
		});		
	}
}
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------
function generarVolante()
{
	//alert($$("#todasAccionesVol").serialize())
	//name="volanteForm" 
	if(comprobarForm('volanteForm') && ($$("#totalNoAcciones").val() != 0 || $$("#totalNoAcciones").val() != "")){
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
			data: $$("#volanteForm").serialize(),
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
				new mostrarCuadro(450,800,"Volante de Correspondencia",70,"cont/vol_volante_medios.html.php","folio="+datos)
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
	$$("#referencia").autocomplete({
	 //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						type: "POST",
						url: "procesosAjax/ofi_busqueda_oficio.php",
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
			//$$("#cargo").val(ui.item.cargo);
			//$$("#oficio").focus();
			
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
						beforeSend: function(objeto)
						{
							$$('#idLoad').html('<img src="images/load_chico.gif">');
						},
						type: "POST",
						//url: "procesosAjax/vol_busqueda_volantesaccion.php",
						url: "procesosAjax/vol_busqueda_recurrente.php",
						dataType: "json",
						data: {
							term: 	request.term
							//movimiento:	$$("#movimiento").val()
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
		//alert(ui.item.sql);
		
		//$$("#accionvolante").val(ui.item.value);
		//$$("#accionVol").val(ui.item.accion);
		//$$("#recurrente").val(ui.item.nombre);
		//$$("#remitente").val(ui.item.nombre);
		//$$("#cargo").val(ui.item.cargo);
		//$$("#estado").val(ui.item.estado);
		//$$("#edoTxt").val(ui.item.estadoTxt);
		//$$("#turnado").val("Miguel Angel Santos Ramirez");
		
		$$(".recurso").remove();	
		
		if(ui.item.estado == 32) {
			$$("#movimiento").append(' <option class="recurso" value="33.1"> Interposicion de Recurso de Reconsideración </option> ');
			$$("#asunto").val("Recepción de la Solicitud de Recurso de Reconsideración.");
			$$("#campoOficio").html("");
			cargaFechaOficio(ui.item.fechaReferencia);
			$$("#oficio").prop("type", "hidden");
			$$("#oficio").val("Escrito-RR");
			$$("#asunto").prop("readonly",true);
			$$("#oficio").prop("readonly",true);		
		}
		if(ui.item.estado == 35) {
			$$("#movimiento").append('  <option class="recurso" value="33.2"> Recepción de Información </option>  ');
			$$("#remitente").val(ui.item.refDestinatario);
			$$("#cargo").val(ui.item.refCargo);
			$$("#campoOficio").html("Referencia: ");
			$$("#oficio").prop("type", "text");
			$$("#oficio").val(ui.item.referencia);
			$$("#oficio").prop("readonly",true);
			cargaFechaOficio(ui.item.fechaReferencia);
			$$("#asunto").val("Recepción de Información de Recurso de Reconsideración.");
			$$("#asunto").prop("readonly",true);
			//-----------------
			$$("#campoFechaSol").html("");
			$$("#campoFechaAcuSol").html("");
			$$("#fechaOficio").prop("type", "hidden");
			$$("#fechaAcuse").prop("type", "hidden");
		}
		if(ui.item.estado == 45) {
			cargaFechaOficio(ui.item.fechaReferencia);
			$$("#movimiento").append('  <option class="recurso" value="46"> Recepción de Información/Documentación Solicitada </option>  ');
			$$("#asunto").val("En respuesta al oficio en referencia recibimos la Información/Documentación solicitada.");
			$$("#filaReferencia").html('<td class="etiquetaPo" id="campoReferencia">Referencia: </td><td>  <input value="'+ui.item.referencia+'" type="text" name="referencia" id="referencia" size="25"  class="redonda5 inputVolantes inputsSig "> </td>');
			$$("#remitente").val(ui.item.refDestinatario);
			$$("#cargo").val(ui.item.refCargo);
			$$("#campoOficio").html("Oficio:");
			$$("#campoFechaSol").html("Fecha Oficio:");
			$$("#campoFechaAcuSol").html("Fecha Acuse Oficio:");
			cargaFechaOficio(ui.item.fechaReferencia);
			$$("#oficio").prop("type", "text");
			//$$("#oficio").val(ui.item.oficio);
			//$$("#fechaOficio").val(ui.item.fechaOficio);
			$$("#asunto").prop("readonly",true);
		}
		//agregarCampos(nombre,estado,edoTxt,turnado,direccion,accion,ref,asunto,remitente,cargo,oficio,ofiFec,ofiFecAcu,ofiRef)
		agregarCampos(ui.item.idPresunto,ui.item.nombre,ui.item.estado,ui.item.estadoTxt,"Miguel Angel Santos Ramirez","C",ui.item.accion,ui.item.cargo)
		
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
		  //if(!ui.item)  $$(event.target).val("");
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
//-------------------------------------------------------
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
		//$$("#dependencia").val(ui.item.dependencia);
		$$("#oficio").focus();
		
	 }
		});//end
}); 

</script>

<style>
.ui-autocomplete {
	max-height: 200px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
}
.volanteDivContRR
{
	height:150px !important;	
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

    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
    <div id='p1' class=" redonda10 todosContPasos" >
        
        <form name="volanteForm" id="volanteForm" method="post" action="#">
        <table width="100%" align="center">
        <tr>
            <td width="25%" valign="top">
            
                <div class="volanteDivContRR redonda5"  style="height:200px;background: #FFB0B0 ">
                 <table align="center" width="100%" border="0" class="tablaPasos tablaVol"> 
                  <tr>
                    <td width="70" class="etiquetaPo"> <p>Recurrente:</p></td>
                    <td valign='top'>
                      <input type="text" name="txtRecurrente" id="txtRecurrente" class="redonda5 numAccion campoInputVol inputsSig"  size="40"  style="float:left">
                      <span id="idLoad"  style="float:left; padding:0 5px; width:30px"></span>
                       
                      <input type="hidden" name="accionVol" id="accionVol" />
                      <input type="hidden" name="recurrente" id="recurrente" />
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="direccion" id="direccion" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="turnado" id="turnado" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="estado" id="estado" readonly="readonly">
                      <input type="hidden"  class="redonda5 inputVolantes  inputsSig"  name="edoTxt" id="edoTxt" readonly="readonly">
                   	</td>
                   </tr>
                 
                  <tr>
                    <td  width="" class="etiquetaPo"><p>Movimiento:</p></td>
                    <td>
                        
                          <select name="movimiento" id="movimiento" style="width:200px"  class="redonda5 inputVolantes  " onchange="" >
                            <!-- <option value=""><b>Tipo de movimiento...</b></option> -->
                            
                          </select>
                        <!-- <input type="checkbox" name="chkAdm" id="chkAdm" onclick=" $$('.inputsSig').attr('disabled',true) "/> Adm -->
                      </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo"> <p>Asunto:</p></td>
                    <td>
                      <textarea cols="45" rows="2" class="redonda5 inputVolantes  inputsSig" id='asunto' name='asunto'></textarea>
                    </td>
                  </tr>
                </table>
                </div>
                
            
            </td>
            
            <td  width="25%" rowspan="5" valign="top">
                <div class="volanteConRem redonda5" >
                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
                    <div style="text-align:left; float:left; width:500px">Recurrentes: <span id="accionesNo">Ninguno</span></div>

                   <!-- ----------------- -->
                      <table width="100%">
                        <tr>
                            <td valign='top' >
                            <div id='volTxt'>
                            </div>
                            </td>
                        </tr>
                      </table>
                   <!-- ----------------- -->
                   </div>
            </td>
            </tr><tr>
            <td width="25%" valign="top">
            
                <div class="volanteDivContRR redonda5" >
                <table>
                    <tr>
                        <td width="140" class="etiquetaPo" >Remitente: </td><td>  <input type="text" name="remitente" id="remitente"  size="40"  class="redonda5 inputVolantes inputsSig " > </td>
                    </tr><tr>
                      	<td width="140" class="etiquetaPo" >Cargo: </td><td>  <input type="text" name="cargo" id="cargo"  size="40"  class="redonda5 inputVolantes inputsSig "></td>
                    </tr><tr>
                        <td width="140" class="etiquetaPo" width="200" id="campoOficio" >  <p>Oficio:</p>  </td>
                        <td>
                          <input type="hidden" name="oficio"  size="30"  id="oficio" class="redonda5 inputVolantes inputsSig ">
                         </td>
                    </tr> <tr>
                      	<td width="140" class="etiquetaPo" id="campoFechaSol">Fecha de Solicitud de RR:</td>
                      <td><input type="text" name="fechaOficio" size="25" id="fechaOficio" class="redonda5 inputVolantes inputsSig " /></td>
                    </tr><tr>
                    	<td width="140" class="etiquetaPo" id="campoFechaAcuSol">Fecha de Acuse de Solicitud de RR:</td>
                    	<td><input type="text" name="fechaAcuse" size="25" id="fechaAcuse" class="redonda5 inputVolantes inputsSig " /></td>
                  </tr>

                 </table>
                </div>
          </td>
        </tr>
      <tr>
        <td colspan="5">
        	<center>
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario'] ?>" >
                <input type="hidden" name="nivel" id="nivel" value="<?php echo $_SESSION['nivel'] ?>" >
            	<input type="hidden" value="tipoFormRR" name="tipoPOST"  id="tipoPOST" />
            	<input type="button" class="submit-login" value="Generar Volante" id="generaVolante" onclick="generarVolante()" />
            </center>
        </td>
      </tr>
	</table>
      </div><!-- end cont vol1 volantes -->
      <?php } ?>
</div><!-- end cont volantes -->
