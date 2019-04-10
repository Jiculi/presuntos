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
	<link rel="stylesheet" href="css/juiciosVolante.css" >
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
	<div id ="ventanita" class="alert">
	 		<p id="salida"><p>
	</div>

	<div class="box_1">
        
        <form name="oficioForm" id="oficioForm" method="post" action="#">
            <table class="oficio-sin-redonda">
                    <tr>
                        <td>Num Acción:</td>
                        <td>
                          <input type="text" name="accionvolante" id="accionvolante" value="<?php echo $accion; ?>" readonly> 
                        </td>
                    </tr>
                    <tr>
                        <td>Juicio Nulidad:</td>
                        <td>
                          <input type="text" name="numJuicio" id="numJuicio" value="<?php echo $jn; ?>" readonly>
                        </td>
						<td>
						<input type="text" name='idJuicio' id='idJuicio'  value='<?php echo $idJuicio; ?>' hidden>
						</td>
                    </tr>
			</table>
				

            <div class="volDivCont redonda5">
                    <table class="tablaPasos tablaVol">         
                      	<tr>

                    	<td class="etiqueta">Tipo de Volante:</td>
                    	<td>
                      	<select name="tipo" id="tipo" class="redonda5">
                      		<option value="requerido">Seleccione el tipo de volante...</option>
                      		<option value="juicio">Juicio de Nulidad</option>
                      		<option value="sentencia">Notificación de la Sentencia</option>
							<option value="amparoDirecto">Amparo Directo</option>
							<option value="amparoRevisión">Amparo Directo en Revisión</option>
							<option value="cumplimiento">Notificación en Cumplimiento</option>
							<option value="conocimiento">Conocimiento</option>
                      	</select>
                    	</td>
                     	 </tr>
                    </table>
            </div>

            <div class="volDivCont redonda5">
                    <table class="tablaPasos tablaVol">         
                      <tr>
                        <td class="etiqueta">Asunto:</td>
                        <td>
                          <textarea cols="62" rows="3" class="redonda5" id='asunto' name='asunto'></textarea>
                        </td>
                      </tr>
                    </table>
            </div>

            <div class="volDivCont redonda5">
            	<table  class="tablaPasos tablaVol">
                  	<tr>
                    <td  class="etiqueta" >Remitente:</td>
                    <td >
                        <input type="text" name="remitente" id="remitente" size="35" class="redonda5" >
                    </td>
                  	</tr>
                  	<tr>
                    <td class="etiqueta">Cargo:</td>
                    <td>
                      <input type="text" name="cargo" id="cargo" size="35" class="redonda5">
                    </td>
                  	</tr>
                    <tr>
                    <td class="etiqueta">Dependencia:</td>
                    <td>
                      <input type="text" name="dependencia" id="dependencia" size="35" class="redonda5">
                    </td>
                  	</tr>
                </table> 
            </div>

            <div class="volDivCont redonda5">
            	<table  class="tablaPasos tablaVol">
                  	<tr>
                    <td  class="etiqueta">Oficio Recibido:</td>
                    <td >
                        <input type="text" name="correoOficio" id="correoOficio" size="35" class="redonda5" >
                    </td>
                  	</tr>
                  	<tr>
                    <td class="etiqueta">Fecha Oficio:</td>
                    <td>
                      <input type="text" name="correoFecha" id="correoFecha" size="35" class="redonda5">
                    </td>
                  	</tr>
                    <tr>
                    <td class="etiqueta">Fecha Acuse:</td>
                    <td>
                      <input type="text" name="correoAcuse" id="correoAcuse" size="35" class="redonda5">
                    </td>
                  	</tr>
                </table> 
            </div>

            <div class="volDivCont redonda5">
                <table class="tablaPasos tablaVol">

				<tr>

				<td class="etiqueta">Turnado</td>
				<?php $genera = $_SESSION['oficios'];  $direcgr = $_SESSION['direccion']; ?>

				<td>
					<select name="responsable" id="responsable" class="redonda5">
                    <option value="A" selected="selected">Nelly Zulema Sánchez Cruz</option>

			 		<?php
                 		$sql = $conexion->select("SELECT * FROM usuarios WHERE nivel like '%A%' AND puesto = 'Director de Área' ".$cons." AND status != '0' ORDER BY nivel",false);
                 			while($r = mysql_fetch_array($sql))
                    		echo '<option value="'.$r['nivel'].'">'.$r['nombre'].'</option>';
                 	?> 
					</select>
            	</td>



                    <input name='dirForm' id='dirForm' type="hidden" value="" />
					<input name='userForm' id='userForm' type="hidden" value="" />

					<input name='oficio' id='oficio' type="hidden" value='<?php echo $_SESSION['oficios']; ?>' />  <!-- no se sa -->
					</tr>
					</td>
				</table>
			</div>

			<div>
				
				    <?php if($genera == 1) { ?>
                    <input type="button" class="submit-login" value="Generar Volante" id="generaOficio" onclick="dameVolante()" />
				    <?php } else { echo "<H1> ¡No cuenta con permisos para generar Oficios! </H1>"; } ?>
            </div>
           
        </form>
	</div>
    
    <div class="box_2">
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


<script> 

var nextinput = 0;
var accionesNum = 0;

function cerrarAltaOficio() {
	$("#altaOficio").fadeOut();
	$('#popup-overlay').fadeOut('slow');
}


function comprobarFormulario(form,estado,volantes,oficios,cral,SolventacionBaja) {
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

	//document.getElementById("error").innerHTML = " ";
	document.getElementById("salida").innerHTML = "Hola ";
	 $("#ventanita").css("background-color", "rgb(233, 238, 241");  // alert

	if( $('#tipo').val() == 'requerido'){
		document.getElementById('tipo').style.borderColor = 'red';
		error++;
		mensaje = " - El tipo de volante es obligatorio";
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

	document.getElementById("salida").innerHTML = mensaje;
	 $("#ventanita").css("background-color", "#f44336");  // error

	 //$('#ventanita').addClass("alert error");


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
//--------------------------------------


//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function dameVolante() {
	if(comprobarFormulario('oficioForm')) {
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
					$('.box_2').css('visibility','visible');

					//$('#generaOficio').val('Volante generado...');

					$('#salida').text('Volante: ' + folio[0] +' generado');
					$("#ventanita").css("background-color", "#4CAF50");  // success



					 $("#oficioForm :input").prop('readonly', true);
					 document.getElementById("generaOficio").disabled = true;
					 document.getElementById('generaOficio').style.visibility = 'hidden';



				}
			});
	}
}



//--------------------------------------------------------------------------------------
$( document ).ready(function() {
	$("#userForm").val($("#indexUser").val());
	$("#dirForm").val($("#indexDir").val());  // direccion responsable, debe asignarse (pendiente)

	$( "#correoFecha" ).datepicker({
		 dateFormat: "dd/mm/yy",
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
		dateFormat: "dd/mm/yy",
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 minDate: "01/02/2017",
		 beforeShowDay: noLaborales,
		 onClose: function( selectedDate ) 
		 { 
			$( "#correoAcuse" ).datepicker( "option", "maxDate", selectedDate );  
		 }

	});

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
		   	select: function( event, ui ) {  
				$("#cargo").val(ui.item.cargo);
				$("#dependencia").val(ui.item.dependencia);
				$("#asunto").focus();
		  		}
	});



});


</script>