<?php
session_start();
// if($_SESSION['acceso'] != true && $_SESSION['ADICOM-BETA'] != true)	header ("Location: login.php ");

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


function comprobarFormulario(form,estado,volantes,oficios,cral,SolventacionBaja) {
	//alert(' Campos = '+oficios);
	
	var mensaje = " ";
	var elementos = "";
	var error = 0;
	var adver = 0;
	var VcsMenEdos = 0;
	var VcsMenCita = 0;
	var VcsMenEdos2 = 0;
	var VcsMenEdos3 = 0;
	var VcsMenEdos4 = 0;
	//var veces = 0;

	document.getElementById("error").innerHTML = " ";
	if( $('#tipo').val() == 'requerido'){
		document.getElementById('tipo').style.borderColor = 'red';
		error++;
		mensaje = " - El tipo de oficio es obligatorio";
		document.getElementById("tipo").focus();	
	} else {
		document.getElementById('tipo').style.borderColor = 'silver';
		if( $('#asunto').val() == ''){
			document.getElementById('asunto').style.borderColor = 'red';
			error++;
			mensaje = " - El asunto es obligatorio";
			document.getElementById("asunto").focus();	
		} else {
			document.getElementById('asunto').style.borderColor = 'silver';
			if( $('#remitente').val() == ''){
				document.getElementById('remitente').style.borderColor = 'red';
				error++;
				mensaje = " - El remitente es obligatorio";
				document.getElementById("remitente").focus();
			} else {
				document.getElementById('remitente').style.borderColor = 'silver';
				if( $('#correoOficio').val() == ''){
					document.getElementById('correoOficio').style.borderColor = 'red';
					error++;
					mensaje = " - El numero de oficio es obligatorio";
					document.getElementById("correoOficio").focus();
				} else {
					document.getElementById('correoOficio').style.borderColor = 'silver';
					if( $('#correoFecha').val() == ''){
						document.getElementById('correoFecha').style.borderColor = 'red';
						error++;
						mensaje = " - La fecha es obligatoria";
						document.getElementById("correoFecha").focus();
					} else {
						document.getElementById('correoFecha').style.borderColor = 'silver';
						if( $('#correoAcuse').val() == ''){
							document.getElementById('correoAcuse').style.borderColor = 'red';
							error++;
							mensaje = " - La fecha de acuse es obligatoria";
							document.getElementById("correoAcuse").focus();
						} else {
							document.getElementById('correoAcuse').style.borderColor = 'silver';
						}
					}
				}
			}
		}
	}
	
	document.getElementById("error").innerHTML = mensaje;




	if(error != 0)
	{
			// alert(mensaje);
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

function dameVolante() {
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
				url: "e/juiciosVolanteGenera.php",
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
					$('#generaOficio').val('Volante generado...');
					
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
						url: "e/jn_busqueda_nombre.php",
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


//---------------------------------- BUSCAR OFICIOS -----------------------------------	

//--------------------------------------------------------------------------------------
$( document ).ready(function() {
	$("#userForm").val($("#indexUser").val());
	$("#dirForm").val($("#indexDir").val());

	$( "#correoFecha" ).datepicker({
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 minDate: "01/01/2017",
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$( "#correoAcuse" ).datepicker( "option", "minDate", selectedDate );  
		 }
	});
	
	$( "#correoAcuse" ).datepicker({
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 minDate: "01/02/2017",
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$( "#correoAcuse" ).datepicker( "option", "maxDate", selectedDate );  
		 }

	});
});
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------


</script>

<link rel="stylesheet" href="css/juiciosVolante.css" type="text/css" media="screen" title="default" >

</head>


<body>

	<div class="navbar">
		<a href="#" class="logo">Generar volantes (Juicio contencioso administrativo)</a>
		<div class="navbar-right">
		  <a href="javascript:cerrarAltaOficio()"><img src="images/cerrar.png" ></a>
		</div>
	</div>

<!--	<div style="position: absolute; top:6px; right:6px; cursor:pointer"  onClick="cerrarAltaOficio()" > <img src="images/cerrar.png" > </div>
    <div class="barra"> Generar volantes (Juicio contencioso administrativo) </div>  -->

	
<div class="clearfix">

	<div class="box_1">
        
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
                          <input type="text" name="numJuicio" id="numJuicio" class="redonda5" value="<?php echo $jn; ?>" readonly>
                        </td>
						<td>
						<input type="text" name='idJuicio' id='idJuicio'  value='<?php echo $idJuicio; ?>' >
						</td>

                    </tr>

				</table>
				
				<p id='error'><p>

            	<div class="volDivCont redonda5">
                    <table class="tablaPasos tablaVol">         
                      <tr>

                    <td class="etiquetaPo"> <p>Referencia:</p></td>
                    <td>
                      <select name="tipo" id="tipo" class="redonda5">
                      		<option value="requerido">Seleccione el tipo de volante...</option>
                      		<option value="sentencia">Notificación de la Sentencia</option>
							<option value="amparoDirecto">Amparo Directo</option>
							<option value="amparoRevisión">Amparo Directo en Revisión</option>
							<option value="cumplimiento">Notificación en Cumplimiento</option>
                      </select>
                    </td>

                      </tr>
                    </table>
            	</div>

                <div class="volDivCont redonda5">
                    <table class="tablaPasos tablaVol">         
                      <tr>
                        <td class="etiquetaPo"> <p>Asunto:</p></td>
                        <td>
                          <textarea cols="40" rows="3" class="redonda5" id='asunto' name='asunto'></textarea>
                        </td>
                      </tr>
                    </table>
                </div>

            	<div class="volDivCont redonda5">
            	<table  class="tablaPasos tablaVol">
                  	<tr>
                    <td  class="etiquetaPo" ><p>Remitente:</p></td>
                    <td >
                        <input type="text" name="remitente" id="remitente" size="35" class="redonda5" >
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
            	<table  class="tablaPasos tablaVol">
                  	<tr>
                    <td  class="etiquetaPo" ><p>Oficio Recibido:</p></td>
                    <td >
                        <input type="text" name="correoOficio" id="correoOficio" size="35" class="redonda5" >
                    </td>
                  	</tr>
                  	<tr>
                    <td class="etiquetaPo">  <p>Fecha Oficio:</p></td>
                    <td>
                      <input type="text" name="correoFecha" id="correoFecha" size="35" class="redonda5">
                    </td>
                  	</tr>
                    <tr>
                    <td class="etiquetaPo">  <p>Fecha Acuse:</p></td>
                    <td>
                      <input type="text" name="correoAcuse" id="correoAcuse" size="35" class="redonda5">
                    </td>
                  	</tr>
                </table> 
                </div>

                <div class="volDivCont redonda5">
                    <table class="tablaPasos tablaVol">         
                      <tr>

                    <td><p><H2>Solicita:</H2></p>
					<?php $genera = $_SESSION['oficios'];  $direcgr = $_SESSION['direccion']; ?>
					
				    <select name='userForm' id='userForm' class="redonda5" >
				
                    <option value="" selected="selected">Elegir</option>
                    <?php

					if ( $direcgr != "DG" ) { 
						$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0' AND direccion = '$direcgr' ORDER BY nivel",false);
					} else {
						$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0' AND usuario <> 'yflores' AND usuario <> 'mcarmonah' ORDER BY nivel",false);
					}
                 	while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['usuario'].'">'.$r['nombre'].'_'.$r['nivel'].'</option>';
                 
                 	?> 
				    </select>

                    <input name='dirForm' id='dirForm' type="text" value="" />
                    <input name='oficio' id='oficio' type="hidden" value='<?php echo $_SESSION['oficios']; ?>' />
                
				    </br></br>
					
				    <?php if($genera == 1) { ?>
                    <input type="button" class="submit-login" value="Generar Volante" id="generaOficio" onclick="dameVolante()" />
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
                        <input name='numeroOficio' id='numeroOficio' type="text" value="" readonly>
                    </tr>
                    <tr>
                        <p>Fecha</p>
                        <input name='diaOficio' id='diaOficio' type="text" value="" readonly>
                    </tr>
                    <tr>
                        <p>Hora</p>
                        <input name='horaOficio' id='horaOficio' type="text" value="" readonly>
                    </tr>
        </table>

    </div>
</div>

</body>
</html>