<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- BUSCAMOS DATOS DE LA ACCION -------------------------------------
$query = "SELECT * FROM medios WHERE id = ".$_REQUEST['idPresuntop']." ";
$sql = $conexion->select($query,false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
//------------------------- BUSCAMOS OFICIO REQUERIMIENTO ------------------------------------
$query = "SELECT oc.folio as ofiFolio, o.fecha_oficio as ofiFecha 
		  FROM oficios_contenido oc 
		  INNER JOIN oficios o ON oc.folio = o.folio 
		  WHERE oc.num_accion = '".$r['num_accion']."' 
		  	AND oc.presunto LIKE '%".$r['nombre']."%' 
			AND tipo = 35 AND o.status <> 0 
			AND oc.juridico = 1 LIMIT 1";
$sql = $conexion->select($query,false);
$ro = mysql_fetch_array($sql);
$totOfirec = mysql_num_rows($sql);
//------------------------- BUSCAMOS OFICIO ADMISION ------------------------------------
$query = "SELECT oc.folio as ofiFolio, o.fecha_oficio as ofiFecha,tipo FROM oficios_contenido oc INNER JOIN oficios o ON oc.folio = o.folio WHERE oc.num_accion = '".$r['num_accion']."' AND oc.presunto LIKE '%".$r['nombre']."%' AND (tipo = 34 OR tipo = 36) AND o.status <> 0 AND oc.juridico = 1 LIMIT 1";
$sql = $conexion->select($query,false);
$roi = mysql_fetch_array($sql);
$totOfiInt = mysql_num_rows($sql);
if($totOfiInt) $tipoOfi = ($roi["tipo"] == 34) ? "ADMISIÓN" : "DESECHAMIENTO"; 
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
  $$("#btnEdo33").click(function(){

	  	var datosUrl = $$("#formRecursoRec").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formRecursoRec"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(35); ?> \n\n ¿Desea continuar?");
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
  //---- EDO 34 o 36 ACUERDO DE ADMISION Y DESAHOGO DE PRUEBAS DEL RR--------------------------
  $$("#btnAdmDes").click(function(){

	  	var datosUrl = $$("#formAdmDes").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formAdmDes"))
		{
			if($$("#tipoAdm").val() == "admision") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(34); ?> \n\n ¿Desea continuar?");
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
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						alert(datos)
						if($$("#tipoAdm").val() == "admision") {
							new mostrarCuadro2(200,500,"Número de Recurso de Reconsideración generado...",150)
							$$("#cuadroRes2").html(datos);
						}
						cerrarCuadro();
					}
				});
			}
		}
  });
  //---- EDO 37 o 39 ACUERDO DE ADMISION Y DESAHOGO DE PRUEBAS DEL RR--------------------------
  $$("#btnEdo37o39").click(function(){

	  	var datosUrl = $$("#formNotAdmDes").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
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
/*
function muestraDivEdo(id)
{
	$$(".divsEdos").hide();
	$$("#divIntro").hide();
	//$$(".menu_Medios").slideUp();
	$$(".menu_Medios").fadeOut();
	$$("#"+id).fadeIn();
}
*/
function validaAcuerdo(valor){
	if(valor == "admision"){
		$$("#labelAdmDes").html("Fecha de Acuerdo de Admisión del<br> Recurso de Reconsideración");	
		$$("#contAdmDes").html("<input type='text' name='fechaAdmDes' id='fechaAdmDes'  class='redonda5' /> ");	
		
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
		$$("#contAdmDes").html("<textarea cols='50' rows='4' name='motivoAdmDes' id='motivoAdmDes' class='redonda5'> </textarea>");	
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
//---------------------------------------------------------------------------
if($r['estado'] == 33 || $r['estado'] == 35)
{
	$onclickP2 = "onclick=\"muestraPestana(2)\"";	
	$onclickP8 = "onclick=\"muestraPestana(8)\"";	
	
	$txtPaso2 = "pasosActivo";
	$acceso2 = "pfAccesible";
	$acceso8 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#paso_2').fadeIn();	});	</script>";
}
if($r['estado'] == 34 || $r['estado'] == 36)
{
	$onclickP3 = "onclick=\"muestraPestana(3)\"";	
	
	$txtPaso3 = "pasosActivo";
	$acceso3 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#paso_3').fadeIn();	});	</script>";
}
/*
if($r['estado'] == 37 || $r['estado'] == 39)
{
	$onclickP4 = "onclick=\"muestraPestana(4)\"";	
	
	$txtPaso4 = "pasosActivo";
	$acceso4 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#paso_4').fadeIn();	});	</script>";
}
*/
//if($r['estado'] == 37 || $r['estado'] == 39 || $r['estado'] == 38 || $r['estado'] == 46)
if($r['estado'] == 37 || $r['estado'] == 46)
{
	$onclickP5 = "onclick=\"muestraPestana(5)\"";	
	
	$txtPaso5 = "pasosActivo";
	$acceso5 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#paso_5').fadeIn();	});	</script>";
}
if($r['estado'] == 40)
{
	$onclickP6 = "onclick=\"muestraPestana(6)\"";	
	
	$txtPaso6 = "pasosActivo";
	$acceso6 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#paso_6').fadeIn();	});	</script>";
}
if($r['estado'] == 41 || $r['estado'] == 42 || $r['estado'] == 47)
//if($r['estado'] == 47)
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
	$onclickP1 = " onclick=\"muestraDivEdo('paso_1')\" ";
	$onclickP2 = " onclick=\"muestraDivEdo('paso_2')\" ";
	$onclickP3 = " onclick=\"muestraDivEdo('paso_3')\" ";
	$onclickP4 = " onclick=\"muestraDivEdo('paso_4')\" ";
	$onclickP5 = " onclick=\"muestraDivEdo('paso_5')\" ";
	$onclickP6 = " onclick=\"muestraDivEdo('paso_6')\" ";
	$onclickP7 = " onclick=\"muestraDivEdo('paso_7')\" ";
	$onclickP8 = " onclick=\"muestraDivEdo('paso_8')\" ";
	$onclickP9 = " onclick=\"muestraDivEdo('paso_9')\" ";
	
	$txtPaso1 = " pasosActivo ";
	$txtPaso2 = " pasosActivo ";
	$txtPaso3 = " pasosActivo ";
	$txtPaso4 = " pasosActivo ";
	$txtPaso5 = " pasosActivo ";
	$txtPaso6 = " pasosActivo ";
	$txtPaso7 = " pasosActivo ";
	$txtPaso8 = " pasosActivo ";
	$txtPaso9 = " pasosActivo ";
	
	$acceso1 = " pfAccesible ";
	$acceso2 = " pfAccesible ";
	$acceso3 = " pfAccesible ";
	$acceso4 = " pfAccesible ";
	$acceso5 = " pfAccesible ";
	$acceso6 = " pfAccesible ";
	$acceso7 = " pfAccesible ";
	$acceso8 = " pfAccesible ";
	$acceso9 = " pfAccesible ";
}
?>
<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"> INFORMACIÓN</div>
       <div id='paso8' <?php echo $onclickP8 ?> class="todosPasos <?php echo $txtPaso8 ?> <?php echo $acceso8 ?> pasos"> ADMISIÓN / DESECHAMIENTO </div>
       <div id='paso3' <?php echo $onclickP3 ?> class="todosPasos <?php echo $txtPaso3 ?> <?php echo $acceso3 ?> pasos"> NOTIFICACIÓN</div>
       <!-- <div id='paso4' <?php echo $onclickP4 ?> class="todosPasos <?php echo $txtPaso4 ?> <?php echo $acceso4 ?> pasos"> ESTUDIO DEL ET </div> -->
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
        <div id='paso_2' class="divsEdos">
            <h3>Solicitar Información al Recurrente</h3>
            <div align="center">
            	 <br /> 
                <form name="formRecursoRec" id="formRecursoRec">
                <table width="70%" class="feDif">
                    <tr>
                        <td colspan="2">
                         <?php if($totOfirec == 0) {  ?>
                            <div class="mensajeRojo">No existe Oficio... <a href="">Click aqui para crearlo</a></div>
                         <?php } ?>
                        </td>

                    </tr>
                    <tr>
                        <td class="etiquetaPo">Oficio de requerimiento<br /> de información:</td>
                        <td><input type="text" name="oficio_req" id="oficio_req" class="redonda5" value="<?php echo $ro['ofiFolio'] ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="fecha_oficio_req" id="fecha_oficio_req" class="redonda5" value="<?php echo fechaNormal($ro['ofiFecha']) ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Notificación del Oficio:</td>
                        <td><input type="text" name="fecha_acuse_oficio_req" id="fecha_acuse_oficio_req" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_reqRecRec" />
                            <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnEdo33" />
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            <br /> <br /> <br />
        </div>
        <!-- -------------- EDO TRAMITE 34 o 36 ADMISIÓN / DESECHAMIENTO -------------------- -->
        <!-- -------------- EDO TRAMITE 34 o 36 ADMISIÓN / DESECHAMIENTO-------------------- -->
        <div id='paso_8' class="divsEdos">
            <h3>Admisión o Desechamiento del Recurso de Reconsideración</h3>
            <center>
            <br />
                <form name="formAdmDes" id="formAdmDes">
                <table width="60%" class="feDif">
                    <tr>
                        <td class="etiquetaPo">Tipo de Acuerdo:</td>
                        <td>
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
        <!-- -------------- EDO TRAMITE 37 o 39 NOTIFICACIÓN ADMISIÓN / DESECHAMIENTO -------------------- -->
        <!-- -------------- EDO TRAMITE 37 o 39 NOTIFICACIÓN ADMISIÓN / DESECHAMIENTO-------------------- -->
        <div id='paso_3' class="divsEdos">
            <h3>Notificación de Admisión o Desechamiento</h3>
            <div align="center">
            	 <br /> 
                <form name="formNotAdmDes" id="formNotAdmDes">
                <table width="70%" class="feDif">
                    <tr>
                        <td colspan="3">
                         <?php if( $tipoOfi == "") { $disableI = "disabled"; ?>
                            <div class="mensajeRojo">No existe Oficio... <a href="">Click aqui para crearlo</a></div>
                         <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Tipo de Oficio:</td>
                        <td><input type="text" name="oficio_tipo_AD" id="oficio_tipo_AD" class="redonda5" value="<?php echo $tipoOfi ?>" readonly="readonly" size="21" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Oficio:</td>
                        <td><input type="text" name="oficio_AD" id="oficio_AD" class="redonda5"  value="<?php echo $roi['ofiFolio'] ?>" readonly="readonly" size="21" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="fecha_oficio_AD" id="fecha_oficio_AD" class="redonda5" value="<?php echo fechaNormal($roi['ofiFecha']) ?>" readonly="readonly" size="21"/></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Notificación del Oficio:</td>
                        <td><input type="text" name="fecha_acuse_oficio_AD" id="fecha_acuse_oficio_AD" class="redonda5"  size="21"/></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Tipo de Notificación:</td>
                        <td>
                        	<select name="tipoNotAdmDes" id="tipoNotAdmDes" class="redonda5">
                            	<option value="">Selecciona notificación...</option>
                            	<option value="personal">Personal</option>
                            	<option value="rotulon">Rotulón</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_NotAdmDes" />
                            <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnEdo37o39" />
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            <br /> <br /> 
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
            <h3>Resolución del Recurso de Reconsideración </h3>
            <center>
            <br />
                <form name="formCierreIns" id="formCierreIns">
                <table width="60%" class="feDif">
                    <tr>
                        <td class="etiquetaPo">Fecha del <br />cierre de instrucción:</td>
                        <td><input type="text" name="fecha_cierre_ins" id="fecha_cierre_ins" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_cierreIns" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnCierreIns"/>
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
            <h3>Resolución del Recurso de Reconsideración</h3>
            <center>
            <br />
                <form name="formEmiRes" id="formEmiRes">
                <table width="60%" class="feDif">
                    <tr>
                        <td class="etiquetaPo">Resolución:</td>
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
                        <td colspan="2" align="center"><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_EmiRes" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnEmiRes"/>
                        </td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
        </div>
        <!-- -------------- EDO TRAMITE 39-------------------- -->
        <!-- -------------- EDO TRAMITE 39-------------------- -->
        <div id='paso_7' class="divsEdos">
            <h3>Notificación de la Resolución</h3>
            <center>
            <br />
                <form name="formNotRes" id="formNotRes">
                <table width="60%" class="feDif">
                    <tr>
                        <td class="etiquetaPo">Fecha de la notificación <br />de la Resolución:</td>
                        <td><input type="text" name="fecha_not_res" id="fecha_not_res" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Tipo Notificación:</td>
                        <td>
                        	<select name="tipoNotRes" id="tipoNotRes" class="redonda5">
                            	<option value="">Seleccione una opcion... </option>
                            	<option value="rotulon"> Rotulón </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_NotRes" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnNotRes"/>
                        </td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
        </div>
    <!-- ------------------------------------------------------------------- -->    
    </div>
