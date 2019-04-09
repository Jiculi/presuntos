<?php
session_start();
if($_SESSION['acceso'] != true && $_SESSION['ADICOM-BETA'] != true)	header ("Location: login.php ");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$idJuicio = $_REQUEST['id'];
$accion = $_REQUEST['accion'];
$jn = valorSeguro($_REQUEST['juicionulidad']);




?>

<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script>
 
function cerrarAltaOficio() {
	$("#altaOficio").fadeOut();
	$('#popup-overlay').fadeOut('slow');
}


 
function comprobarFormulario(form) {
	//alert(' Campos = '+oficios);
	
	let mensaje = " ";
	var elementos = "";
	let error = 0;
	var adver = 0;
	var VcsMenEdos = 0;
	var VcsMenCita = 0;
	var VcsMenEdos2 = 0;
	var VcsMenEdos3 = 0;
	var VcsMenEdos4 = 0;
	//var veces = 0;
	//alert( $('#tipo').val());
	document.getElementById("error").innerHTML = " ";
	if( $('#tipo').val() == 'requerido'){
		document.getElementById('tipo').style.borderColor = 'red';
		error++;
		mensaje = " - El tipo de oficio es obligatorio";
		document.getElementById("tipo").focus();	
	} else {
		document.getElementById('tipo').style.borderColor = 'silver';

		if( $('#remitente').val() == ''){
			document.getElementById('remitente').style.borderColor = 'red';
			error++;
			mensaje = " - El destinatario es obligatorio";
			document.getElementById("remitente").focus();	
		} else {
			document.getElementById('remitente').style.borderColor = 'silver';

			if( $('#asunto').val() == ''){
				document.getElementById('asunto').style.borderColor = 'red';
				error++;
				mensaje = " - El asunto es obligatorio";
				document.getElementById("asunto").focus();		
			} else {
				document.getElementById('asunto').style.borderColor = 'silver';
			}
		}
	}
	
	document.getElementById("error").innerHTML = mensaje;

    /*

	//-----------------------------------------------------------------
	frm = document.forms[form];
	for(i=0; ele=frm.elements[i]; i++)
	{
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
	//------ devolucion DTNS -------------------------------------------
	var veces = $('.camposInputAcciones').length;
	//alert( veces );
	
	if( $('#tipo').val() == 'dtns_PFRR')
	{
		$(".camposInputEstados").each(function() {
			if($(this).val() != 11)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) estar en estado *** Revisión del Expediente Técnico por no Solventación del PO *** ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}
	//------ citatorio_PFRR -------------------------------------------
	if( $('#tipo').val() == 'citatorio_PFRR')
	{
		$(".camposInputProcedimientos").each(function() {
			if($(this).val() == "")
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) tener Número de Procedimiento ";
					VcsMenCita++;
				}
				error++;	
			}
		});
	}
	//------ OPINION TECNICA DE LA UAA -------------------------------------------
	if( $('#tipo').val() == 'opinion_UAA_PFRR')
	{
		$(".camposInputEstados").each(function() {
			if($(this).val() != 17 || $(this).val() != 18)
			{
				if(VcsMenEdos2 == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) estar en los estados \n *** En desahogo de Audiencia de Ley *** \n *** Formulación, desahogo de pruebas y período de alegatos ***";
					VcsMenEdos2++;
				}
				error++;	
			}
		});
	}
	//------ NOTIFICAR RESOLUCION -------------------------------------------
	var numVcs = 0;
	if( $('#tipo').val() == 'notificarRes_PFRR')
	{
		$(".camposInputEstados").each(function() {
			numVcs++;

			if($(this).val() != 29)
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
	if(numVcs > 0) 
	{ mensaje += "\n - Solo se puede notificar una acción"; error++;  }
	//------------------------- SAT -------------------------------------------
	var numVcs = 0;
	if( $('#tipo').val() == 'sat_PFRR')
	{
		$(".camposInputEstados").each(function() {
			numVcs++;

			if($(this).val() != 29)
			{
				if(VcsMenEdos4 == 0)
				{
					mensaje += "\n - La acción debe tener generado un número de PDR ";
					VcsMenEdos4++;
				}
				error++;	
			}
		});
	}
	if(numVcs > 0) 
	{ mensaje += "\n - Solo se puede generar un oficio del SAT por acción"; error++;  }

	*/
   //----------------------------------------------------------------------------
	if(error != 0)
	{
			// alert(mensaje);
			// $( "#dialog" ).dialog();
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


//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function dameOficio() {
	if(comprobarFormulario('oficioForm'))
	{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					$('#generaOficio').attr("disabled",true);
					$('#generaOficio').css( "background", "gray" );
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/jn_oficio_genera.php",
				//data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#new_cargo_servidor').val()+"&irregularidad="+$('#new_irregularidad').val()+"&monto="+$('#new_monto').val(),
				data: $("#oficioForm").serialize(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
                success: function(datos) {
                    let folio = datos.split("|");
                    $("#numeroOficio").val(folio[0]);
                    $("#diaOficio").val(folio[1]);
                    $("#horaOficio").val(folio[2]);
					$('#generaOficio').val('Oficio generado...');

					//generamos ultimo ID
                    //alert(datos);
                    
                    /*
					new mostrarCuadro(200,500,"Oficio generado...",150)
					$("#cuadroRes").html(datos);

					// campos en blanco
					$(".redonda5").val("");
					$("#camposAcciones").html(""); 
					//---------------------------------------------------------
					$('#generaOficio').attr("disabled",false);
					$('#generaOficio').val('Generar Oficio');
                    $('#generaOficio').css( "background", "#333" );
                    */
					
				}
			});
	}//end confirm
}

//------------------------------- AUTOCOMPLETE ACCION --------------------------------

	$(function() {
		 // configuramos el control para realizar la busqueda de los productos
		 $("#remitente").autocomplete({
			source: function( request, response ) {
					
					$.ajax({
						type: "POST",
						url: "procesosAjax/jn_busqueda_nombre.php",
						dataType: "json",
						data: {
							term: request.term,
						},
						success: function( data ) {
							response(data);
						}
					});
				 },
			minLength: 2,
		   	select: function( event, ui ) 
		   		{  
				$("#cargo").val(ui.item.cargo);
				$("#dependencia").val(ui.item.dependencia);
				$("#asunto").focus();
			
		  		}
		});
	}); 
//------------------------------- AUTOCOMPLETE ACCION --------------------------------
/*
$(function() 
{
	$("#accionvolante").autocomplete({
		source: function( request, response ) {
					$.ajax({
						type: "POST",
						url: "procesosAjax/jn_oficios_buscaAccion.php",
						dataType: "json",
						data: {
							term: request.term,
							direccion: $("#indexDir").val()
						},
						success: function( data ) {
							response(data);
						}
					});
			 },
		   minLength: 2,
	  	select: function( event, ui ) { 
			// PDR <--juicionulidad 
			// agregarCampos(ui.item.value,ui.item.estado,ui.item.procedimiento,ui.item.juicionulidad);
	  	},
	  	change: function (event, ui) {
		   if(!ui.item)  $(event.target).val("");
    	},
	  	focus: function (event, ui) {
        	return false;
    	}
	});//end
}); 
*/

//---------------------------------- BUSCAR OFICIOS -----------------------------------	
//--------------------------------------------------------------------------------------
$( document ).ready(function() {
	$("#userForm").val($("#indexUser").val());
	$("#dirForm").val($("#indexDir").val());
	$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
	
});
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------


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
<link rel="stylesheet" href="css/juiciosOficio.css" type="text/css" media="screen" title="default" >

<!-- <link href="css/estilos_medios.css" rel="stylesheet" type="text/css" media="all" /> -->
</head>


<body>
	<div class="navbar">
		<a href="#" class="logo">Generar oficio (Juicio contencioso administrativo)</a>
		<div class="navbar-right">
		  <a href="javascript:cerrarAltaOficio()"><img src="images/cerrar.png" ></a>
		</div>
	</div>

    
<div class="clearfix">

	<div class="box_1" >
        
        <form name="oficioForm" id="oficioForm" method="post" action="#">
			        
            <table >
        
                    <tr>
                        <td class="etiquetaPo" > <p>Num Acción:</p></td>
                        <td>
                          	<input type="text" name="accionvolante" id="accionvolante" value="<?php echo $accion; ?>" class="redonda5"  readonly> 
                        </td>
					</tr>
					
                    <tr>
                        <td class="etiquetaPo"> <p>Juicio Nulidad:</p></td>
                        <td>
                          	<input type="text" name="oficioRef" id="oficioRef" class="redonda5" value="<?php echo $jn; ?>" readonly>
                        </td>
						<td>
							<input type="text" name='idJuicio' id='idJuicio'  value='<?php echo $idJuicio; ?>' hidden >
						</td>
					</tr>
					

			</table> 
			<p id='error'><p>

            <div class="volDivCont redonda5">
					<tr>
                    <td class="etiquetaPo"> <p>Tipo de oficio:</p></td>
                    <td>
                      <select name="tipo" id="tipo" class="redonda5">
                      		<option value="requerido">Seleccione el tipo de oficio...</option>
                      		<option value="contestacion_jn">Contestación de Demanda en el Juicio Contencioso</option>
							<option value="contest_amp_jn">Contestación a la Ampliación de Demanda en el Juicio Contencioso</option>
							<option value="alegatos_jn">Alegatos en el Juicio Contencioso</option>
							<option value="suspencion_jn">Informe de Suspensión o de Medidas Cautelares en el Juicio Contencioso</option>
							<option value="rec_reclama_jn">Recurso Reclamación en el Juicio Contencioso</option>
							<option value="otros_jn">Otros Oficios en el Juicio Contencioso</option>
							<option value="rev_fiscal">Revisión Fiscal</option>
							<option value="otros_rev_fic">Otros Oficios Durante la Tramitación de la Revisión Fiscal</option>
							<option value="alegatos_ad">Alegatos en Amparo Directo</option>
							<option value="otros_ad">Otros Oficios Durante la Tramitación del Amparo Directo</option>
							<option value="inf_just_ad">Informe Justificado en Amparo Indirecto</option>
							<option value="otros_of_ad">Otros Oficios en el Amparo Indirecto</option>
							<option value="inf_previo_ad">Informe Previo en Amparo Indirecto</option>
                      		<option value="sat_medios">SAT</option>
                      </select>
                    </td>
                  	</tr>


			</div>


            <div class="volDivCont redonda5">
            	<table  class="tablaPasos tablaVol">
                  	<tr>
                    <td  class="etiquetaPo" ><p>Destinatario:</p></td>
                    <td >
                        <input type="text" name="remitente" id="remitente" size="35" class="redonda5" required>
                    </td>
                  	</tr>
                  	<tr>
                    <td class="etiquetaPo">  <p>Cargo:</p></td>
                    <td>
                      <input type="text" name="cargo" id="cargo" size="35" class="redonda5">
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


            <div class="volDivCont redonda5">
                    <table class="tablaPasos tablaVol">         
                      <tr>
                        <td class="etiquetaPo"> <p>Asunto:</p></td>
                        <td>
                          <textarea cols="40" rows="3" class="redonda5" id='asunto' name='asunto' required></textarea>
                        </td>
                      </tr>
                    </table>
            </div>


            <div class="volDivCont redonda5">
                <table class="tablaPasos tablaVol">         
                    <tr>


                    <td><p>Solicita:</p>
					<?php $genera = $_SESSION['oficios'];  $direcgr = $_SESSION['direccion']; ?>
					
				    <select name='userForm' id='userForm' class="redonda5" >
				
                    	<option value="" selected="selected">Elegir</option>
                    	<?php

						if ( $direcgr != "DG" ) { 
							$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0' AND direccion = '$direcgr' ORDER BY nivel",false);
						} else {
							$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0'  ORDER BY nivel",false);
						}
                 		while($r = mysql_fetch_array($sql))
                    	echo '<option value="'.$r['usuario'].'">'.$r['nombre'].'_'.$r['nivel'].'</option>';
                 
                 		?> 
				    </select>

                    <input name='dirForm' id='dirForm' type="text" value="" />
                    <input name='oficio' id='oficio' type="hidden" value='<?php echo $_SESSION['oficios']; ?>' />

                
				    </br></br>
					
				    <?php if($genera == 1) { ?>
                    <input type="button" class="submit-login" value="Generar Oficio" id="generaOficio" onclick="dameOficio()" />
				    <?php } else { echo "<H1> ¡No cuenta con permisos para generar Oficios! </H1>"; } ?>
                    </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    
    <div class="box" style="background-color:#ccc">
        <table>
                    <tr>
                        <p>Folio</p>
                        <input name='numeroOficio' id='numeroOficio' type="text" value="" disabled>
                    </tr>
                    <tr>
                        <p>Fecha</p>
                        <input name='diaOficio' id='diaOficio' type="text" value="" disabled>
                    </tr>
                    <tr>
                        <p>Hora</p>
                        <input name='horaOficio' id='horaOficio' type="text" value="" disabled>
                    </tr>
        </table>

    </div>
</div>



</body>
</html>