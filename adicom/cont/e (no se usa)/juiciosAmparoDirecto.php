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
$procedimiento = valorSeguro($_REQUEST['procedimiento']);
$actor = valorSeguro($_REQUEST['actor']);

?>


<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/juiciosAmparoDirecto.css" >
</head>


<body>
<div id="ventana">
    <div id ="pageheader" class="navbar">
		<a href="#" class="logo">Alta de Amparo Directo</a>
		<div class="navbar-right">
		  <a href="javascript:cerrarAltaOficio()"><img src="images/cerrar.png" ></a>
		</div>
    </div>


	

	<div id ="ventanita" class="alert">
	 		<p id="salida"><p>
	</div>


    <div id="caja1" class="info">
        <label for="accionvolante">Num Acción:</label>
        <input type="text" name="accionvolante" id="accionvolante" value="<?php echo $accion; ?>" readonly>
        <label for="numJuicio">Juicio Nulidad:</label>
        <input type="text" name="numJuicio" id="numJuicio" value="<?php echo $jn; ?>" readonly>
        <label for="procedimiento">Procedimiento:</label>
        <input type="text" name="procedimiento" id="procedimiento" value="<?php echo $procedimiento; ?>" readonly>
        <label for="actor">Actor:</label>
        <input type="text" name="actor" id="actor" value="<?php echo $actor; ?>" readonly>
    </div>


	<div id="caja2">
    
        
        <form name="oficioForm" id="oficioForm"  class="formita" method="post" action="#">

            <label for="recurso">Número de Amparo:</label>
            <input type="text" name="recurso" id="recurso" >

            <label for="fInterposicion">Fecha de Interposición:</label>
            <input type="date" name="fInterposicion" id="fInterposicion">

            <label for="instancia">Tribunal:</label>
            <input type="text" name="instancia" id="instancia">

            <label for="observaciones">Observaciones:</label>
			<textarea name="observaciones" id="observaciones" cols="62" rows="3"></textarea>
			
<!--           <button id="botonRecurso" name="botonRecurso" > Alta de Recurso</button> -->
 			<input type="button" name="botonRecurso" id="botonRecurso" value="Dar de alta Amparo Directo"> 



			<?php $genera = $_SESSION['oficios'];  $direcgr = $_SESSION['direccion']; ?>

            <input type="text" name='idJuicio' id='idJuicio'  value='<?php echo $idJuicio; ?>' hidden>
            <input name='dirForm' id='dirForm' type="hidden" value="" />
			<input name='userForm' id='userForm' type="hidden" value="" />

           
        </form>
	</div>
    
</div>
</body>
</html>


<script> 


function cerrarAltaOficio() {
	$("#altaOficio").fadeOut();
	$('#popup-overlay').fadeOut('slow');
}


function comprobarFormulario() {
	var mensaje = " ";
	var error = 0;

	document.getElementById("salida").innerHTML = "Hola ";
	 $("#ventanita").css("background-color", "rgb(233, 238, 241");  // alert

	if( $('#recurso').val() == ''){
		document.getElementById('recurso').style.borderColor = 'red';
		error++;
		mensaje = " El número de Amparo Directo es obligatorio";
		document.getElementById("recurso").focus();	
	} else {
		document.getElementById('recurso').style.borderColor = 'silver';
		if( $('#fInterposicion').val() == ''){
			document.getElementById('fInterposicion').style.borderColor = 'red';
			error++;
			mensaje = " La fecha de interposcisión es obligatoria";
			document.getElementById("fInterposicion").focus();	
		} else {
			document.getElementById('fInterposicion').style.borderColor = 'silver';
			if( $('#instancia').val() == ''){
				document.getElementById('instancia').style.borderColor = 'red';
				error++;
				mensaje = " La instancia es obligatoria";
				document.getElementById("instancia").focus();
			} else {
				document.getElementById('instancia').style.borderColor = 'silver';
				if( $('#observaciones').val() == ''){
					document.getElementById('observaciones').style.borderColor = 'red';
					error++;
					mensaje = "Faltan las observaciones";
					document.getElementById("observaciones").focus();
				} else {
					document.getElementById('observaciones').style.borderColor = 'silver';
			    }
		    }
	    }
    }

	document.getElementById("salida").innerHTML = mensaje;
	 $("#ventanita").css("background-color", "#f44336");  // error

	 //$('#ventanita').addClass("alert error");

	if(error != 0) 	{
			//alert(mensaje);
			return false;
	} else 	{
		return true;
	}
}


//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------





//--------------------------------------------------------------------------------------
$( document ).ready(function() {
	$("#userForm").val($("#indexUser").val());
	$("#dirForm").val($("#indexDir").val());  // direccion responsable, debe asignarse (pendiente)

	$("#instancia").autocomplete({
			source: function( request, response ) {
					$.ajax({
						type: "POST",
						url: "e/jsonTribunal.php",
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
		  		}
	});


$("#botonRecurso").click(function(){

	if(comprobarFormulario()) {
			$.ajax ({
				beforeSend: function(objeto)
				{
					$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					$('#botonRecurso').attr("disabled",true);
					$('#botonRecurso').css( "background", "gray" );
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "e/juiciosADupdate.php",
				//data: "funcion=nuevo&hora="+$('#hora_cambio').val()+"&fecha="+$('#fecha_cambio').val()+"&usuario="+$('#usuarioActual').val()+"&num_accion="+$('#num_accion').val()+"&idPresunto="+$('#creacion').val()+"&servidor="+$('#new_servidor_contratista').val()+"&cargo="+$('#new_cargo_servidor').val()+"&irregularidad="+$('#new_irregularidad').val()+"&monto="+$('#new_monto').val(),
				data: $("#oficioForm").serialize(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
                success: function(datos) {
                    let folio = datos.split("|");

					//$('#botonRecurso').val('Volante generado...');

					$('#salida').text(datos);
					$("#ventanita").css("background-color", "#4CAF50");  // success



					 $("#oficioForm :input").prop('readonly', true);
					 document.getElementById("botonRecurso").disabled = true;
					 document.getElementById('botonRecurso').style.visibility = 'hidden';



				}
			});
	}


});


});


</script>