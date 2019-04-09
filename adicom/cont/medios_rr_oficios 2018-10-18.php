
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
  		$$("#volLista").load("procesosAjax/pfrr_oficio_busca.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
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
	
	
	//var veces = 0;
	//-----------------------------------------------------------------
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
	//--------------- validamos acciones segun tipo oficio -------------
	var mut_edos = document.oficioForm.elements["accionEstado[]"];
	//var mut_edos = document.getElementsByName["accionEstado[]"];
	
	
	//------ OFICIOS -------------------------------------------
	var veces = $$('.camposInputAcciones').length;
	//alert( veces );
	
	if( $$('#tipoOficio').val() == 'rr_prevencion')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 35)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) estar en estado *** de requerimiento de información al actor *** ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}
	
	//------------Notificacion Acuerdo Inicio----------------------------
		
	if( $$('#tipoOficio').val() == 'rr_not_acuerdo')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 41)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - En aceptación del recurso ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}

	//------ NOTIFICAR RESOLUCION -------------------------------------------
	
	var numVcs = 0;
	if( $$('#tipoOficio').val() == 'notificarRes_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			numVcs++;

			//if($$(this).val() != 29 || $$(this).val() != 22)
			if($$(this).val() != 22 && $$(this).val() != 29)
			{
				if(VcsMenEdos3 == 0)
				{
					mensaje += "\n - La acción debe estar en el estado \n *** Emisión de la Resolución *** ";
					VcsMenEdos3++;
				}
				error++;	
			}
		});
	}
	if(numVcs > 1) 
	{ mensaje += "\n - Solo se puede notificar una acción"; error++;  }
	
	//------ NOTIFICAR RESOLUCION notificarResEF_PFRR -------------------------------------------
	
	var numVcs = 0;
	if( $$('#tipoOficio').val() == 'notificarResEF_PFRR' || $$('#tipoOficio').val() == 'notificarResICC_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			numVcs++;

			if($$(this).val() != 29 && $$(this).val() != 22 && $$(this).val() != 29 && $$(this).val() != 23 && $$(this).val() != 24 && $$(this).val() != 25  && $$(this).val() != 26)
			//if($$(this).val() != 22)
			{
				if(VcsMenEdos6 == 0)
				{
					mensaje += "\n - La acción debe estar en el estado \n *** Con Existencia de Responsabilidad *** ";
					VcsMenEdos6++;
				}
				error++;	
			}
		});
	}
	if(numVcs > 1) 
	{ mensaje += "\n - Solo se puede notificar una acción"; error++;  }


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
//function agregarCampos(valor,estado,dependencia,procedimiento,estadoTxt,mensaje,oficioAS)
function agregarCampos(idact, acc, dependencia, estado, procedimiento, valor)
//agregarCampos(ui.item.value,ui.item.procedimiento,ui.item.estado,ui.item.estadoTxt,ui.item.mensaje,ui.item.dependencia);
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
		campo += '<div style="height:40px">';
		campo += '<input type="text" size="50" class="redonda5 camposInputAcciones" id="accionVinculada_' + nextinput + '"  name="accionVinculada_' + nextinput + '" value="'+valor+'"  readonly/>';
		campo += '<input type="hidden" size="35" class="redonda5 camposInputIdact" id="idact"  name="idact" value="'+idact+'"  readonly/>';
		campo += '<input type="hidden" size="35" class="redonda5 camposInputAcc" id="acc"  name="acc" value="'+acc+'"  readonly/>';
		campo += '<input type="hidden" size="35" class="redonda5 camposInputDependencia" id="dependencia"  name="dependencia" value="'+dependencia+'"  readonly/>';
		campo += '<input type="hidden" size="1" class="redonda5 camposInputEstado" id="estado"  name="estado" value="'+estado+'"  readonly/>';
		campo += '<input type="hidden" size="37" class="redonda5 camposInputProcedimiento" id="procedimiento"  name="procedimiento" value="'+procedimiento+'"  readonly/>';
		
		campo += '<div class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </div>';
		campo += '</div>';
				
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalAcciones").val(totalAcciones.concat(valor+"|"));
		//----------- agregamos campo y boirramos value de accion -------------
		$$("#camposAcciones").append(campo);
		$$('#accionvolante').attr('value') = "";
		$$('#accionvolante').val('');
	}
	else 
	{ 
		$$("#accionvolante").focus();
		alert ("Esta accion ya la ha ingresado...");
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
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function generarOficio()
{
	//if(comprobarFormulario('oficioForm'))
	//{
		//---------- verificamos que existan acciones --------------
		if($$('.camposInputAcciones').length)
			var totalAcciones = 1;
		else 
		{
			var totalAcciones = 0;
			 alert("Ingrese por lo menos un actor...");
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
				url: "procesosAjax/medios_rr_oficio_genera.php",
				data: $$("#oficioForm").serialize(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//generamos ultimo ID
					//alert(datos);
					new mostrarCuadro(200,500,"Oficio generado...",150)
					$$("#cuadroRes").html(datos);

					// campos en blanco
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
	//}//end confirm
}

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
						url: "procesosAjax/medios_rr_busca_recurrente.php",
						dataType: "json",
						data: {
							term: request.term,
							direccion: $$("#indexDir").val(),
							nivel: $$("#indexNivel").val()
							
						},
						success: function( data ) {
							$$('#idLoad').html('');
							response(data);
							//alert(data);
		  //muestraListados();
						}
					});
			 },
		   minLength: 2,
	  select: function( event, ui ) {  
	   //reseteamos campos al seleccionar accion
		//$$("#tipoOficio").val('');
		
	  	//ocultamos todos los campos 
 		$$(".opciones").css("display","none");
		//mostramos solo los options que se debe
	/*if (ui.item.estado == 35) 
		{
			$$("select[name='tipoOficio'] option[value='rr_prevencion']").show();
			$$("#remitente").val(ui.item.idact).attr('readonly',false);
			$$("#noacc").val(ui.item.acc).attr('readonly',false);
			$$("#oficioRef").val(ui.item.procedimiento).attr('readonly',false);	 
			$$("#dependencia").val(ui.item.dependencia).attr('readonly',false);
			$$("#asunto").val("Requerimientos al Recurrente.").attr('readonly', false);
			$$("select[name='tipoOficio'] option[value='ofic_SAT']").show();
			
		}*/
	/*if (ui.item.estado == 34 || ui.item.estado == 35) 
		{
			$$("select[name='tipoOficio'] option[value='ofic_SAT']").show();
			$$("#remitente").val(ui.item.idact).attr('readonly',false);
			$$("#noacc").val(ui.item.acc).attr('readonly',false);
			$$("#oficioRef").val(ui.item.procedimiento).attr('readonly',false);	 
			$$("#dependencia").val(ui.item.dependencia).attr('readonly',false);
			$$("#asunto").val("Requerimientos al Recurrente.").attr('readonly', false);
 		}*/
	if (ui.item.estado == 36 ) 
		{
			$$("select[name='tipoOficio'] option[value='diligencias_UAA']").show();
			//$$("#remitente").val(ui.item.idact).attr('readonly',false);
			$$("#noacc").val(ui.item.acc).attr('readonly',false);
			$$("#oficioRef").val(ui.item.procedimiento).attr('readonly',false);	 
			//$$("#dependencia").val(ui.item.dependencia).attr('readonly',false);
 		}
	if (ui.item.estado == 39) 
		{
			//$$("select[name='tipoOficio'] option[value='rr_not_acuerdo']").show();
			$$("#remitente").val(ui.item.idact).attr('readonly',false);
			$$("#noacc").val(ui.item.acc).attr('readonly',false);
			$$("#oficioRef").val(ui.item.procedimiento).attr('readonly',false);	 
			$$("#dependencia").val(ui.item.dependencia).attr('readonly',false);
			$$("#asunto").val("Con fundamento en lo dispuesto por el artículo 70, I y II, párrafo segundo de la LFRCF, se admite a trámite el Recurso de Reconsideración interpuesto.").attr('readonly', false);
			$$("select[name='tipoOficio'] option[value='rr_not_acuerdo_s']").show();		
 		}
	if (ui.item.estado == 391)
		{
			//agregarSelect(ui.item.value);
			//$$("select[name='tipoOficio'] option[value='rr_not_des_r']").show();
			$$("#remitente").val(ui.item.idact).attr('readonly',false);
			$$("#noacc").val(ui.item.acc).attr('readonly',false);
			$$("#oficioRef").val(ui.item.procedimiento).attr('readonly',false);	 
			$$("#dependencia").val(ui.item.dependencia).attr('readonly',false);
			$$("#asunto").val("Desechamiento del Recurso de Reconsideración.").attr('readonly', false);
			$$("select[name='tipoOficio'] option[value='rr_not_des_s']").show();
 		}
	if (ui.item.estado == 41 || ui.item.estado == 42 || ui.item.estado == 43) 
		{
			$$("select[name='tipoOficio'] option[value='rr_not_resol_act']").show();
			$$("#remitente").val(ui.item.idact).attr('readonly',false);
			$$("#noacc").val(ui.item.acc).attr('readonly',false);
			$$("#oficioRef").val(ui.item.procedimiento).attr('readonly',false);	 
			$$("#dependencia").val(ui.item.dependencia).attr('readonly',false);
			$$("select[name='tipoOficio'] option[value='rr_not_resol_sat']").show();
			$$("#asunto").val("").attr('readonly', false);
			$$("select[name='tipoOficio'] option[value='rr_not_ef']").show();
			$$("select[name='tipoOficio'] option[value='rr_not_icc']").show();
 		}
	  //agregarCampos(ui.item.value,ui.item.procedimiento,ui.item.estado,ui.item.estadoTxt,ui.item.mensaje,ui.item.dependencia,ui.item.oficioAS);
		agregarCampos(ui.item.idact, ui.item.acc, ui.item.dependencia, ui.item.estado, ui.item.procedimiento, ui.item.value);
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
  	$$("#volLista").load("procesosAjax/adm_oficio_busca.php");
	// --------------- AGREGA el option administrativo a select ---------------
	//if($$("#indexDir").val() == "DG") $$('#tipoOficio').append('<option value="administrativo" selected="selected">Administrativo</option>');
	
});

function cambiomsg()
{
	if($$("#tipoOficio").val() == "rr_not_resol_act")
	{
		$$("#asunto").val("Se Notifica al Actor la Resolución del Recurso de Reconsideración.").attr('readonly', false);
	}
	else if($$("#tipoOficio").val() == "rr_not_resol_sat" || $$("#tipoOficio").val() == "rr_not_ef" || $$("#tipoOficio").val() == "rr_not_icc")
	{
		$$("#remitente").val("").attr('readonly', false);
		$$("#dependencia").val("").attr('readonly', false);
		$$("#asunto").val("Se Notifica la Resolución del Recurso de Reconsideración.").attr('readonly', false);
	}
	else if($$("#tipoOficio").val() == "diligencias_UAA")
	{
		$$("#asunto").val("").attr('readonly', false);
	}
	else if($$("#tipoOficio").val() == "rr_prevencion" || $$("#tipoOficio").val() == "ofic_SAT")
	{
		if($$("#tipoOficio").val() == "ofic_SAT"){
			$$("#remitente").val("").attr('readonly', false);
			$$("#dependencia").val("").attr('readonly', false);
		}
		$$("#asunto").val("Requerimientos al Recurrente.").attr('readonly', false);
	}
	else if($$("#tipoOficio").val() == "rr_not_acuerdo" || $$("#tipoOficio").val() == "rr_not_acuerdo_s")
	{
		if($$("#tipoOficio").val() == "rr_not_acuerdo_s"){
			$$("#remitente").val("").attr('readonly', false);
			$$("#dependencia").val("").attr('readonly', false);
		}
		$$("#asunto").val("Con fundamento en lo dispuesto por el artículo 70, I y II, párrafo segundo de la LFRCF, se admite a trámite el Recurso de Reconsideración interpuesto.").attr('readonly', false);
	}
	else if($$("#tipoOficio").val() == "rr_not_des_r" || $$("#tipoOficio").val() == "rr_not_des_s")
	{
		if($$("#tipoOficio").val() == "rr_not_des_s"){
			$$("#remitente").val("").attr('readonly', false);
			$$("#dependencia").val("").attr('readonly', false);
		}
		$$("#asunto").val("Desechamiento del Recurso de Reconsideración.").attr('readonly', false);
	}
	else if($$("#tipoOficio").val() == "NULL")
	{
		$$("#asunto").val("").attr('readonly', false);
	}
} 

//---------------------------------- VERIFICA OPCION ----------------------------------

function verificaOpcion(opcion)
{
	
	if(opcion == 'rr_prevencion')
	{
		if($$('#accionVinculada_1').length)// si existe #accionVinculada
			agregarSelect($$('#accionVinculada_1').val());
	}
	/*else  
	{
		$$("#idRemitente").html('<input type="text" name="remitente" id="remitente" size="50" class="redonda5" >');
		$$("#cargo").val("");
		$$("#dependencia").val("");
		
		$$.ajax
		({
			beforeSend: function(objeto)
			{
			 //$$('#volLista2').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
			 //alert('hola');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar \n - Exito = "+exito)
				//if(exito=="success"){ alert("Y con éxito");	}
			},
			type: "POST",
			url: "procesosAjax/medios_busca_remitente_oficios.php",
			data: {
					opcion:opcion,
					acciones:$$("#totalAcciones").val(),
					accion:$$('#accionVinculada_1').val()
				},
			/*success: function(datos)
			{ 
				//alert(datos);
				var dat = datos.split("|");
				
				if(dat[5] != 1) // si error es != 1
				{
					//todos loa campos de solo lectura
					$$("#cargo").attr("readonly",true); 
					$$("#remitente").attr("readonly",true);
					$$("#dependencia").attr('readonly',true);	 
					$$("#oficioRef").attr('readonly',true);	
					$$("#asunto").attr('readonly',true);
					// asignamos valores 	 
					$$("#remitente").val(dat[0]);
					$$("#cargo").val(dat[1]);
					$$("#dependencia").val(dat[2]);
					$$("#oficioRef").val(dat[3]);
					$$("#asunto").val(dat[4]);
					// mensajes de error
					if(dat[3] == "") $$("#oficioRef").attr('readonly',false);	
					if(opcion == 'Not_icc_PFRR' && dat[0] == '') alert("Esta acción no tiene Autoridades, favor de ingresarlas...");
				}
				else alert("Las UAA's son diferentes por favor ingrese solo acciones de la misma UAA");
				if(opcion == 'otros_PFRR' || opcion == 'sat_PFRR' || opcion == 'ef_PFRR' || opcion == 'icc_PFRR' || opcion == 'imss_PFRR' || opcion == 'issste_PFRR' || opcion == 'tribunal_pfrr' || opcion == 'comision_pfrr'|| opcion == 'pruebas_alcanceOT'|| opcion =='PFRR_citacion' || opcion=='solicitar_inf_tercero' || opcion=='enviar_info_ter' ||opcion=='continuacion_aud') 
				{
					$$("#cargo").attr("readonly",false); 
					$$("#remitente").attr("readonly",false);
					$$("#dependencia").attr('readonly',false);	 
					$$("#oficioRef").attr('readonly',false);	
					$$("#asunto").attr('readonly',false);
				}

			}
		});
	}*/
} 

/*function agregarSelect(accion)
{
	$$.ajax({
		type: "POST",
		url: "procesosAjax/pfrr_oficios_buscaPresuntos.php",
		//dataType: "json",
		data: {
			accion: accion
		},
		success: function( datos ) {
			
			//alert(datos)
			var todo = datos.split("|");
			var presuntos = todo[0];
			var idpresuntos = todo[1];
			var cargos = todo[2];
			var dependencias = todo[3];
			
			var ides = idpresuntos.split('-');
			var pres = presuntos.split('-');
			var cargo = cargos.split('-');
			var dependencia = dependencias.split('-');
			
			var selectPresuntos = " <select name='remitente' id='remitente'  class='redonda5' > ";
			selectPresuntos = selectPresuntos + " <option value=''> Seleccione un Presunto Responsable... </option> ";
			
			for (var ele in ides) 
			{
				if(pres[ele] != "")
				{
					selectPresuntos = selectPresuntos + "<option value='"+ides[ele]+"' onclick=\" $$('#cargo').val('"+cargo[ele]+"');  $$('#dependencia').val('"+dependencia[ele]+"');  \" > "+pres[ele]+" </option>";
				}
			}
			selectPresuntos = selectPresuntos + "</select>";
			$$("#idRemitente").html(selectPresuntos);
			
			$$("#oficioRef").val($$(".camposInputProcedimientos").val());
			$$("#asunto").val("Se notifica citatorio y se cita a comparecer al presunto responsable, en las instalaciones de la ASF ubicadas en el CEA");

		}
	});
	//--------------------------
}*/
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
</style>
<link href="css/estilos_medios.css" rel="stylesheet" type="text/css" media="all" />

<title>Norx zilla</title>

<div id="contPFRR" style="padding:10px">
    <!-- <div id='colorSelector'>hola</div> -->

	<div class="encVol">
      <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR OFICIO </div>
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR OFICIOS </div>
        <div id='paso3' onclick="muestraPestanaVol(3)" class="todosPasos pasos"> OFICIOS 2013 </div>
    </div>
    <div id='p1' class="contOficios redonda10 todosContPasos">
        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="oficioForm" id="oficioForm" method="post" action="#">
            <table width="90%" align="center">
            <tr>
                <td width="40%">
                    <div class="volDivCont redonda5">
                    <table  align="center" width="100%" border="0" class="tablaPasos tablaVol">

                      <tr>
                        <td class="etiquetaPo" width="100"> <p>Agregar Actor :</p></td>
                        <td>
                          <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="35" style="float:left;"> <span id="idLoad" style="float:left; padding:0 5px"></span>
                        </td>
                      </tr>
                    
                     <tr>
                        <td class="etiquetaPo" width="100"> <p>Tipo de oficio :</p></td>
                        <td>
                          <select name="tipoOficio" id="tipoOficio" class="redonda5" onclick="cambiomsg()" >
                          	<optgroup label="Proceso de la Acción">
                                <option value="" select="select">Seleccione el tipo de oficio...</option>
                            <?php
								 $sql = $conexion->select("SELECT * FROM oficios_options WHERE estado = 'medios_rr' AND tipo = 'proceso' ", false); 
								 while($r = mysql_fetch_array($sql)) echo "<option class='opciones' value='".$r['value']."'> &nbsp;&nbsp;&nbsp; - ".$r['texto']."</option>";
							?>
                            </optgroup>
							<optgroup label="Otros Oficios">
							<?php
								 $sql = $conexion->select("SELECT * FROM oficios_options WHERE estado = 'medios_rr' AND tipo = 'otros' ORDER BY texto", false); 
								 while($r = mysql_fetch_array($sql)) echo "<option value='".$r['value']."'> &nbsp;&nbsp;&nbsp; - ".$r['texto']."</option>";
							?>
                            </optgroup>
                          </select>
                        </td>
                      </tr>
                      
    
    
                        </td>
                      </tr>
                      </table> 
                    </div>
    
                    <div class="volDivCont redonda5">
                    <table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                     
                      <tr>
                        <td  class="etiquetaPo" width="100"><p>Destinatario :</p></td>
                          
                        <td id='idRemitente'>
                            <input type="text" name="remitente" id="remitente" size="50" class="redonda5" >
                            <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5" > -->
                        </td>
                      </tr>
					                        <tr>
                        <td  class="etiquetaPo" width="100"><p>Acción :</p></td>
                          
                        <td id='idRemitente'>
                            <input type="text" name="noacc" id="noacc" size="50" class="redonda5" >
                            <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5" > -->
                        </td>
                      </tr>
                        <tr>
                        <td class="etiquetaPo">  <p>Entidad :</p></td>
                        <td>
                          <input type="text" name="dependencia" id="dependencia" size="50" class="redonda5" value="">
                        </td>
                      </tr>
                      </table> 
                      </div>
                  </td>
                  <td width="60%" rowspan="2" valign="top">
                       <div class="camposAcciones redonda5" id="camposAcciones" style="height:330px; width:100%">
                       <h3>Acciones Vinculadas <span id="accionesNo">0</span> </h3>
                       
                        </div>
                        <input type="hidden" name="totalAcciones" id="totalAcciones" size="40" class="redonda5">
                        <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="40" class="redonda5">
                  </td>
                </tr>
                <tr>
                    <td width="50%">
                        <div class="volDivCont redonda5">
                         <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
                          <tr>
                            <td class="etiquetaPo" width="100"> <p>Referencia :</p></td>
                            <td>
                              <input type="text" name="oficioRef" id="oficioRef" class="redonda5" size="50">
                            </td>
                          </tr>
                            <td class="etiquetaPo"> <p>Asunto :</p></td>
                            <td>
                              <textarea cols="50" rows="3" class="redonda5" id='asunto' name='asunto'></textarea>
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
                    <input type="button" class="submit-login" value="Generar Oficio" id="generaOficio" onclick="generarOficio()" />
                    </td>
                </tr>
            </table>
        </form>
      </div><!-- end cont vol1 volantes -->
      <div id='p2' style="display:none" class="contOficios redonda10 todosContPasos">
      	    <div style="float:right"><img src="images/help.png" /></div>
            <!-- <h3 class="poTitulosPasos">Listado de Oficios</h3> -->
            <h2>Buscar Oficio: 
            <input type="text" name="text" id="text" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista" id="volLista">
             	<!-- AQUI VAN LOS RESULTADOS -->
                 <form name="formExcel" action="excel.php" method = "POST">
           <input type="hidden" class="" name="export"  id='export' value=""/>
           <input type='hidden' name='nombre_archivo' value='listado_volantes'/>
           <input type = "submit" value = "Exportar a Excel" class="submit-login" />
         </form>
             </div>
        </div>

      </div>
      <div id='p3' style="display:none" class="contOficios redonda10 todosContPasos">
            <h2>Buscar Oficio: 
            <input type="text" name="text2" id="text2" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista2" id="volLista2">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
             
            
      </div>
</div><!-- end cont volantes -->