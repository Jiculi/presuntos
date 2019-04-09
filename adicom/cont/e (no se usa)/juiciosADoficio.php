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
	
	<link rel="stylesheet" href="css/juiciosOficio.css">
</head>

<body>
	<div class="navbar">
		<a href="#" class="logo">Generar oficio (Amparo Directo)</a>
		<div class="navbar-right">
		  <a href="javascript:cerrarAltaOficio()"><img src="images/cerrar.png" ></a>
		</div>
	</div>

    
<div class="clearfix">
	<div id ="ventanita" class="alert">
	 		<p id="salida"><p>
	</div>

	<div class="box_1" >
        
        <form name="formota" id="formota" method="post" action="#" class='formita'>
            <table class="oficio-sin-redonda">
                    <tr>
                        <td class="etiquetaOficio" > <p>Num Acción:</p></td>
                        <td>
                          	<input type="text" name="accionvolante" id="accionvolante" value="<?php echo $accion; ?>"  readonly> 
                        </td>
					</tr>
					
                    <tr>
                        <td class="etiquetaOficio"> <p>Juicio Contencioso:</p></td>
                        <td>
                          	<input type="text" name="oficioRef" id="oficioRef"  value="<?php echo $jn; ?>" readonly>
                        </td>
						<td>
							<input type="text" name='idJuicio' id='idJuicio'  value='<?php echo $idJuicio; ?>' hidden >
						</td>
					</tr>
			</table> 

            <div class="marco">
				<table>
					<tr>
                    <td class="etiquetaOficio">Tipo de oficio:</td>
                    <td>
                      <select name="tipo" id="tipo" class="oficio-redonda">
                      		<option value="requerido">Seleccione el tipo de oficio...</option>
							<option value="alegatos_ad">Alegatos en Amparo Directo</option>
							<option value="otros_ad">Otros Oficios Durante la Tramitación del Amparo Directo</option>
                      </select>
                    </td>
                  	</tr>
				</table>
			</div>


            <div class="marco">
            	<table>
                  	<tr>
                    	<td  class="etiquetaOficio">Destinatario:</td>
                   		<td >
                        	<input type="text" name="remitente" id="remitente" size="35" class="oficio-redonda" required>
                    	</td>
                  	</tr>
                  	<tr>
                    	<td class="etiquetaOficio">Cargo:</td>
                    	<td>
                      		<input type="text" name="cargo" id="cargo" size="35" class="oficio-redonda">
                   		</td>
                  	</tr>
                    <tr>
                    	<td class="etiquetaOficio">Dependencia:</td>
                    	<td>
                      		<input type="text" name="dependencia" id="dependencia" size="35" class="oficio-redonda">
                    	</td>
                  	</tr>
                </table> 
            </div>


            <div class="marco">
                <table>         
                    <tr>
                        <td class="etiquetaOficio">Asunto:</td>
                        <td>
                          <textarea cols="62" rows="3" class="oficio-redonda" id='asunto' name='asunto' required></textarea>
                        </td>
                    </tr>
                </table>
            </div>

			<div class="marco">
                <table>         
                      <tr>
                        <td class="etiquetaOficio">Volante:</td>
                        <td>
						  <input type="text" name="volante" id="volante" size="35" class="oficio-redonda" placeholder="Indique el volante asociado">
                        </td>
                      </tr>
                </table>
            </div>


            <div class="marco">
                <table>         
                    <tr>


                    <td class="etiquetaOficio"><p>Solicita:</p></td>
					<?php $genera = $_SESSION['oficios'];  $direcgr = $_SESSION['direccion']; ?>

					<td>
					
				    <select name='userForm' id='userForm' class="oficio-redonda" >
                    	<option value="" selected="selected">Elegir</option>
                    	<?php

						if ( $direcgr != "DG" ) { 
							$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0' AND direccion = '$direcgr' ORDER BY nivel",false);
						} else {
							$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0'  ORDER BY nivel",false);
						}
                 		while($r = mysql_fetch_array($sql))
                    		echo '<option value="' . $r['usuario'] . '">' . $r['nombre'] . '</option>';
                 
                 		?> 
				    </select>
					</td>
					</tr>
				</table>
			</div>

			<div>
					<tr>
					<td>
                    <input name='dirForm' id='dirForm' type="hidden" type="text" value="" />
                    <input name='oficio' id='oficio' type="hidden" value='<?php echo $_SESSION['oficios']; ?>' />
					
				    <?php if($genera == 1) { ?>
                    <input type="button" class="boton" value="Generar Oficio" id="generaOficio" onclick="dameOficio()" />
				    <?php } else { echo "<H1> ¡No cuenta con permisos para generar Oficios! </H1>"; } ?>
                    </td>
                    </tr>
			</div>
        </form>
    </div>
    
    <div class="box_2">
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


<script>
	var nextinput = 0;
 	var accionesNum = 0;

function myFunction() {
	// $('#ventanita').removeClass("alert error");

    //alert("Input field lost focus.");
}
 
 function cerrarAltaOficio() {
	 $("#altaOficio").fadeOut();
	 $('#popup-overlay').fadeOut('slow');
 }
  
 function comprobarFormulario(form) {
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
	 document.getElementById("salida").innerHTML = "Hola ";
	 $("#ventanita").css("background-color", "rgb(233, 238, 241");  // alert
	 // $('#ventanita').addClass("alert");

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

			 	if( $('#volante').val() == ''){
				 	document.getElementById('volante').style.borderColor = 'red';
					 error++;
					 mensaje = " - El volante es obligatorio";
					 document.getElementById("volante").focus();
				 } else {
					 document.getElementById('volante').style.borderColor = 'silver';
				 }
			 }
		 }
	 }
	 document.getElementById("salida").innerHTML = mensaje;
	 $("#ventanita").css("background-color", "#f44336");  // error
	 // $('#ventanita').addClass("alert error");

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
 
 
 function dameOficio() {
	 if(comprobarFormulario('formota'))  {
			 $.ajax
			 ({
				 beforeSend: function(objeto)  {
					 $('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					 // $('#generaOficio').attr("disabled",true);
					 // $('#generaOficio').css( "background", "gray" );
				 },

				 complete: function(objeto, exito)  {
					 //alert("Me acabo de completar")
					 //if(exito=="success"){ alert("Y con éxito"); }
				 },

				 type: "POST",
				 url: "e/juiciosOficioInserta.php",
				 //url: "e/juicios_oficio_genera.php",
				//data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#new_cargo_servidor').val()+"&irregularidad="+$('#new_irregularidad').val()+"&monto="+$('#new_monto').val(),
				 data: $("#formota").serialize(),

				 error: function(objeto, quepaso, otroobj) {
					 alert("Estas viendo esto por que fallé");
					 alert("Pasó lo siguiente: "+quepaso);
				 },

				 success: function(datos) {
					 let folio = datos.split("|");
					 //alert(folio[0]);

					 if (folio[0] == "error" ) {
						$('#salida').text('No existe el volante');
					    // $('#ventanita').addClass("alert info");
						$("#ventanita").css("background-color", "#2196F3");  // info



					 } else {
					 $("#numeroOficio").val(folio[0]);
					 $("#diaOficio").val(folio[1]);
					 $("#horaOficio").val(folio[2]);

					$('.box_2').css('visibility','visible');
					// $('#generaOficio').val('Oficio generado...');
					 $('#salida').text('Oficio: ' + folio[0] +' generado');
					 // $('#ventanita').addClass("alert success");
					 $("#ventanita").css("background-color", "#4CAF50");  // success



					 $("#formota :input").prop('readonly', true);
					 document.getElementById("tipo").disabled = true;
					 document.getElementById("userForm").disabled = true;
					 document.getElementById("generaOficio").disabled = true;
					 document.getElementById('generaOficio').style.visibility = 'hidden';
					 }
					 
				 }
			 });
	 }
 }
 

$(document).ready(function() {
	 $("#userForm").val($("#indexUser").val());
	 $("#dirForm").val($("#indexDir").val());
	 const tipo = document.getElementById('tipo');
	 tipo.focus();
	 $('#tipo').focus();


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

	$("#volante").autocomplete({
		     complete: function(objeto, exito)  {
					alert("Me acabo de completar")
			 },
			 source: function( request, response ) {
					 
					 $.ajax({
						 type: "POST",
						 url: "e/jsonVolante.php",
						 dataType: "json",
						 data: {
							 term: request.term,
						 },
						 success: function( data ) {
							 response(data);
						 }
					 });
				  },
			 minLength: 3,
			select: function( event, ui ) 
					{  
						// alert("seleccionado")
				   },
			success: function(datos) {
                  alert("success")
			},
			response: function(event, ui) {
      			if(ui.content.length == 0) {
						$('#salida').html('No matches found.');
						//$("#ventanita").css("background-color", "rgb(233, 238, 241");

      			}}
	});
	$( "#volante" ).on( "autocompleteresponse", function( event, ui ) {} );

	$("tipo").blur(function(){
		$("#ventanita").css("background-color", "rgb(233, 238, 241");
    	alert("This input field has lost its focus.");
  	});


});
 
 </script>
 