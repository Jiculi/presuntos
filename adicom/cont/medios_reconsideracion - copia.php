<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- BUSCAMOS DATOS DE LA ACCION -------------------------------------
$query = "SELECT * FROM actores_recurso WHERE recurso_reconsideracion = '".$_REQUEST['recurso_reconsideracion']."' ";
$sql = $conexion->select($query,false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
//------------------------- BUSCAMOS OFICIO REQUERIMIENTO ------------------------------------
$query = "SELECT oc.folio as ofiFolio, o.fecha_oficio as ofiFecha 
		FROM oficios_contenido oc 
		INNER JOIN oficios o ON oc.folio = o.folio 
		WHERE oc.num_accion = '".$r['accion']."' 
		AND oc.presunto LIKE '%".$r['nombre']."%'
		AND o.tipo = 'medios_rr'
		AND o.status <> 0 
		AND oc.juridico = 1 LIMIT 1";

$sql = $conexion->select($query,false);
$ro = mysql_fetch_array($sql);
$totOfirec = mysql_num_rows($sql);
//------------------------- BUSCAMOS OFICIO ADMISION ------------------------------------AND presunto LIKE'%".$r['actor']."%'
$query = "SELECT * FROM oficios  WHERE  num_accion LIKE '%".$r['num_accion']."%' AND tipoOficio = 'medios_rr' LIMIT 1";
$sql = $conexion->select($query,false);
$roi = mysql_fetch_array($sql);
$totOfiInt = mysql_num_rows($sql);
if($totOfiInt) $tipoOfi = ($roi["tipo"] == 34) ? "ADMISIÓN" : "DESECHAMIENTO"; 
$totOfirec = mysql_num_rows($sql);
//------------------------- BUSCAMOS ACUSE OFICIO ADMISION ------------------------------------
$query = "SELECT oficioAcuse FROM medios_historial WHERE num_accion = '".$r['num_accion']."' AND estadoTramite = 33  LIMIT 1";
$sql = $conexion->select($query,false);
$roa = mysql_fetch_array($sql);
$totOfiInt = mysql_num_rows($sql);
//------------------------- BUSCAMOS FECHA ESTUDIO ET ------------------------------------
$query = "SELECT oficioRecepcion FROM medios_historial WHERE num_accion = '".$r['num_accion']."' AND estadoTramite = 38  LIMIT 1";
$sql = $conexion->select($query,false);
$ret = mysql_fetch_array($sql);
$totOfiInt = mysql_num_rows($sql);
//---------------------------------------------------------------------------

?>
<script>
//--------------- MENU CONF ----------------------------
r(function(){
	r('#mMedios>li').hover(
		function(){
		r('.menu_Medios',this).stop(true,true).slideDown();
		},
		function(){
		r('.menu_Medios',this).slideUp();
		}
	);
 
});
$$(function() {

	$$( "#fecha_rec_act" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	//-----	FECHA DE OFICIOS DE REQUISICION DE INFO
	/*
	$$( "#fecha_oficio_req" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 beforeShowDay: noLaborales,
     onClose: function( selectedDate ) {
        $$( "#fecha_acuse_oficio_req" ).datepicker( "option", "minDate", selectedDate );
      }
    });
	*/
	
	$$( "#fecha_acuse_oficio_req" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: '<?php echo fechaNormal($ro['ofiFecha']) ?>',
	 beforeShowDay: noLaborales,
     /*
	  onClose: function( selectedDate ) {
        $$( "#fecha_oficio_req" ).datepicker( "option", "maxDate", selectedDate );
      }
	  */
    });
	//-----	FECHA DE OFICIOS DE ADMISION / DESECHAMIENTO
	/*
	$$( "#fecha_oficio_AD" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 beforeShowDay: noLaborales,
     onClose: function( selectedDate ) {
        $$( "#fecha_acuse_oficio_AD" ).datepicker( "option", "minDate", selectedDate );
      }
    });
	*/
	
	$$( "#fecha_acuse_oficio_AD" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: '<?php echo fechaNormal($roi['ofiFecha']) ?>',
	 beforeShowDay: noLaborales,
	 /*
      onClose: function( selectedDate ) {
        $$( "#fecha_oficio_AD" ).datepicker( "option", "maxDate", selectedDate );
      }
	  */
    });
	//-----	FECHA DE OFICIOS DE NOTIFICACION 
	$$( "#fecha_oficio_not" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fecha_acuse_oficio_not" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fecha_oficio_not_2" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fecha_acuse_oficio_not_2" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fecha_rec_req" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate:'<?php echo fechaNormal($roa['ofiFecha']) ?>',
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fecha_cierre_ins" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: '<?php echo fechaNormal($ret['oficioRecepcion']) ?>',
	 beforeShowDay: noLaborales,
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fecha_emi_res" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fecha_not_res" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
});
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
$$(document).ready(function(){

//---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
//---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
//---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
//---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
//---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------

 $$("#guardacheck").click(function()
 {
//if(comprobarForm("formCheckList"))
//		{
		if ($$('#auto:checked').val() && $$('#nomrec:checked').val() && $$('#dom:checked').val() && $$('#acto:checked').val()  && $$('#fecha:checked').val() && $$('#agrav:checked').val() && $$('#resol:checked').val() && $$('#cons:checked').val())
	
			{

			var activos=1;
						var datosUrl = "&recurso="+$$("#recurso").val()+"&ActivoSi="+$$("#ActivoSi").val();	
		
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(34); ?> \n\n ¿Desea continuar?");
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
					//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
					//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					//alert(datos);
					cerrarCuadro();
					}
				
				});
			} //Fin de if confirma
			}
		
		else
			
			{
			
			var activos=0;
	var datosUrl = "&auto="+$$("#auto:checked").val()+"&nomrec="+$$("#nomrec:checked").val()+"&dom="+$$("#dom:checked").val()+"&acto="+$$("#acto:checked").val()+"&fecha="+$$("#fecha:checked").val()+"&agrav="+$$("#agrav:checked").val()+"&resol="+$$("#resol:checked").val()+"&cons="+$$("#cons:checked").val()+"&recurso="+$$("#recurso").val()+"&ActivoNo="+$$("#ActivoNo").val();	

		
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(35); ?> \n\n Esto le ayudará a generar el oficio de prevensión por la falta de informamción, recordando que solo se puede crear una vez. \n\n ¿Desea continuar?");
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
					//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
					//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					//alert(datos);
					cerrarCuadro();
					}
				
				});
			} //Fin de if confirma
			
			}//Fin de if activos = 0

	//	}	
 });


 //---- EDO 34 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
 //---- Esta parte del código envía al archivo medios_reconsideracion de procesosAjax lo que contiene el formulario formRecursoRec por medio de la variable datosUrl

  $$("#guardaSol").click(function(){
		
		var datosUrl = $$("#formRecursoRec").serialize()+"&numAccion="+$$("#accion_req").val()+"&procedimiento="+$$("#procedimiento_req").val()+"&nombre_actor="+$$("#actor_req").val()+"&actor="+$$("#id_actor_req").val()+"&id_rec_req="+$$("#id_rec_req").val()+"&ofiFolio="+$$("#oficio_req").val()+"&ofiFecha="+$$("#fecha_oficio_req").val()+"&fecha_acuseo="+$$("#fecha_acuse_oficio_req").val()+"&rr_reqRecRec="+$$("#tipoForm").val()+"&usuario="+$$("#us_req").val();
				
	  	if(comprobarForm("formRecursoRec"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(107); ?> \n\n ¿Desea continuar?");
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
  
  
  //---- EDO 34 o 36 ACUERDO DE ADMISION --------------------------
  $$("#btnAdmDes").click(function(){

	  	var datosUrl = $$("#formAdmDes").serialize();
		
		if(comprobarForm("formAdmDes"))
		{
		if($$("#tipoAdm").val() == "admision") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(44); ?> \n\n ¿Desea continuar?");
		else var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(36); ?> \n\n ¿Desea continuar?");
			
  				if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); 
						//alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
  
  //---- EDO 37 o 39 ACUERDO DE ADMISION Y DESAHOGO DE PRUEBAS DEL RR--------------------------
  $$("#btnEdo37o39").click(function(){

	  	var datosUrl = $$("#formNotAdmDes").serialize();
		
		if(comprobarForm("formNotAdmDes"))
		{
			if($$("#oficio_tipo_AD").val() == "DESECHAMIENTO") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(39); ?> \n\n ¿Desea continuar?");
			else var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(37); ?> \n\n ¿Desea continuar?");
			
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  //---- EDO 38 ESTUDIO DEL ET Y RR --------------------------
  $$("#btnEstudioET").click(function(){

	  	var datosUrl = $$("#formEstudioET").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formEstudioET"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(38); ?>  \n\n ¿Desea continuar?");
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  $$("#btnCierreIns").click(function(){

	  	var datosUrl = $$("#formCierreIns").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formCierreIns"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(40); ?>  \n\n ¿Desea continuar?");
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  $$("#btnEmiRes").click(function(){

	  	var datosUrl = $$("#formEmiRes").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formEmiRes"))
		{

			if($$("#tipo_emi_res").val() == "confirmarResolucion") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(41); ?> \n\n ¿Desea continuar?");
			if($$("#tipo_emi_res").val() == "modificarResolucion") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(42); ?> \n\n ¿Desea continuar?");
			if($$("#tipo_emi_res").val() == "revocarResolucion") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(47); ?> \n\n ¿Desea continuar?");

			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
    $$("#btnNotRes").click(function(){

	  	var datosUrl = $$("#formNotRes").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formNotRes"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(43); ?>  \n\n ¿Desea continuar?");
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });

}); 	
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
function ocultaAll() 
{
	$$('.divsEdos').hide();
	$$('.todosPasos').removeClass("pasosActivo");
} 

function muestraPestana(divId)
{
	//todos los demas
	ocultaAll();
	//nuevo link
	$$('#paso'+divId).removeClass('pInactivo');
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#paso'+divId).addClass('pfAccesible '); 
	
	$$('#paso_'+divId).fadeIn();
}

function validaAcuerdo(valor){
	if(valor == "admision"){
		$$("#labelAdmDes").html("Fecha de Acuerdo de Admisión del<br> RR");	
		$$("#contAdmDes").html("<input type='text' name='fechaAdmDes' id='fechaAdmDes'  class='redonda5' /> ");	
		$$("#labelAdmDes2").html("");
		$$("#contAdmDes2").html("");
					
		
		$$( "#fechaAdmDes" ).datepicker({
		 // dateFormat: formatoFecha,
		  changeMonth: false,
		  numberOfMonths: 1,
		  showAnim:'slideDown',
		 //minDate: fechaMinimaRec,
		 //beforeShowDay: noLaborales
		  //onClose: function( selectedDate ) {
			//$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
		  //}
		});
	}else{
		
		$$("#labelAdmDes").html("Motivo");	
		$$("#contAdmDes").html("<textarea cols='50' rows='1' name='motivoAdmDes' id='motivoAdmDes' class='redonda5'> </textarea>");	
		$$("#labelAdmDes2").html("Fecha de Acuerdo de Desechamiento del<br> RR");
		$$("#contAdmDes2").html("<input type='text' name='fechaAdmDes2' id='fechaAdmDes2' class='redonda5' /> ");	
			
		
		$$( "#fechaAdmDes2" ).datepicker({
		 // dateFormat: formatoFecha,
		  changeMonth: false,
		  numberOfMonths: 1,
		  showAnim:'slideDown',
		 //minDate: fechaMinimaRec,
		 //beforeShowDay: noLaborales
		  //onClose: function( selectedDate ) {
			//$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
		  //}<strong></strong>
		
		});
		
	}
}
</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<!-- --------------- variables necesarias --------------- -->
<!-- --------------- variables necesarias --------------- -->
<input type="hidden" name="medios_numAccion" id="medios_numAccion" value="<?php echo $_REQUEST['numAccion'] ?>"/>
<input type="hidden" name="medios_usuario" id="medios_usuario" value="<?php echo $_REQUEST['usuario'] ?>"/>
<input type="hidden" name="medios_direccion" id="medios_direccion" value="<?php echo $_REQUEST['direccion'] ?>"/>
<input type="hidden" name="medios_idPresunto" id="medios_idPresunto" value="<?php echo $_REQUEST['idPresuntop'] ?>"/>
<input type="hidden" name="medios_presunto" id="medios_presunto" value="<?php echo $_REQUEST['presunto'] ?>"/>
<!-- --------------- variables necesarias --------------- -->
<!-- --------------- variables necesarias --------------- -->
<!-- onclick='muestraDivEdo(".$r['id_estado'].")'>".$r['detalle_estado']." -->
<?php

//------------------- MENSAJE DE ESPERA ACCION ------------------------------
//--En esta parte del código, se habilita la ventana para selecionar los checkbox para la interposición del recurso
if($r['detalle_edo_tramite'] == 33 )
{
	$onclickP0 = "onclick=\"muestraPestana(0)\"";
	$txtPaso0 = "pasosActivo";
	echo "<script>	$$(function() {	$$('#paso_0').fadeIn();	});	</script>";
}
//--- Se crea el oficio de prevension al actor 
if($r['detalle_edo_tramite'] == 35)
{
	$onclickP2 = "onclick=\"muestraPestana(2)\"";
	$txtPaso2 = "pasosActivo";
	$acceso2 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_2').fadeIn();	});	</script>";
}
//--- En esta parte del código, se evalúa que si la acción esta en estado 107, se muestre el mensaje que se encuentra en proceso de prevención
if($r['detalle_edo_tramite'] == 107)
{
	$txtPaso9 = "pasosActivo";
	echo "<script>	$$(function() {	$$('#paso_9').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para admitir o desechar el recurso
if($r['detalle_edo_tramite'] == 34 )
{
	$onclickP8 = "onclick=\"muestraPestana(8)\"";	
	$txtPaso8 = "pasosActivo";
	$acceso8 = "pfAccesible";	
	echo "<script>	$$(function() {	$$('#paso_8').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para notificar el acuerdo 
if ($r['detalle_edo_tramite'] == 39)
{
    $onclickP3 = "onclick=\"muestraPestana(3)\"";	
	$txtPaso3 = "pasosActivo";
	$acceso3 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_3').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para el cierre de instrucción
if ($r['detalle_edo_tramite'] == 36)
{
    $onclickP5 = "onclick=\"muestraPestana(5)\"";	
	$txtPaso5 = "pasosActivo";
	$acceso5 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_5').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para selecionar cualquier opcion confirmar, modificar o revocar
if($r['detalle_edo_tramite'] == 40)
{
	$onclickP6 = "onclick=\"muestraPestana(6)\"";	
	$txtPaso6 = "pasosActivo";
	$acceso6 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_6').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para notificar la resolución
if($r['detalle_edo_tramite'] == 41 || $r['estado'] == 42 || $r['estado'] == 43)
{
	$onclickP7 = "onclick=\"muestraPestana(7)\"";	
	$txtPaso7 = "pasosActivo";
	$acceso7 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_7').fadeIn();	});	</script>";
}

//---------------------------------------------------------------------------
//------------------------ ACTIVAR PESTAÑAS ---------------------------------
//---------------------------------------------------------------------------
if(ACTIVAPESTANAS == true)
{
	$onclickP0 = " onclick=\"muestraDivEdo('paso_0')\" ";
	$onclickP1 = " onclick=\"muestraDivEdo('paso_1')\" ";
	$onclickP2 = " onclick=\"muestraDivEdo('paso_2')\" ";
	$onclickP3 = " onclick=\"muestraDivEdo('paso_3')\" ";
	$onclickP4 = " onclick=\"muestraDivEdo('paso_4')\" ";
	$onclickP5 = " onclick=\"muestraDivEdo('paso_5')\" ";
	$onclickP6 = " onclick=\"muestraDivEdo('paso_6')\" ";
	$onclickP7 = " onclick=\"muestraDivEdo('paso_7')\" ";
	$onclickP8 = " onclick=\"muestraDivEdo('paso_8')\" ";
	$onclickP9 = " onclick=\"muestraDivEdo('paso_9')\" ";
	$onclickP10 = " onclick=\"muestraDivEdo('paso_10')\" ";
	$onclickP11 = " onclick=\"muestraDivEdo('paso_11')\" ";
	
	$txtPaso1 = " pasosActivo ";
	$txtPaso2 = " pasosActivo ";
	$txtPaso3 = " pasosActivo ";
	$txtPaso4 = " pasosActivo ";
	$txtPaso5 = " pasosActivo ";
	$txtPaso6 = " pasosActivo ";
	$txtPaso7 = " pasosActivo ";
	$txtPaso8 = " pasosActivo ";
	$txtPaso9 = " pasosActivo ";
	$txtPaso10 = " pasosActivo ";
	$txtPaso11 = " pasosActivo ";
	
	$acceso1 = " pfAccesible ";
	$acceso2 = " pfAccesible ";
	$acceso3 = " pfAccesible ";
	$acceso4 = " pfAccesible ";
	$acceso5 = " pfAccesible ";
	$acceso6 = " pfAccesible ";
	$acceso7 = " pfAccesible ";
	$acceso8 = " pfAccesible ";
	$acceso9 = " pfAccesible ";
	$acceso10 = " pfAccesible ";
	$acceso11 = " pfAccesible ";
}
?>
<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso0' <?php echo $onclickP0 ?> class="todosPasos <?php echo $txtPaso0 ?> <?php echo $acceso0 ?> pasos"> INTERPOSICIÓN </div>
       <div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"> PREVENCIÓN</div>
       <div id='paso8' <?php echo $onclickP8 ?> class="todosPasos <?php echo $txtPaso8 ?> <?php echo $acceso8 ?> pasos"> ADMISIÓN / DESECHAMIENTO </div>
       <div id='paso3' <?php echo $onclickP3 ?> class="todosPasos <?php echo $txtPaso3 ?> <?php echo $acceso3 ?> pasos"> NOTIFICACIÓN ACUERDO</div>
       <div id='paso5' <?php echo $onclickP5 ?> class="todosPasos <?php echo $txtPaso5 ?> <?php echo $acceso5 ?> pasos"> CIERRE DE INSTRUCCIÓN </div>
       <div id='paso6' <?php echo $onclickP6 ?> class="todosPasos <?php echo $txtPaso6 ?> <?php echo $acceso6 ?> pasos"> EMITIR RESOLUCIÓN </div>
       <div id='paso7' <?php echo $onclickP7 ?> class="todosPasos <?php echo $txtPaso7 ?> <?php echo $acceso7 ?> pasos"> NOTIFICAR RESOLUCIÓN </div>
       
     
	</div>
    
    <!-- <div id='resPasos' class='resPasos redonda10'> -->

    <div class="resPasosMedios redonda10">
    
    	
        <!-- -------------- EDO TRAMITE 33-------------------- -->
        <!-- -------------- EDO TRAMITE 33-------------------- -->
        <div id='paso_1' class="divsEdos">
        	<!--
            <h3>En elaboración de Acuerdo de Admisión/Desechamiento del Recurso de Reconsideración</h3>
            <center>
            <br />
                <form name="formRecursoRec">
                <table width="60%">
                    <tr>
                        <td class="etiquetaPo">Fecha de recepción del <br />recurso interpuesto por el actor:</td>
                        <td><input type="text" name="fecha_rec_act" id="fecha_rec_act" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br /><input type="button" name="Guardar" value="Guardar" class="submit_line" /></td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
            -->
        </div>
        <!-- -------------- EDO TRAMITE 33 INFO AL RECURRENTE -------------------- -->
        <!-- -------------- EDO TRAMITE 33 INFO AL RECURRENTE -------------------- -->
        
        <div id='paso_0' class="divsEdos"> <br>
         <h3>Selecciona las opciones con las que cuenta el Oficio de Reconsideración</h3> <br> <br> <br>
          <center>
                   
                   <form name="formCheckList" id="formCheckList">

                   <table class="tablaRecurso" width="90%" align="center">
                   
    <tr>
    
    <table class="tablaRecurso" width="90%" align="center">
    <input type="hidden" name="recurso" id="recurso" value="<?php echo  urlencode( $r['recurso_reconsideracion']); ?>"/>
    <input type="hidden" name="ActivoSi" id="ActivoSi" value="1"/>
    <input type="hidden" name="ActivoNo" id="ActivoNo" value="0"/>
   <td valign="top" width="30%" class=""><input type="checkbox" name="auto" id="auto" value="on">
    <label for="auto"> Autoridad Adminsitrativa que emitió acto impugnado </label> <br> <br></td>
    
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="nomrec" id="nomrec" value="on">
      <label for="nomrec">Nombre del Recurrente</label> <br> <br></td>
      
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="dom" id="dom" value="on">
      <label for="dom">Domicilio</label> <br> <br></td>
      
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="acto" id="acto" value="on">
      <label for="acto">Acto que recurre</label> <br> <br></td>
      
      
  <tr>
    <td valign="top"  width="30%"  class=""><input type="checkbox" name="fecha" id="fecha" value="on">
      <label for="fecha">Fecha de Notificación</label></td>
      
    <td valign="top"  width="30%"  class=""><input type="checkbox" name="agrav" id="agrav" value="on">
      <label for="agrav">Agravios</label></td>
      
    <td valign="top"  width="30%"  class=""><input type="checkbox" name="resol" id="resol" value="on">
      <label for="resol">Copia de Resolución </label></td>
      
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="cons" id="cons" value="on">
      <label for="cons">Copia de constancia de notificación </label></td>
  </tr>
 
                   </table>                   
                   </table>
                 </center>
                  </td>
                  <!-- ---------------------------- ----------------------------->
                  <!-- ---------------------------- ----------------------------->
                </tr>
                
              
                <tr>

                    </td>
                </tr>
              </table>
                      <center> <br>
<br />	

<input type='button' name='guardacheck' id='guardacheck' value='Prevención'  class='submit_line'  />
</center>

              </center>
              
              
	   
        
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </form> 
          </div>
        

           
        <!-- -------------- EDO TRAMITE 34 INFO AL RECURRENTE -------------------- -->
        <!-- -------------- EDO TRAMITE 34 INFO AL RECURRENTE -------------------- -->

        <div id='paso_2' class="divsEdos"><br />
        <h3>Solicitar Información al Recurrente</h3><br> 
        <center>
        <form name="formRecursoRec" id="formRecursoRec">
                <table width="90%" class="feDif">
                    <tr>
                        <td colspan="2">
                         <?php if($totOfirec == 0) {  ?>
                            <div class="mensajeRojo">No existe Oficio... <a href="?cont=medios_rr_oficios&nombre=<?php echo trim($r['actor']) ?>">Click aqui para crearlo</a></div><br> <br>
                         <?php } ?>
                        </td>

                    </tr>
                    <tr>
                    	
                        <input type="text" name="accion_req" id="accion_req" value="<?php echo $r['num_accion'] ?>"/>
						<input type="text" name="procedimiento_req" id="procedimiento_req" value="<?php echo $r ['recurso_reconsideracion']; ?>"/>
                       
                        <input type="text" name="id_actor_req" id="id_actor_req" value="<?php echo $r ['actor']; ?>"/>
                        
                        
                        <input type="text" name="id_rec_req" id="id_rec_req" value="<?php echo $r ['entidad']; ?>"/>
                        
                        
						<input type="text" name="us_req" id="us_req" value="<?php echo $_REQUEST['usuario'] ?>"/>
						<!-- hidden-->
                        <td class="etiquetaPo">Oficio de requerimiento<br /> de información:</td>
                        <td><input type="text" name="oficio_req" id="oficio_req" class="redonda5" value="<?php echo $roi['folio'] ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="fecha_oficio_req" id="fecha_oficio_req" class="redonda5" value="<?php echo fechaNormal($roi['fecha_oficio']) ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Notificación del Oficio:</td>
                        <td><input type="text" name="fecha_acuse_oficio_req" id="fecha_acuse_oficio_req" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_reqRecRec" />
                            <input type="button" name="Guardar" value="Guardar" class="submit_line" id="guardaSol"/>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            
        
        <!-- -------------- EDO TRAMITE 34 o 36 ADMISIÓN / DESECHAMIENTO -------------------- -->
        <!-- -------------- EDO TRAMITE 34 o 36 ADMISIÓN / DESECHAMIENTO-------------------- -->
    
       
        <div id='paso_8' class="divsEdos"><br />
            <h3>Admisión o Desechamiento del Recurso de Reconsideración</h3><br> <br> <br>         
            <center>
            <br />
                <form name="formAdmDes" id="formAdmDes">
                <table width="60%" class="feDif">
                    <tr>
                        <td class="etiquetaPo">Tipo de Acuerdo: </td>
                        <td>
                        <input type="hidden"  name ="numeroderecurso" id="numeroderecurso" value="<?php echo $r ['recurso_reconsideracion']; ?>" />
                        	<select name="tipoAdm" id="tipoAdm" class="redonda5" onchange="validaAcuerdo(this.value)">
                                <option value="">Seleccione acuerdo...</option>
                            	<option value="admision">Admisión del Recurso de Reconsideración</option>
                            	<option value="desechamiento">Desechamiento del Recurso de Reconsideración</option>
                             </select>                                               
                        </td>
                    </tr>
                      <tr>
                    	<td id="labelAdmDes" class="etiquetaPo"> </td>
                    	<td id="contAdmDes"> </td>
                      </tr>
                      <tr>
                        <td id="labelAdmDes2" class="etiquetaPo"> </td>                        
                        <td id="contAdmDes2"> </td>
                      </tr>  
                      <tr>
                        <td colspan="2" align="center"><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_AdmDes" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnAdmDes"/>
                        </td>
                      </tr>                    
                </table>
                </form>
            </center>
            <br /><br />
        </div>
        
        
        
         <!-- -------------- EDO TRAMITE NOTIFICA AL ACTOR Y AL SAT -------------------- -->
        <!-- -------------- EDO TRAMITE NOTIFICA AL ACTOR Y AL SAT -------------------- -->

        <div id='paso_3' class="divsEdos"><br />
        
     <h3>Notificación del Acuerdo </h3><br> 
      
        <form name="formNotifica" id="formNotifica">
                <table width="90%" class="feDif">
                    <tr>
                        <td colspan="2">
                         <?php if($totOfirec == 0) {  ?>
                            <div class="mensajeRojo">No existe Oficio... <a href="?cont=medios_rr_oficios&nombre=<?php echo trim($r['actor']) ?>">Click aqui para crearlo</a></div><br> <br>
                         <?php } ?>
                        </td>

                    </tr>
                    <tr>
                    	
                        <input type="hidden" name="accion_req" id="accion_req" value="<?php echo $r['num_accion'] ?>"/>
				<input type="hidden" name="procedimiento_req" id="procedimiento_req" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                       
                        <input type="hidden" name="id_actor_req" id="id_actor_req" value="<?php echo $r ['actor']; ?>"/>
                        
                        
                        <input type="hidden" name="id_rec_req" id="id_rec_req" value="<?php echo $r ['entidad']; ?>"/>
                        
                        
						<input type="hidden" name="us_req" id="us_req" value="<?php echo $_REQUEST['usuario'] ?>"/>
						<!-- hidden-->
                        <td class="etiquetaPo">Oficio de notificación <br /> al actor:</td>
                        <td><input type="text" name="oficio_req" id="oficio_req" class="redonda5" value="<?php echo $roi['folio'] ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="fecha_oficio_req" id="fecha_oficio_req" class="redonda5" value="<?php echo fechaNormal($roi['fecha_oficio']) ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Notificación del Oficio:</td>
                        <td><input type="text" name="fecha_acuse_oficio_req" id="fecha_acuse_oficio_req" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_notifica" />
                            <input type="button" name="Guardar" value="Guardar" class="submit_line" id="guardaNot"/>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        
        <!-- -------------- EDO TRAMITE 38 ESTUDIO ET -------------------- -->
        <!-- -------------- EDO TRAMITE 38 ESTUDIO ET -------------------- -->
        <!--
        <div id='paso_4' class="divsEdos">
            <h3>En estudio del ET del Recurso de Reconsideración</h3>
            <center>
            <br />
                <form name="formEstudioET" id="formEstudioET">
                <table width="60%" class="feDif">
                    <tr>
                        <td class="etiquetaPo">Fecha de recepción <br />de la respuesta del requerimiento:</td>
                        <td><input type="text" name="fecha_rec_req" id="fecha_rec_req" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_estudioET" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnEstudioET"/>
                        </td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
        </div>
        -->
        <!-- -------------- EDO TRAMITE 40 CIERRE INSTRUCCION -------------------- -->
        <!-- -------------- EDO TRAMITE 40 CIERRE INSTRUCCION -------------------- -->
        <div id='paso_5' class="divsEdos">
            <h3>
                    <br />Resolución del Recurso de Reconsideración </h3>
            <center>
            <br />
                <form name="formCierreIns" id="formCierreIns">
                <table width="60%" class="feDif">
                    <tr>
                    <br />
                    <br />
                    <br />
                  
                        <td class="etiquetaPo">Fecha del <br />cierre de instrucción:</td>
                        <td><input type="text" name="fecha_cierre_ins" id="fecha_cierre_ins" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_cierreIns" />
                        <br />                                          
                        <br />
                        <br />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnCierreIns"/>
                        <br />
                        <br />
                        </td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
        </div>
        <!-- -------------- EDO TRAMITE 41 EMISION DE LA RESOLUCIÓN -------------------- -->
        <!-- -------------- EDO TRAMITE 42 EMISION DE LA RESOLUCIÓN -------------------- -->
        <div id='paso_6' class="divsEdos">
            <h3><br />Resolución del Recurso de Reconsideración</h3>
            <center>
            <br />
                <form name="formEmiRes" id="formEmiRes">
                <table width="60%" class="feDif">
                    <tr>
                    <br /><br /><br />
                        <td class="etiquetaPo">Tipo de Resolución:</td>
                        <td>
                        	<select name="tipo_emi_res" id="tipo_emi_res" class="redonda5">
                            	<option value="">Seleccione una opcion... </option>
                            	<option value="confirmarResolucion"> Confirmar Resolución Definitiva </option>
                            	<option value="modificarResolucion"> Modificar Resolución Definitiva</option>
                            	<option value="revocarResolucion"> Revocar Resolución Definitiva</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha de la emisión <br />de la Resolución:</td>
                        <td><input type="text" name="fecha_emi_res" id="fecha_emi_res" class="redonda5" /></td> 
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br /><br /><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_EmiRes" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnEmiRes"/>
                        </td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
        </div>
        <!-- -------------- EDO NOTIFICA RESOLUCION-------------------- -->
        <!-- -------------- EDO NOTIFICA RESOLUCION-------------------- -->
        <div id='paso_7' class="divsEdos">
            <h3>Notificación de la Resolución </h3>
            <center>
            <br />
			
			
            
         <!-- -------------- OFICIO PRESUNTO-------------------- -->
         <!-- -------------- OFICIO PRESUNTO-------------------- -->
         <!-- -------------- OFICIO PRESUNTO-------------------- -->
                       
            <div id="notificacionTESOFE" class="notiVarias">
                        <form name="NotiresoT">
                        <table class='feDif' width='80%' align='center'>
                            <tr>
                                <th colspan="2">
									<?php if(!$TE) { $disableT = "disabled"; ?>
                                        <div class="mensajeRojo">No existe Oficio<br> <a href="?cont=pfrr_oficios">Click aqui para crearlo</a></div>
                                     <?php } ?>
                                    <br><br> 
                                    Notificacion al Presunto<br>
                                </th>
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Oficio:</td>
							

                           
                             </td>	 
                              <td><label for="monto"></label>
                              <input name="oficioT"  type="text"  class="redonda5"  id="oficioT" value="<?php echo $TE['folio'] ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> ></td>
                             </td>	 
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Fecha de Notificación:</td>
                              <td><label for="monto"></label>
                              <input name="notificacionresoT"  type="text"  class="redonda5"  id="notificacionresoT" value="<?php echo $fechaAcuseT ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableT ?>></td>
                             </td>	 
                            </tr>
                        </table>
                          <input name="tipoResolucionTESOFE"    id="tipoResolucionTESOFE" type="hidden" value="<?php echo $tipoRes ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableE ?>></td>
                          <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='Fechatipores("<?php echo $cambiaEdo ?>","<?php echo $tipoRes ?>","tesofe")' <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableT ?>/> </center> </td> </tr>
              </form>
      </div>
                    
         
         
           <!-- -------------- OFICIO SAT-------------------- -->
           <!-- -------------- OFICIO SAT-------------------- -->
           <!-- -------------- OFICIO SAT-------------------- -->
         
         
                   <div id="notificacionTESOFE" class="notiVarias">
                     <form name="NotiresoT">
                        <div align="left"></div>
                        
                        
                        <div id="p7" class="todosContPasos pInactivo">
                          <div style="float:right"></div>
				  
				          <style>
				           .notiVarias{height:fix; float:left; width:290px;}
				          </style>
                        </div>
         
                       
                        <table class='feDif' width='80%' align='center'>
                          <tr>
                            <th colspan="2"> <?php if(!$TE) { $disableT = "disabled"; ?>
                              <div class="mensajeRojo">No existe Oficio<br />
                                <a href="?cont=pfrr_oficios">Click aqui para crearlo</a></div>
                              <?php } ?>
                              <br />
                              <br />
                              Notificacion al SAT<br />
                            </th>
                          </tr>
                          <tr >
                            <td class="etiquetaPo">Oficio:</td>
                            <td><input name="oficioT2"  type="text"  class="redonda5"  id="oficioT2" value="<?php echo $TE['folio'] ?>" readonly="readonly" <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> /></td></td>
                            <td><label for="monto5"></label></td>
                            <td></td></td>
                          </tr>
                          <tr >
                            <td class="etiquetaPo">Fecha de Notificación:</td>
                            <td><label for="monto5"></label>
                              <input name="notificacionresoT2"  type="text"  class="redonda5"  id="notificacionresoT2" value="<?php echo $fechaAcuseT ?>" readonly="readonly" <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableT ?> /></td>
                            <td></td></td>
                          </tr>
                        </table>
                        <input name="tipoResolucionTESOFE2"    id="tipoResolucionTESOFE2" type="hidden" value="<?php echo $tipoRes ?>" readonly="readonly" <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableE ?> />
                        </td>
                        <br />
                        <br />
                       <center>
                          <input type='button' value='Guardar Fecha' class='submit_line' onclick='Fechatipores(&quot;<?php echo $cambiaEdo ?>&quot;,&quot;<?php echo $tipoRes ?>&quot;,&quot;tesofe&quot;)' <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableT ?>/>
                       </center>
                       <p align="right">&nbsp;</p></form>
                   </div>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br /><br /> <br /><br /><br /><br /><br />
                    <br /><br /><br /><br /><br />
                    </div>
                    
                                       
 <!-- -------------- --------------------------------------------- -->
  <!-- -------------- --------------------------------------------- -->
   <!-- -------------- --------------------------------------------- -->
    <!-- -------------- --------------------------------------------- -->                
                    	
        <div id="paso_10" class="divsEdos">
		    <br><br><br><br><br>
	            <h3 align="center"><font size=5>Recurso Admitido</font></h3> 
            <center>
            <br />
                <form name="info_req" id="info_req">
                <table width="60%" class="feDif">
				
					<center>
					<img src="images/warning_red.png" />
					</center> <br><br>
				<h3 align="center"><font size=5>No se pueden realizar cambios</font></h3>
				</table>
                </form>
            </center>
			<br><br><br>
            <br /><br />
        </div>
		
        <div id="paso_11" class="divsEdos">
		    <br><br><br><br><br>
	            <h3 align="center"><font size=5>Recurso Desechado</font></h3> 
            <center>
            <br />
                <form name="info_req" id="info_req">
                <table width="60%" class="feDif">
				
					<center>
					<img src="images/warning_red.png" />
					</center> <br><br>
				<h3 align="center"><font size=5>No se pueden realizar cambios</font></h3>
				</table>
                </form>
            </center>
			<br><br><br>
            <br /><br />
        </div>
    <!-- ------------------------------------------------------------------- -->
	
    </div>
